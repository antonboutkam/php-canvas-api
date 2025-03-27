<?php

namespace Hurah\Canvas\Endpoints\Page;

use DateTime;
use Hurah\Canvas\Endpoints\CanvasObject;

class Page extends CanvasObject
{
    /**
     * The ID of the page
     * @var int
     */
    private ?int $pageId = null;

    /**
     * The unique locator for the page
     * @var string
     */
    private ?string $url = null;

    /**
     * The title of the page
     * @var string
     */
    private string $title;

    /**
     * The creation date for the page
     * @var string
     */
    private ?DateTime $createdAt = null;

    /**
     * The date the page was last updated
     * @var string
     */
    private ?DateTime $updatedAt = null;

    /**
     * (DEPRECATED) Whether this page is hidden from students
     * @var bool
     */
    private ?bool $hideFromStudents = false;

    /**
     * Roles allowed to edit the page; comma-separated list
     * @var string
     */
    private ?string $editingRoles = null;

    /**
     * The User who last edited the page
     * @var mixed
     */
    private ?array $lastEditedBy = [];

    /**
     * The page content, in HTML
     * @var string
     */
    private ?string $body = null;

    /**
     * Whether the page is published (true) or draft state (false)
     * @var bool
     */
    private ?bool $published = null;

    /**
     * Scheduled publication date for this page
     * @var string
     */
    private ?DateTime  $publishAt = null;

    /**
     * Whether this page is the front page for the wiki
     * @var bool
     */
    private bool $frontPage = false;

    /**
     * Whether or not this is locked for the user
     * @var bool
     */
    private ?bool $lockedForUser = null;

    /**
     * Information for the user about the lock
     * @var string
     */
    private ?string $lockInfo = null;

    /**
     * An explanation of why this is locked for the user
     * @var string
     */
    private ?string $lockExplanation = '';

    /**
     * Create a Page object from an associative array.
     *
     * @param array $data
     * @return Student
     */
    public static function fromCanvasArray(array $data):self
    {
        $page = new self();
        $page->pageId = $data['page_id'] ?? null;
        $page->url = $data['url'] ?? null;
        $page->title = $data['title'] ?? null;
        $page->createdAt = isset($data['created_at']) ? self::makeDate($data['created_at']) : null;
        $page->updatedAt = isset($data['updated_at']) ? self::makeDate($data['updated_at']) : null;
        $page->hideFromStudents = $data['hide_from_students'] ?? null;
        $page->editingRoles = $data['editing_roles'] ?? null;
        $page->lastEditedBy = $data['last_edited_by'] ?? [];
        $page->body = $data['body'] ?? null;
        $page->published = $data['published'] ?? null;
        $page->publishAt = isset($data['publish_at']) ? self::makeDate($data['publish_at']) : null;
        $page->frontPage = $data['front_page'] ?? false;
        $page->lockedForUser = $data['locked_for_user'] ?? null;
        $page->lockInfo = $data['lock_info'] ?? null;
        $page->lockExplanation = $data['lock_explanation'] ?? null;
        return $page;
    }

    public function toCanvasArray():array
    {
        return ['wiki_page' => array_filter($this->toArray()), array_filter($this->toArray())];

    }


    /**
     * @return int|null
     */
    public function getPageId(): ?int
    {
        return $this->pageId ?? null;
    }

    /**
     * @param int|null $pageId
     * @return Student
     */
    public function setPageId(?int $pageId): Student
    {
        $this->pageId = $pageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url ?? null;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Student
     */
    public function setTitle(string $title): Student
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return Student
     */
    public function setCreatedAt(?DateTime $createdAt): Student
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     * @return Student
     */
    public function setUpdatedAt(?DateTime $updatedAt): Student
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHideFromStudents(): ?bool
    {
        return $this->hideFromStudents;
    }

    /**
     * @param bool|null $hideFromStudents
     * @return Student
     */
    public function setHideFromStudents(?bool $hideFromStudents): Student
    {
        $this->hideFromStudents = $hideFromStudents;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEditingRoles(): ?string
    {
        return $this->editingRoles;
    }

    /**
     * @param string|null $editingRoles
     * @return Student
     */
    public function setEditingRoles(?string $editingRoles): Student
    {
        $this->editingRoles = $editingRoles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastEditedBy():?array
    {
        return $this->lastEditedBy ?? [];
    }

    /**
     * @param mixed $lastEditedBy
     * @return Student
     */
    public function setLastEditedBy(?array $lastEditedBy)
    {
        $this->lastEditedBy = $lastEditedBy;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return Student
     */
    public function setBody(?string $body): Student
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPublished(): ?bool
    {
        return $this->published;
    }

    /**
     * @param bool|null $published
     * @return Student
     */
    public function setPublished(?bool $published): Student
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getPublishAt(): ?DateTime
    {
        return $this->publishAt;
    }

    /**
     * @param DateTime|null $publishAt
     * @return Student
     */
    public function setPublishAt(?DateTime $publishAt): Student
    {
        $this->publishAt = $publishAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFrontPage(): bool
    {
        return $this->frontPage;
    }
    /**
     * @return bool
     */
    public function getFrontPage(): bool
    {
        return $this->frontPage;
    }

    /**
     * @param bool $frontPage
     * @return Student
     */
    public function setFrontPage(bool $frontPage): Student
    {
        $this->frontPage = $frontPage;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLockedForUser(): ?bool
    {
        return $this->lockedForUser;
    }

    /**
     * @param bool|null $lockedForUser
     * @return Student
     */
    public function setLockedForUser(?bool $lockedForUser): Student
    {
        $this->lockedForUser = $lockedForUser;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLockInfo(): ?string
    {
        return $this->lockInfo;
    }

    /**
     * @param string|null $lockInfo
     * @return Student
     */
    public function setLockInfo(?string $lockInfo): Student
    {
        $this->lockInfo = $lockInfo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLockExplanation(): ?string
    {
        return $this->lockExplanation;
    }

    /**
     * @param string|null $lockExplanation
     * @return Student
     */
    public function setLockExplanation(?string $lockExplanation): Student
    {
        $this->lockExplanation = $lockExplanation;
        return $this;
    }


}