<?php

namespace Hurah\Canvas\Endpoints\Course;

use DateTime;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Assignment\Assignment;
use Hurah\Canvas\Endpoints\Assignment\AssignmentCollection;
use Hurah\Canvas\Endpoints\AssignmentGroup\AssignmentGroupCollection;
use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Types\Exception\InvalidArgumentException;


class Course extends CanvasObject
{
    protected ?int $id = null;

    protected string $name;

    protected int $accountId;

    protected string $uuid;

    protected ?DateTime $startAt = null;
    protected $gradingStandardId;

    protected ?bool $isPublic;

    protected ?DateTime $createdAt = null;

    protected string $courseCode;

    protected int $rootAccountId;

    protected int $enrollmentTermId;

    protected ?DateTime $endAt = null;

    protected bool $publicSyllabus;

    public function getCohort():string
    {
        $aMatches = [];
        $sCode = $this->getCourseCode();
        preg_match('/-(C[0-9]+)-/', $sCode, $aMatches);

        return $aMatches[1] ?? substr($this->getCourseCode(),0,5);
    }

    public function getAssignment(int $canvas_id): Assignment
    {
        if (!isset($this->assignments[$canvas_id])) {
            throw new \InvalidArgumentException("Assignment is not found in this course.");
        }

        return $this->assignments[$canvas_id];
    }

    public function getAllAssignments():AssignmentCollection
    {
        $oCanvas = new Canvas();
        return $oCanvas->getAssignments($this->getId());
    }

    public function getNameNoCohort():string
    {

        return preg_replace('/( - )?C[0-9]+/', '', $this->getName());
    }

    /**
     * @throws Exception
     */
    public static function fromArray(array $course): self
    {
        $obj = new self();
        $obj->setId($course['id']);
        $obj->setName($course['name']);
        $obj->setAccountId($course['account_id']);
        $obj->setUuid($course['uuid']);
        $obj->setStartAt(self::makeDate($course['start_at']));
        $obj->setGradingStandardId($course['grading_standard_id']);
        $obj->setIsPublic($course['is_public']);
        $obj->setCreatedAt(self::makeDate($course['created_at']));
        $obj->setCourseCode($course['course_code']);
        $obj->setRootAccountId($course['root_account_id']);
        $obj->setEnrollmentTermId($course['enrollment_term_id']);
        // make sure to convert end_at to a correct type
        $obj->setEndAt(self::makeDate($course['end_at']));
        $obj->setPublicSyllabus($course['public_syllabus']);

        return $obj;

    }
    public function toCanvasArray():array
    {
        return ['course' => array_filter($this->toArray())];
    }
/*
    public function toProprietaryArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'account_id' => $this->getAccountId(),
            'uuid' => $this->getUuid(),
            'start_at' => self::formatDt($this->getStartAt()),
            'grading_standard_id' => $this->getGradingStandardId(),
            'is_public' => $this->isPublic(),
            'created_at' => self::formatDt($this->getCreatedAt()),
            'course_code' => $this->getCourseCode(),
            'root_account_id' => $this->getRootAccountId(),
            'enrollment_term_id' => $this->getEnrollmentTermId(),
            'end_at' => self::formatDt($this->getEndAt()),
            'public_syllabus' => $this->getPublicSyllabus(),
        ];
    }
*/
    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function fetchAssignmentGroups():AssignmentGroupCollection
    {
        $oCanvas = new Canvas();
        return $oCanvas->getAssignmentGroups($this->getId());
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function fetchAssignments():AssignmentCollection
    {
        $oCanvas = new Canvas();
        return $oCanvas->getAssignments($this->getId());
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function getAssignmentGroups():AssignmentGroupCollection
    {
        $oCanvas = new Canvas();
        return $oCanvas->getAssignmentGroups($this->id);
    }

    // And possibly more properties depending on your need...

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * @return bool
     */
    public function getPublicSyllabus(): bool
    {
        return $this->publicSyllabus;
    }

    /**
     * @param bool $publicSyllabus
     */
    public function setPublicSyllabus(bool $publicSyllabus): void
    {
        $this->publicSyllabus = $publicSyllabus;
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }

    /**
     * @param int $accountId
     * @return Course
     */
    public function setAccountId(int $accountId): Course
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return Course
     */
    public function setUuid(string $uuid): Course
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartAt(): ?DateTime
    {
        return $this->startAt;
    }

    /**
     * @param DateTime|null $startAt
     * @return Course
     */
    public function setStartAt(?DateTime $startAt): Course
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGradingStandardId()
    {
        return $this->gradingStandardId;
    }

    /**
     * @param mixed $gradingStandardId
     * @return Course
     */
    public function setGradingStandardId($gradingStandardId)
    {
        $this->gradingStandardId = $gradingStandardId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool|null $isPublic
     * @return Course
     */
    public function setIsPublic(?bool $isPublic): Course
    {
        $this->isPublic = $isPublic;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Course
     */
    public function setCreatedAt(DateTime $createdAt): Course
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getCourseCode(): string
    {
        return $this->courseCode;
    }

    /**
     * @param string $courseCode
     * @return Course
     */
    public function setCourseCode(string $courseCode): Course
    {
        $this->courseCode = $courseCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getRootAccountId(): int
    {
        return $this->rootAccountId;
    }

    /**
     * @param int $rootAccountId
     * @return Course
     */
    public function setRootAccountId(int $rootAccountId): Course
    {
        $this->rootAccountId = $rootAccountId;
        return $this;
    }

    /**
     * @return int
     */
    public function getEnrollmentTermId(): int
    {
        return $this->enrollmentTermId;
    }

    /**
     * @param int $enrollmentTermId
     * @return Course
     */
    public function setEnrollmentTermId(int $enrollmentTermId): Course
    {
        $this->enrollmentTermId = $enrollmentTermId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndAt(): ?DateTime
    {
        return $this->endAt;
    }

    /**
     * @param DateTime|null $endAt
     * @return Course
     */
    public function setEndAt(?DateTime $endAt): Course
    {
        $this->endAt = $endAt;
        return $this;
    }


}
