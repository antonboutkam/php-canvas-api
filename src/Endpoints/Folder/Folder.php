<?php

namespace Hurah\Canvas\Endpoints\Folder;

use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Canvas\Util;
use Hurah\Types\Type\DateTime;

/**
 * Class representing an attachment in the Canvas system.
 *
 * Provides getters and fluent setters for all properties.
 */
class Folder extends CanvasObject
{
// Properties
    protected ?string $contextType = null;
    protected ?int $contextId = null;
    protected ?int $filesCount = null;
    protected ?int $position = null;
    protected ?\DateTime $updatedAt = null;
    protected ?string $foldersUrl = null;
    protected ?string $filesUrl = null;
    protected ?string $fullName = null;
    protected ?\DateTime $lockAt = null;
    protected ?int $id = null;
    protected ?int $foldersCount = null;
    protected ?string $name = null;
    protected ?int $parentFolderId = null;

    protected ?string $parent_folder_path = null;

    protected ?\DateTime $createdAt = null;
    protected ?\DateTime $unlockAt = null;
    protected ?bool $hidden = null;
    protected ?bool $hiddenForUser = null;
    protected ?bool $locked = null;
    protected ?bool $lockedForUser = null;
    protected ?bool $forSubmissions = null;

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

    // Getters & Setters
    public function toCanvasArray():array
    {
        return array_filter($this->toArray());
    }
    /**
     * @return string|null
     */
    public function getParentFolderPath(): ?string
    {
        return $this->parent_folder_path;
    }

    /**
     * @param string|null $parent_folder_path
     * @return Folder
     */
    public function setParentFolderPath(?string $parent_folder_path): Folder
    {
        $this->parent_folder_path = $parent_folder_path;
        return $this;
    }

    public function setContextType(?string $contextType): self {
        $this->contextType = $contextType;
        return $this;
    }
    public function getContextType(): ?string {
        return $this->contextType;
    }

    public function setContextId(?int $contextId): self {
        $this->contextId = $contextId;
        return $this;
    }
    public function getContextId(): ?int {
        return $this->contextId;
    }

    public function setFilesCount(?int $filesCount): self {
        $this->filesCount = $filesCount;
        return $this;
    }
    public function getFilesCount(): ?int {
        return $this->filesCount;
    }

    public function setPosition(?int $position): self {
        $this->position = $position;
        return $this;
    }
    public function getPosition(): ?int {
        return $this->position;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    public function getUpdatedAt(): ?\DateTime {
        return $this->updatedAt;
    }

    public function setFoldersUrl(?string $foldersUrl): self {
        $this->foldersUrl = $foldersUrl;
        return $this;
    }
    public function getFoldersUrl(): ?string {
        return $this->foldersUrl;
    }

    public function setFilesUrl(?string $filesUrl): self {
        $this->filesUrl = $filesUrl;
        return $this;
    }
    public function getFilesUrl(): ?string {
        return $this->filesUrl;
    }

    public function setFullName(?string $fullName): self {
        $this->fullName = $fullName;
        return $this;
    }
    public function getFullName(): ?string {
        return $this->fullName;
    }

    public function setLockAt(?\DateTime $lockAt): self {
        $this->lockAt = $lockAt;
        return $this;
    }
    public function getLockAt(): ?\DateTime {
        return $this->lockAt;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?int {
        return $this->id;
    }

    public function setFoldersCount(?int $foldersCount): self {
        $this->foldersCount = $foldersCount;
        return $this;
    }
    public function getFoldersCount(): ?int {
        return $this->foldersCount;
    }

    public function setName(?string $name): self {
        $this->name = $name;
        return $this;
    }
    public function getName(): ?string {
        return $this->name;
    }

    public function setParentFolderId(?int $parentFolderId): self {
        $this->parentFolderId = $parentFolderId;
        return $this;
    }
    public function getParentFolderId(): ?int {
        return $this->parentFolderId;
    }

    public function setCreatedAt(?\DateTime $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }
    public function getCreatedAt(): ?\DateTime {
        return $this->createdAt;
    }

    public function setUnlockAt(?\DateTime $unlockAt): self {
        $this->unlockAt = $unlockAt;
        return $this;
    }
    public function getUnlockAt(): ?\DateTime {
        return $this->unlockAt;
    }

    public function setHidden(?bool $hidden): self {
        $this->hidden = $hidden;
        return $this;
    }
    public function getHidden(): ?bool {
        return $this->hidden;
    }

    public function setHiddenForUser(?bool $hiddenForUser): self {
        $this->hiddenForUser = $hiddenForUser;
        return $this;
    }
    public function getHiddenForUser(): ?bool {
        return $this->hiddenForUser;
    }

    public function setLocked(?bool $locked): self {
        $this->locked = $locked;
        return $this;
    }
    public function getLocked(): ?bool {
        return $this->locked;
    }

    public function setLockedForUser(?bool $lockedForUser): self {
        $this->lockedForUser = $lockedForUser;
        return $this;
    }
    public function getLockedForUser(): ?bool {
        return $this->lockedForUser;
    }

    public function setForSubmissions(?bool $forSubmissions): self {
        $this->forSubmissions = $forSubmissions;
        return $this;
    }
    public function getForSubmissions(): ?bool {
        return $this->forSubmissions;
    }



}
