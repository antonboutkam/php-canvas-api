<?php

namespace Hurah\Canvas\Endpoints\GradingStandard;

use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Canvas\Endpoints\GradingSchemeEntry\GradingSchemeEntry;

class GradingStandard extends CanvasObject{
    private ?string $title;
    private ?int $id;
    private ?string $contextType;
    private ?int $contextId;
    private bool $pointsBased = true;
    private float $scalingFactor;
    private array $gradingScheme;

    public static function fromArray(array $aGradingStandard): self
    {
        $instance = new self();

        $instance->setId($aGradingStandard['id'] ?? null);
        $instance->setTitle($aGradingStandard['title'] ?? null);
        $instance->setContextType($aGradingStandard['contextType'] ?? null);
        $instance->setContextId($aGradingStandard['contextId'] ?? null);
        $instance->setPointsBased($aGradingStandard['pointsBased'] ?? null);
        $instance->setScalingFactor($aGradingStandard['scalingFactor'] ?? null);

        if(!empty($aGradingStandard['gradingScheme'])){
            $gradingSchemeEntries = array_map(function($scheme){
                return GradingSchemeEntry::fromArray($scheme); // You may need to define a fromArray method in the GradingSchemeEntry class
            }, $aGradingStandard['gradingScheme']);
            $instance->setGradingScheme($gradingSchemeEntries);
        }
        return $instance;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getContextType(): string {
        return $this->contextType;
    }

    public function setContextType(string $contextType): self {
        $this->contextType = $contextType;
        return $this;
    }

    public function getContextId(): int {
        return $this->contextId;
    }

    public function setContextId(int $contextId): self {
        $this->contextId = $contextId;
        return $this;
    }

    public function isPointsBased(): bool {
        return $this->pointsBased;
    }

    public function setPointsBased(bool $pointsBased): self {
        $this->pointsBased = $pointsBased;
        return $this;
    }

    public function getScalingFactor(): float {
        return $this->scalingFactor;
    }

    public function setScalingFactor(float $scalingFactor): self {
        $this->scalingFactor = $scalingFactor;
        return $this;
    }

    /**
     * @return GradingSchemeEntry[]
     */
    public function getGradingScheme(): array {
        return $this->gradingScheme;
    }

    /**
     * @param GradingSchemeEntry[] $gradingScheme
     */
    public function setGradingScheme(array $gradingScheme): self {
        $this->gradingScheme = $gradingScheme;
        return $this;
    }
}