<?php

namespace Hurah\Canvas\Endpoints\ModuleItem;

use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Canvas\Util;

class ModuleItem extends CanvasObject
{

    /**
     * Create a ModuleItem object from an associative array.
     *
     * @param array $data
     * @return ModuleItem
     */
    public static function fromCanvasArray(array $data): self
    {
        $moduleItem = new self();
        $moduleItem->setId($data['id'] ?? null)
            ->setModuleId($data['module_id'] ?? null)
            ->setPosition($data['position'] ?? null)
            ->setTitle($data['title'] ?? '')
            ->setIndent($data['indent'] ?? 0)
            ->setType($data['type'] ?? '')
            ->setContentId($data['content_id'] ?? null)
            ->setHtmlUrl($data['html_url'] ?? '')
            ->setUrl($data['url'] ?? null)
            ->setPageUrl($data['page_url'] ?? null)
            ->setExternalUrl($data['external_url'] ?? null)
            ->setNewTab($data['new_tab'] ?? null)
            ->setCompletionRequirement($data['completion_requirement'] ?? null)
            ->setContentDetails($data['content_details'] ?? null)
            ->setPublished($data['published'] ?? null);
        return $moduleItem;
    }

    public function toCanvasArray():array
    {
        return ['module_item' => array_filter($this->toArray())];
    }

    /**
     * The unique identifier for the module item
     * @var int
     */
    protected int $id;

    /**
     * The id of the Module this item appears in
     * @var int
     */
    protected int $moduleId;

    /**
     * The position of this item in the module (1-based)
     * @var int
     */
    protected int $position;

    /**
     * The title of this item
     * @var string
     */
    protected string $title;

    /**
     * 0-based indent level; module items may be indented to show a hierarchy
     * @var int
     */
    protected int $indent;

    /**
     * The type of object referred to
     * @var string
     */
    protected string $type;

    /**
     * The id of the object referred to
     * @var int|null
     */
    protected ?int $contentId;

    /**
     * Link to the item in Canvas
     * @var string
     */
    protected string $htmlUrl;

    /**
     * Link to the Canvas API object, if applicable
     * @var string|null
     */
    protected ?string $url;

    /**
     * Unique locator for the linked wiki page (only for 'Page' type)
     * @var string|null
     */
    protected ?string $pageUrl;

    /**
     * External URL that the item points to (only for 'ExternalUrl' and 'ExternalTool' types)
     * @var string|null
     */
    protected ?string $externalUrl;

    /**
     * Whether the external tool opens in a new tab (only for 'ExternalTool' type)
     * @var bool|null
     */
    protected ?bool $newTab;

    /**
     * Completion requirement for this module item
     * @var array|null
     */
    protected ?array $completionRequirement;

    /**
     * Additional details specific to the associated object
     * @var array|null
     */
    protected ?array $contentDetails;

    /**
     * Whether this module item is published
     * @var bool|null
     */
    protected ?bool $published;

    // Getters and Setters with fluent interface
    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getModuleId(): ?int
    {
        return $this->moduleId ?? null;
    }

    public function setModuleId(int $moduleId): self
    {
        $this->moduleId = $moduleId;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position ?? null;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getIndent(): ? int
    {
        return $this->indent ?? null;
    }

    public function setIndent(int $indent): self
    {
        $this->indent = $indent;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type ?? null;
    }

    /**
     * @param string $type [File, Page, Discussion, Assignment, Quiz, SubHeader, ExternalUrl, ExternalTool]
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getContentId(): ?int
    {
        return $this->contentId ?? null;
    }

    public function setContentId(?int $contentId): self
    {
        $this->contentId = $contentId;
        return $this;
    }

    public function getHtmlUrl(): ?string
    {
        return $this->htmlUrl ?? null;
    }

    public function setHtmlUrl(string $htmlUrl): self
    {
        $this->htmlUrl = $htmlUrl;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url ?? null;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getPageUrl(): ?string
    {
        return $this->pageUrl ?? null;
    }

    public function setPageUrl(?string $pageUrl): self
    {
        $this->pageUrl = $pageUrl;
        return $this;
    }

    public function getExternalUrl(): ?string
    {
        return $this->externalUrl ?? null;
    }

    public function setExternalUrl(?string $externalUrl): self
    {
        $this->externalUrl = $externalUrl;
        return $this;
    }

    public function getNewTab(): ?bool
    {
        return $this->newTab ?? null;
    }

    public function setNewTab(?bool $newTab): self
    {
        $this->newTab = $newTab;
        return $this;
    }

    public function getCompletionRequirement(): ?array
    {
        return $this->completionRequirement ?? null;
    }

    /**
     * @param array|null $completionRequirement [must_view, must_contribute, must_submit, must_mark_done ]
     * @return $this
     */
    public function setCompletionRequirement(?array $completionRequirement): self
    {
        $this->completionRequirement = $completionRequirement;
        return $this;
    }

    public function getContentDetails(): ?array
    {
        return $this->contentDetails ?? null;
    }

    public function setContentDetails(?array $contentDetails): self
    {
        $this->contentDetails = $contentDetails;
        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;
        return $this;
    }
}

