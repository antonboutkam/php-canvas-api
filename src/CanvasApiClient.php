<?php

declare(strict_types=1);

namespace Hurah\Canvas;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

final class CanvasApiClient
{
    private ClientInterface $client;
    private string $baseUrl;
    private string $token;

    public function __construct(
        ?string $baseUrl = null,
        #[\SensitiveParameter] ?string $token = null,
        ?ClientInterface $client = null
    )
    {
        $baseUrl = $baseUrl ?? (string)($_ENV['CANVAS_URL'] ?? '');
        $token = $token ?? (string)($_ENV['CANVAS_API'] ?? '');

        $baseUrl = rtrim(trim($baseUrl), '/');
        $token = trim($token);

        if ($baseUrl === '' || $token === '') {
            throw new \RuntimeException('Canvas configuratie ontbreekt. Zet CANVAS_URL en CANVAS_API in `.env`.');
        }

        $this->baseUrl = $baseUrl;
        $this->token = $token;
        $this->client = $client ?? new Client([
            'timeout' => 60,
            'connect_timeout' => 15,
            'http_errors' => true,
            'allow_redirects' => true,
        ]);
    }

    /**
     * Redact secrets when this object ends up in stack traces/debug dumps.
     *
     * @return array<string,mixed>
     */
    public function __debugInfo(): array
    {
        return [
            'client' => Client::class,
            'baseUrl' => $this->baseUrl,
            'token' => '[redacted]',
        ];
    }

    /**
     * @return array<mixed>
     */
    public function getAll(string $path, array $query = []): array
    {
        $url = $this->normalizeUrl($path, $query, true);
        $items = [];

        while ($url !== null) {
            [$data, $nextUrl] = $this->getJsonWithNextLink($url);

            if (is_array($data)) {
                if (array_is_list($data)) {
                    $items = array_merge($items, $data);
                } else {
                    $items[] = $data;
                }
            }

            $url = $nextUrl;
        }

        return $items;
    }

    /**
     * @return array<string,mixed>
     */
    public function getOne(string $pathOrUrl, array $query = []): array
    {
        $url = $this->normalizeUrl($pathOrUrl, $query, true);
        [$data] = $this->getJsonWithNextLink($url);
        if (!is_array($data) || array_is_list($data)) {
            throw new \RuntimeException("Unexpected Canvas response for {$url} (expected object).");
        }
        /** @var array<string,mixed> $data */
        return $data;
    }

    public function downloadTo(string $url, string $destFile): void
    {
        $dir = dirname($destFile);
        if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new \RuntimeException("Kon map niet aanmaken: {$dir}");
        }

