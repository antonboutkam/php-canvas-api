<?php

namespace Hurah\Canvas\Endpoints\File;

use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Canvas\Endpoints\Folder\Folder;
use Hurah\Canvas\Util;
use Hurah\Types\Type\DateTime;

/**
 * Class representing an attachment in the Canvas system.
 *
 * Provides getters and fluent setters for all properties.
 */
class File extends CanvasObject
{
    protected ?int $id = null;
    protected ?int $size = null;

    protected ?int $folderId = null;
    protected ?string $mediaEntryId = null;
    protected ?string $uuid = null;

    protected ?string $uploadStatus = null;

    protected ?string $previewUrl = null;

    protected ?string $mimeClass = null;

    protected ?string $visibilityLevel = null;

    protected ?string $category = null;

    protected ?string $contentType = null;

    protected ?string $url = null;

    protected ?string $displayName = null;
    protected ?string $fileName = null;

    protected ?DateTime $created_at = null;
    protected ?DateTime $updated_at = null;
    protected ?DateTime $modified_at = null;

    /** Getters and fluent setters for each property **/

    public static function fromCanvasArray(array $array): self
    {
        $instance = new self();

        foreach ($array as $key => $value) {
            $method = 'set' . Util::underscoreToCamelCase($key, true);
            self::_setValue($instance, $key, $method, $value);
        }

        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): File
    {
        $this->id = $id;
        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): File
    {
        $this->size = $size;
        return $this;
    }

    public function getFolderId(): ?int
    {
        return $this->folderId;
    }

    public function setFolderId(?int $folderId): File
    {
        $this->folderId = $folderId;
        return $this;
    }

    public function getMediaEntryId(): ?string
    {
        return $this->mediaEntryId;
    }

    public function setMediaEntryId(?string $mediaEntryId): File
    {
        $this->mediaEntryId = $mediaEntryId;
        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): File
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUploadStatus(): ?string
    {
        return $this->uploadStatus;
    }

    public function setUploadStatus(?string $uploadStatus): File
    {
        $this->uploadStatus = $uploadStatus;
        return $this;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function setPreviewUrl(?string $previewUrl): File
    {
        $this->previewUrl = $previewUrl;
        return $this;
    }

    public function getMimeClass(): ?string
    {
        return $this->mimeClass;
    }

    public function setMimeClass(?string $mimeClass): File
    {
        $this->mimeClass = $mimeClass;
        return $this;
    }

    public function getVisibilityLevel(): ?string
    {
        return $this->visibilityLevel;
    }

    public function setVisibilityLevel(?string $visibilityLevel): File
    {
        $this->visibilityLevel = $visibilityLevel;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): File
    {
        $this->category = $category;
        return $this;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function setContentType(?string $contentType): File
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): File
    {
        $this->url = $url;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFilename(?string $fileName): File
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): File
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): File
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): File
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getModifiedAt(): ?DateTime
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?DateTime $modified_at): File
    {
        $this->modified_at = $modified_at;
        return $this;
    }
}
