<?php
declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\Quiz;

use DateTime;
use Hurah\Canvas\Endpoints\CanvasObject;

/**
 * Class Quiz
 * Represents a quiz in the Canvas LMS API.
 * @see https://canvas.instructure.com/doc/api/new_quizzes.html#method.new_quizzes/quizzes_api.create
 */
class Quiz extends CanvasObject
{
    private ?string $title = null;
    private ?int $assignmentGroupId = null;
    private ?float $pointsPossible = null;
    private ?DateTime $dueAt = null;
    private ?DateTime $lockAt = null;
    private ?DateTime $unlockAt = null;
    private ?string $gradingType = null;
    private ?string $instructions = null;

    /**
     * Get the title of the quiz.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title of the quiz.
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the assignment group ID.
     */
    public function getAssignmentGroupId(): ?int
    {
        return $this->assignmentGroupId;
    }

    /**
     * Set the assignment group ID.
     */
    public function setAssignmentGroupId(?int $assignmentGroupId): self
    {
        $this->assignmentGroupId = $assignmentGroupId;
        return $this;
    }

    /**
     * Get the total points possible.
     */
    public function getPointsPossible(): ?float
    {
        return $this->pointsPossible;
    }

    /**
     * Set the total points possible.
     */
    public function setPointsPossible(?float $pointsPossible): self
    {
        if ($pointsPossible !== null && $pointsPossible < 0) {
            throw new \InvalidArgumentException("Points possible must be positive.");
        }
        $this->pointsPossible = $pointsPossible;
        return $this;
    }

    /**
     * Get the due date.
     */
    public function getDueAt(): ?DateTime
    {
        return $this->dueAt;
    }

    /**
     * Set the due date.
     */
    public function setDueAt(?string $dueAt): self
    {
        $this->dueAt = $this->makeDate($dueAt);
        return $this;
    }

    /**
     * Get the lock date.
     */
    public function getLockAt(): ?DateTime
    {
        return $this->lockAt;
    }

    /**
     * Set the lock date.
     */
    public function setLockAt(?string $lockAt): self
    {
        $this->lockAt = $this->makeDate($lockAt);
        return $this;
    }

    /**
     * Get the unlock date.
     */
    public function getUnlockAt(): ?DateTime
    {
        return $this->unlockAt;
    }

    /**
     * Set the unlock date.
     */
    public function setUnlockAt(?string $unlockAt): self
    {
        $this->unlockAt = $this->makeDate($unlockAt);
        return $this;
    }

    /**
     * Get the grading type.
     */
    public function getGradingType(): ?string
    {
        return $this->gradingType;
    }

    /**
     * Set the grading type.
     * @param ?string $gradingType [pass_fail, percent, letter_grade, gpa_scale, points]
     */
    public function setGradingType(?string $gradingType): self
    {
        $allowedValues = ['pass_fail', 'percent', 'letter_grade', 'gpa_scale', 'points'];
        if ($gradingType !== null && !in_array($gradingType, $allowedValues, true)) {
            throw new \InvalidArgumentException("Invalid grading type.");
        }
        $this->gradingType = $gradingType;
        return $this;
    }

    /**
     * Get the quiz instructions.
     */
    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    /**
     * Set the quiz instructions.
     */
    public function setInstructions(?string $instructions): self
    {
        $this->instructions = $instructions;
        return $this;
    }

    /**
     * Convert object properties to an array formatted for Canvas API.
     */
    public function toCanvasArray(): array
    {
        return [
            'quiz' => [
                'title' => $this->title,
                'assignment_group_id' => $this->assignmentGroupId,
                'points_possible' => $this->pointsPossible,
                'due_at' => $this->formatDt($this->dueAt),
                'lock_at' => $this->formatDt($this->lockAt),
                'unlock_at' => $this->formatDt($this->unlockAt),
                'grading_type' => $this->gradingType,
                'instructions' => $this->instructions,
            ]
        ];
    }
}