        try {
            $this->client->request('GET', $url, [
                'headers' => $this->authHeaders(),
                'sink' => $destFile,
            ]);
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Canvas request failed: GET {$url}: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * @return array<string,mixed>
     */
    public function post(string $path, array $formParams = []): array
    {
        return $this->requestObject('POST', $path, $formParams);
    }

    /**
     * @return array<string,mixed>
     */
    public function put(string $path, array $formParams = []): array
    {
        return $this->requestObject('PUT', $path, $formParams);
    }

    /**
     * @return array<string,mixed>
     */
    public function delete(string $path, array $formParams = []): array
    {
        return $this->requestObject('DELETE', $path, $formParams);
    }

    /**
     * Upload a local file into a Canvas course folder and return the created/updated Canvas file object.
     *
     * @return array<string,mixed>
     */
    public function uploadCourseFile(
        int $courseId,
        string $localPath,
        string $parentFolderPath,
        ?string $fileName = null,
        ?string $contentType = null
    ): array {
        if ($courseId < 1) {
            throw new \InvalidArgumentException('Invalid Canvas course id.');
        }
        if (!is_file($localPath)) {
            throw new \RuntimeException("Local file not found: {$localPath}");
        }

        $size = filesize($localPath);
        if ($size === false) {
            throw new \RuntimeException("Could not determine filesize: {$localPath}");
        }

        $fileName = trim((string)($fileName ?? basename($localPath)));
        if ($fileName === '') {
            throw new \RuntimeException("Invalid file name for {$localPath}");
        }

        $contentType = trim((string)($contentType ?? $this->guessMimeType($localPath)));
        if ($contentType === '') {
            $contentType = 'application/octet-stream';
        }

        $prep = $this->post("/courses/{$courseId}/files", [
            'name' => $fileName,
            'size' => (string)$size,
            'content_type' => $contentType,
            'parent_folder_path' => trim($parentFolderPath, '/'),
            'on_duplicate' => 'overwrite',
            'no_redirect' => 'true',
        ]);

        $uploadUrl = trim((string)($prep['upload_url'] ?? ''));
        $uploadParams = $prep['upload_params'] ?? [];
        if ($uploadUrl === '' || !is_array($uploadParams)) {
            throw new \RuntimeException('Canvas file upload prepare step returned no upload_url/upload_params.');
        }

        return $this->uploadPreparedFile($uploadUrl, $uploadParams, $localPath, $fileName, $contentType);
    }

    /**
     * @return array<string,mixed>
     */
    private function requestObject(string $method, string $pathOrUrl, array $formParams = []): array
    {
        $url = $this->normalizeUrl($pathOrUrl, [], true);
        $options = [
            'headers' => $this->authHeaders(),
        ];
        if ($formParams !== []) {
            // Canvas expects array params like assignment[submission_types][].
            // Guzzle/PHP `form_params` encodes list arrays as [0], [1], which Canvas may parse as an object/hash.
            $options['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
            $options['body'] = $this->buildFormBody($formParams);
        }

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Canvas request failed: {$method} {$url}: {$e->getMessage()}", 0, $e);
        }

        return $this->decodeObjectResponse($method, $url, $response);
    }

    /**
     * @param array<string,mixed> $uploadParams
     * @return array<string,mixed>
     */
    private function uploadPreparedFile(
        string $uploadUrl,
        array $uploadParams,
        string $localPath,
        string $fileName,
        string $contentType
    ): array {
        $multipart = [];
        foreach ($uploadParams as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $multipart[] = [
                        'name' => (string)$key . '[]',
                        'contents' => is_scalar($item) ? (string)$item : ((json_encode($item) ?: '')),
                    ];
                }
                continue;
            }

            $multipart[] = [
                'name' => (string)$key,
                'contents' => is_scalar($value) || $value === null ? (string)$value : (json_encode($value) ?: ''),
            ];
        }

        $handle = fopen($localPath, 'rb');
        if (!is_resource($handle)) {
            throw new \RuntimeException("Cannot open file for upload: {$localPath}");
        }

        try {
            $multipart[] = [
                'name' => 'file',
                'contents' => $handle,
                'filename' => $fileName,
                'headers' => [
                    'Content-Type' => $contentType,
                ],
            ];

            try {
                $response = $this->client->request('POST', $uploadUrl, [
                    'multipart' => $multipart,
                    // Canvas/S3 signed upload URL should not carry Canvas Bearer auth.
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'http_errors' => true,
                    'allow_redirects' => true,
                ]);
            } catch (GuzzleException $e) {
                throw new \RuntimeException("Canvas file upload failed: POST {$uploadUrl}: {$e->getMessage()}", 0, $e);
            }
        } finally {
            if (is_resource($handle)) {
                fclose($handle);
            }
        }

