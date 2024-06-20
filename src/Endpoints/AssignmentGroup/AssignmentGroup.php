<?php

namespace Hurah\Canvas\Endpoints\AssignmentGroup;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Assignment\AssignmentCollection;
use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Types\Exception\InvalidArgumentException;

class AssignmentGroup extends CanvasObject
{
    protected int $id;
    protected string $name;
    protected int $position;
    protected int $course_id;
    protected int $canvas_course_id;
    protected float $group_weight;
    protected ?string $sis_source_id = null;
    protected array $integration_data;

    public static function fromCanvasArray(array $canvasArray, int $iCanvasCourseId = null): self
    {

        $assignmentGroup = new self();
        $assignmentGroup
            ->setName($canvasArray['name'])
            ->setId($canvasArray['id'])
            ->setCourseId($iCanvasCourseId)
            ->setPosition($canvasArray['position'])
            ->setGroupWeight($canvasArray['group_weight'])
            ->setSisSourceId($canvasArray['sis_source_id'])
            ->setIntegrationData($canvasArray['integration_data']);

        return $assignmentGroup;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function setGroupWeight(float $group_weight): self
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
        return $canvas->getAssignmentGroupAssignments($this->getCanvasCourseId(), $this->getId());
    }

    /**
     * @return int
     */
    public function getCanvasCourseId(): int
    {
        return $this->canvas_course_id;
    }

    /**
     * @param int $canvas_course_id
     * @return AssignmentGroup
     */
    public function setCanvasCourseId(int $canvas_course_id): AssignmentGroup
    {
        $this->canvas_course_id = $canvas_course_id;
        return $this;
    }

    public function getId(): int
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