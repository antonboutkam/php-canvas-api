<?php

declare(strict_types=1);

namespace Hurah\Canvas\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Hurah\Canvas\CanvasApiClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

final class CanvasApiClientTest extends TestCase
{
    /**
     * @param list<Response> $responses
     * @param list<array<string,mixed>> $history
     */
    private function client(array $responses, array &$history): CanvasApiClient
    {
        $mock = new MockHandler($responses);
        $historyMiddleware = Middleware::history($history);
        $stack = HandlerStack::create($mock);
        $stack->push($historyMiddleware);

        return new CanvasApiClient(
            'https://canvas.example.test',
            'secret-token',
            new Client(['handler' => $stack])
        );
    }

    public function testGetAllFollowsCanvasNextLinkAndSendsBearerToken(): void
    {
        $history = [];
        $client = $this->client([
            new Response(200, ['Link' => '<https://canvas.example.test/api/v1/courses?page=2>; rel="next"'], '[{"id":1}]'),
            new Response(200, [], '[{"id":2}]'),
        ], $history);

        self::assertSame([
            ['id' => 1],
            ['id' => 2],
        ], $client->getAll('/courses', ['per_page' => 100]));

        self::assertCount(2, $history);
        self::assertSame('Bearer secret-token', $history[0]['request']->getHeaderLine('Authorization'));
        self::assertSame('/api/v1/courses?per_page=100', $history[0]['request']->getUri()->getPath() . '?' . $history[0]['request']->getUri()->getQuery());
        self::assertSame('/api/v1/courses', $history[1]['request']->getUri()->getPath());
    }

    public function testPostEncodesNestedCanvasFormFields(): void
    {
        $history = [];
        $client = $this->client([
            new Response(200, [], '{"id":42,"name":"Example"}'),
        ], $history);

        self::assertSame(
            ['id' => 42, 'name' => 'Example'],
            $client->post('/courses/12/assignments', [
                'assignment' => [
                    'name' => 'Example',
                    'submission_types' => ['online_text_entry', 'online_upload'],
                    'published' => true,
                ],
            ])
        );

        /** @var RequestInterface $request */
        $request = $history[0]['request'];
        self::assertSame('assignment%5Bname%5D=Example&assignment%5Bsubmission_types%5D%5B%5D=online_text_entry&assignment%5Bsubmission_types%5D%5B%5D=online_upload&assignment%5Bpublished%5D=1', (string)$request->getBody());
        self::assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
    }

    public function testDownloadToWritesCanvasResponseToDestination(): void
    {
        $history = [];
        $client = $this->client([
            new Response(200, [], 'downloaded content'),
        ], $history);
        $destination = tempnam(sys_get_temp_dir(), 'canvas-api-test-');
        self::assertNotFalse($destination);

        try {
            $client->downloadTo('https://canvas.example.test/files/7/download', $destination);

            self::assertSame('downloaded content', file_get_contents($destination));
            self::assertSame('Bearer secret-token', $history[0]['request']->getHeaderLine('Authorization'));
        } finally {
            if (is_string($destination) && is_file($destination)) {
                unlink($destination);
            }
        }
    }

    public function testUploadCourseFilePerformsPrepareAndMultipartUpload(): void
    {
        $history = [];
        $client = $this->client([
            new Response(200, [], '{"upload_url":"https://uploads.example.test/signed","upload_params":{"key":"course/file.txt","policy":"policy"}}'),
            new Response(200, [], '{"id":7,"filename":"file.txt"}'),
        ], $history);
        $source = tempnam(sys_get_temp_dir(), 'canvas-api-upload-');
        self::assertNotFalse($source);
        file_put_contents($source, 'payload');

        try {
            self::assertSame(
                ['id' => 7, 'filename' => 'file.txt'],
                $client->uploadCourseFile(12, $source, 'assets')
            );
            self::assertCount(2, $history);
            self::assertSame('Bearer secret-token', $history[0]['request']->getHeaderLine('Authorization'));
            self::assertSame('', $history[1]['request']->getHeaderLine('Authorization'));
            self::assertSame('https://uploads.example.test/signed', (string)$history[1]['request']->getUri());
            self::assertStringStartsWith('multipart/form-data; boundary=', $history[1]['request']->getHeaderLine('Content-Type'));
        } finally {
            if (is_string($source) && is_file($source)) {
                unlink($source);
            }
        }
    }
}