        return $this->decodeObjectResponse('POST', $uploadUrl, $response);
    }

    private function buildFormBody(array $data): string
    {
        $pairs = [];
        $this->flattenFormPairs($pairs, null, $data);

        $chunks = [];
        foreach ($pairs as [$key, $value]) {
            $chunks[] = rawurlencode($key) . '=' . rawurlencode($value);
        }

        return implode('&', $chunks);
    }

    /**
     * @param list<array{0:string,1:string}> $pairs
     * @param mixed $value
     */
    private function flattenFormPairs(array &$pairs, ?string $prefix, mixed $value): void
    {
        if (is_array($value)) {
            if ($value === []) {
                return;
            }

            if (array_is_list($value)) {
                foreach ($value as $item) {
                    $key = $prefix === null ? '[]' : $prefix . '[]';
                    $this->flattenFormPairs($pairs, $key, $item);
                }
                return;
            }

            foreach ($value as $k => $item) {
                $key = $prefix === null ? (string)$k : $prefix . '[' . (string)$k . ']';
                $this->flattenFormPairs($pairs, $key, $item);
            }
            return;
        }

        if ($prefix === null) {
            throw new \InvalidArgumentException('Top-level scalar form value is not supported.');
        }

        if (is_bool($value)) {
            $scalar = $value ? '1' : '0';
        } elseif ($value === null) {
            $scalar = '';
        } else {
            $scalar = (string)$value;
        }

        $pairs[] = [$prefix, $scalar];
    }

    /**
     * @return array{0:mixed,1:?string}
     */
    private function getJsonWithNextLink(string $url): array
    {
        try {
            $response = $this->client->request('GET', $url, [
                'headers' => $this->authHeaders(),
            ]);
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Canvas request failed: GET {$url}: {$e->getMessage()}", 0, $e);
        }

        $body = (string)$response->getBody();
        $data = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Canvas returned invalid JSON for {$url}: " . json_last_error_msg());
        }

        $linkHeader = $response->getHeaderLine('Link');
        $nextUrl = $this->extractNextLink($linkHeader);

        return [$data, $nextUrl];
    }

    /**
     * @return array<string,mixed>
     */
    private function decodeObjectResponse(string $method, string $url, ResponseInterface $response): array
    {
        $body = (string)$response->getBody();
        if (trim($body) === '') {
            if (strtoupper($method) === 'DELETE' || $response->getStatusCode() === 204) {
                return [];
            }
            throw new \RuntimeException("Canvas returned empty response for {$method} {$url}.");
        }
        $data = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Canvas returned invalid JSON for {$method} {$url}: " . json_last_error_msg());
        }
        if (!is_array($data) || array_is_list($data)) {
            throw new \RuntimeException("Unexpected Canvas response for {$method} {$url} (expected object).");
        }
        /** @var array<string,mixed> $data */
        return $data;
    }

    /**
     * @return array<string,string>
     */
    private function authHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ];
    }

    private function guessMimeType(string $path): string
    {
        if (function_exists('finfo_open')) {
            $finfo = @finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $mime = @finfo_file($finfo, $path);
                @finfo_close($finfo);
                if (is_string($mime) && trim($mime) !== '') {
                    return trim($mime);
                }
            }
        }

        if (function_exists('mime_content_type')) {
            $mime = @mime_content_type($path);
            if (is_string($mime) && trim($mime) !== '') {
                return trim($mime);
            }
        }

        return 'application/octet-stream';
    }

    private function normalizeUrl(string $pathOrUrl, array $query, bool $ensureApiV1): string
    {
        $pathOrUrl = trim($pathOrUrl);
        if ($pathOrUrl === '') {
            throw new \InvalidArgumentException('Canvas path/url is empty');
        }

        if (preg_match('#^https?://#i', $pathOrUrl)) {
            $url = $pathOrUrl;
        } else {
            $path = $pathOrUrl;
            if (!str_starts_with($path, '/')) {
                $path = '/' . $path;
            }
            if ($ensureApiV1 && !str_starts_with($path, '/api/v1/')) {
                $path = '/api/v1' . $path;
            }
            $url = $this->baseUrl . $path;
        }

        if ($query) {
            $separator = str_contains($url, '?') ? '&' : '?';
            $url .= $separator . http_build_query($query);
        }

        return $url;
    }

    private function extractNextLink(string $linkHeader): ?string
    {
        if (trim($linkHeader) === '') {
            return null;
        }

        foreach (explode(',', $linkHeader) as $part) {
            $part = trim($part);
            if (preg_match('/<([^>]+)>\\s*;\\s*rel=\"next\"/i', $part, $m)) {
                return $m[1] ?? null;
            }
        }

        return null;
    }
}
