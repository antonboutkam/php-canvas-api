<?php

namespace Hurah\Canvas\Endpoints\Module;

use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Canvas\Util;

class Module extends CanvasObject
{
    public ?int $id = null;
    public string $name;
    public ?int $position = null;
    public ?string $itemsUrl = null;
    public ?string $unlockAt = null;
    public ?bool $requireSequentialProgress = true;
    public ?bool $publishFinalGrade = false;
    public array $prerequisiteModuleIds = [];
    public bool $published = false;
    public ?int $itemsCount = null;


    /**
     * @param array $array
     * @return self
     * 2*/
    public static function fromCanvasArray(array $array): self
    {

        print_r($array);

        $instance = new self();

        foreach ($array as $key => $value) {

            $method = 'set' . Util::underscoreToCamelCase($key, true);
            self::_setValue($instance, $key, $method, $value);
        }

        return $instance;
    }
    public function toCanvasArray():array
    {
        $aOut = array_filter($this->toArray());
        return ['module' => $aOut];
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name ?? 'Module naam';
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPosition(): ?int
    {
        return $this->position ?? null;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getUnlockAt(): ?string
    {
        return $this->unlockAt ?? null;
    }

    public function setUnlockAt(?string $unlockAt): void
    {
        $this->unlockAt = $unlockAt;
    }

    public function getRequireSequentialProgress(): ?bool
    {
        return $this->requireSequentialProgress;
    }

    public function setRequireSequentialProgress(?bool $requireSequentialProgress): void
    {
        $this->requireSequentialProgress = $requireSequentialProgress;
    }

    public function getPublishFinalGrade(): ?bool
    {
        return $this->publishFinalGrade;
    }

    public function setPublishFinalGrade(?bool $publishFinalGrade): void
    {
        $this->publishFinalGrade = $publishFinalGrade;
    }

    public function getPrerequisiteModuleIds(): array
    {
        return $this->prerequisiteModuleIds ?? [];
    }

    public function setPrerequisiteModuleIds(array $prerequisiteModuleIds): void
    {
        $this->prerequisiteModuleIds = $prerequisiteModuleIds;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    public function getItemsCount(): int
    {
        return $this->itemsCount;
    }

    public function setItemsCount(int $itemsCount): void
    {
        $this->itemsCount = $itemsCount;
    }

    public function getItemsUrl(): string
    {
        return $this->itemsUrl;
    }

    public function setItemsUrl(string $itemsUrl): void
    {
        $this->itemsUrl = $itemsUrl;
    }


}
