<?php

namespace Hurah\Canvas\Endpoints\Attachment;

use Hurah\Canvas\Endpoints\CanvasObject;
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
    protected ?string $uuid = null;
    protected ?int $folder_id = null;
    protected ?string $display_name = null;
    protected ?string $filename = null;
    protected ?string $upload_status = null;
    protected ?string $content_type = null;
    protected ?string $url = null;
    protected ?int $size = null;
    protected ?DateTime $created_at = null;
    protected ?DateTime $updated_at = null;
    protected ?DateTime $unlock_at = null;
    protected ?DateTime $lock_at = null;
    protected ?DateTime $modified_at = null;

    protected ?bool $locked = null;
    protected ?bool $hidden = null;
    protected ?bool $hidden_for_user = null;
    protected ?string $thumbnail_url = null;
    protected ?string $mime_class = null;
    protected ?string $media_entry_id = null;
    protected ?string $category = null;
    protected ?bool $locked_for_user = null;
    protected ?string $preview_url = null;

    /** Getters and fluent setters for each property **/
    /**
     * @param array $array
     * @return self
     * 2*/
    public static function fromCanvasArray(array $array): self
    {
        $instance = new self();

        foreach ($array as $key => $value) {


            $method = 'set' . Util::underscoreToCamelCase($key, true);
            self::_setValue($instance, $key, $method, $value);
        }

        return $instance;
    }
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }

    public function getUuid(): ?string { return $this->uuid; }
    public function setUuid(?string $uuid): self { $this->uuid = $uuid; return $this; }

    public function getFolderId(): ?int { return $this->folder_id; }
    public function setFolderId(?int $folder_id): self { $this->folder_id = $folder_id; return $this; }

    public function getDisplayName(): ?string { return $this->display_name; }
    public function setDisplayName(?string $display_name): self { $this->display_name = $display_name; return $this; }

    public function getFilename(): ?string { return $this->filename; }
    public function setFilename(?string $filename): self { $this->filename = $filename; return $this; }

    public function getUploadStatus(): ?string { return $this->upload_status; }
    public function setUploadStatus(?string $upload_status): self { $this->upload_status = $upload_status; return $this; }

    public function getContentType(): ?string { return $this->content_type; }
    public function setContentType(?string $content_type): self { $this->content_type = $content_type; return $this; }

    public function getUrl(): ?string { return $this->url; }
    public function setUrl(?string $url): self { $this->url = $url; return $this; }

    public function getSize(): ?int { return $this->size; }
    public function setSize(?int $size): self { $this->size = $size; return $this; }

    public function getCreatedAt(): ?DateTime { return $this->created_at; }
    public function setCreatedAt(?string $created_at): self { $this->created_at = $created_at; return $this; }

    public function getUpdatedAt(): ?DateTime { return $this->updated_at; }
    public function setUpdatedAt(?string $updated_at): self { $this->updated_at = $updated_at; return $this; }

    public function getUnlockAt(): ?DateTime { return $this->unlock_at; }
    public function setUnlockAt(?string $unlock_at): self { $this->unlock_at = $unlock_at; return $this; }

    public function isLocked(): ?bool { return $this->locked; }
    public function setLocked(?bool $locked): self { $this->locked = $locked; return $this; }

    public function isHidden(): ?bool { return $this->hidden; }
    public function setHidden(?bool $hidden): self { $this->hidden = $hidden; return $this; }

    public function getLockAt(): ?DateTime { return $this->lock_at; }
    public function setLockAt(?string $lock_at): self { $this->lock_at = $lock_at; return $this; }

    public function isHiddenForUser(): ?bool { return $this->hidden_for_user; }
    public function setHiddenForUser(?bool $hidden_for_user): self { $this->hidden_for_user = $hidden_for_user; return $this; }

    public function getThumbnailUrl(): ?string { return $this->thumbnail_url; }
    public function setThumbnailUrl(?string $thumbnail_url): self { $this->thumbnail_url = $thumbnail_url; return $this; }

    public function getModifiedAt(): ?DateTime { return $this->modified_at; }
    public function setModifiedAt(?string $modified_at): self { $this->modified_at = $modified_at; return $this; }

    public function getMimeClass(): ?string { return $this->mime_class; }
    public function setMimeClass(?string $mime_class): self { $this->mime_class = $mime_class; return $this; }

    public function getMediaEntryId(): ?string { return $this->media_entry_id; }
    public function setMediaEntryId(?string $media_entry_id): self { $this->media_entry_id = $media_entry_id; return $this; }

    public function getCategory(): ?string { return $this->category; }
    public function setCategory(?string $category): self { $this->category = $category; return $this; }

    public function isLockedForUser(): ?bool { return $this->locked_for_user; }
    public function setLockedForUser(?bool $locked_for_user): self { $this->locked_for_user = $locked_for_user; return $this; }

    public function getPreviewUrl(): ?string { return $this->preview_url; }
    public function setPreviewUrl(?string $preview_url): self { $this->preview_url = $preview_url; return $this; }
}
