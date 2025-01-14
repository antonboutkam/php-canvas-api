<?php

namespace Hurah\Canvas\Endpoints\AssignmentGroup;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Assignment\AssignmentCollection;
use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Types\Exception\InvalidArgumentException;

class AssignmentGroup extends CanvasObject
{
    protected ?int $id = null;
    protected ?string $name;
    protected ?int $position = null;
    protected int $course_id;
    protected float $group_weight = 0;
    protected ?string $sis_source_id = null;
    protected array $integration_data = [];
    protected array $rules = [];

    public static function fromCanvasArray(array $canvasArray, int $iCanvasCourseId = null): self
    {
        echo __FILE__ . '::' . __LINE__ . PHP_EOL;
        print_r($canvasArray);

        $assignmentGroup = new self();
        $assignmentGroup
            ->setName($canvasArray['name'])
            ->setId($canvasArray['id'])
            ->setCourseId($iCanvasCourseId)
            ->setRules($canvasArray['rules'])
            ->setPosition($canvasArray['position'])
            ->setGroupWeight($canvasArray['group_weight'])
            ->setSisSourceId($canvasArray['sis_source_id'])
            ->setIntegrationData($canvasArray['integration_data']);

        return $assignmentGroup;
    }

    public function toCanvasArray():array
    {
        return array_filter($this->toArray());
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function setRules(array $rules): self
    {
        $this->rules = $rules;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getGroupWeight(): float
    {
        return $this->group_weight;
    }

    public function setGroupWeight(?float $group_weight = null): self
    {
        $this->group_weight = $group_weight;
        return $this;
    }

    public function getSisSourceId(): string
    {
        return $this->sis_source_id;
    }

    public function setSisSourceId(?string $sis_source_id = null): self
    {
        $this->sis_source_id = $sis_source_id;
        return $this;
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function getAssignments(): AssignmentCollection
    {
        $canvas = new Canvas();
        return $canvas->getAssignmentGroupAssignments($this->getCourseId(), $this->getId());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $iId): self
    {
        $this->id = $iId;
        return $this;
    }

    public function getIntegrationData(): array
    {
        return $this->integration_data;
    }

    public function setIntegrationData(array $integration_data): self
    {
        $this->integration_data = $integration_data;
        return $this;
    }

    /**
     * @return int
     */
    public function getCourseId(): int
    {
        return $this->course_id;
    }

    /**
     * @param int $course_id
     * @return AssignmentGroup
     */
    public function setCourseId(int $course_id): AssignmentGroup
    {
        $this->course_id = $course_id;
        return $this;
    }
}