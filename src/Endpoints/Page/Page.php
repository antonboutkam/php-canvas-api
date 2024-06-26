<?php

namespace Hurah\Canvas\Endpoints\Page;

use Hurah\Canvas\Endpoints\CanvasObject;
use DateTime;

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
     * @return Page
     */
    public static function fromCanvasArray(array $data):self
    {
        $page = new self();
        $page->pageId = $data['page_id'] ?? null;
        $page->url = $data['url'] ?? null;
        $page->title = $data['title'] ?? null;
        $page->createdAt = self::makeDate($data['created_at']);
        $page->updatedAt = self::makeDate($data['updated_at']);
        $page->hideFromStudents = $data['hide_from_students'] ?? null;
        $page->editingRoles = $data['editing_roles'] ?? null;
        $page->lastEditedBy = $data['last_edited_by'] ?? [];
        $page->body = $data['body'] ?? null;
        $page->published = $data['published'] ?? null;
        $page->publishAt = self::makeDate($data['publish_at']);
        $page->frontPage = $data['front_page'] ?? null;
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
        return $this->pageId;
    }

    /**
     * @param int|null $pageId
     * @return Page
     */
    public function setPageId(?int $pageId): Page
    {
        $this->pageId = $pageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Page
     */
    public function setUrl(string $url): Page
    {
        $this->url = $url;
        return $this;
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
     * @return Page
     */
    public function setTitle(string $title): Page
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
     * @return Page
     */
    public function setCreatedAt(?DateTime $createdAt): Page
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
     * @return Page
     */
    public function setUpdatedAt(?DateTime $updatedAt): Page
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
     * @return Page
     */
    public function setHideFromStudents(?bool $hideFromStudents): Page
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
     * @return Page
     */
    public function setEditingRoles(?string $editingRoles): Page
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
     * @return Page
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
     * @return Page
     */
    public function setBody(?string $body): Page
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
     * @return Page
     */
    public function setPublished(?bool $published): Page
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
     * @return Page
     */
    public function setPublishAt(?DateTime $publishAt): Page
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
     * @param bool $frontPage
     * @return Page
     */
    public function setFrontPage(bool $frontPage): Page
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
     * @return Page
     */
    public function setLockedForUser(?bool $lockedForUser): Page
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
     * @return Page
     */
    public function setLockInfo(?string $lockInfo): Page
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
     * @return Page
     */
    public function setLockExplanation(?string $lockExplanation): Page
    {
        $this->lockExplanation = $lockExplanation;
        return $this;
    }


}