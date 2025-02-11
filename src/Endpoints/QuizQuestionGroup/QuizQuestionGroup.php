<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionGroup;

use Hurah\Canvas\Endpoints\CanvasObject;

/**
 * Class representing a Quiz Question Group.
 */
class QuizQuestionGroup extends CanvasObject
{
    /**
     * @var int|null
     */
    private ?int $id = null;
    /**
     * @var int|null
     */
    private ?int $quizId = null;
    /**
     * @var string|null
     */
    private ?string $name = null;
    /**
     * @var int|null
     */
    private ?int $pickCount = null;
    /**
     * @var int|null
     */
    private ?int $questionPoints = null;
    /**
     * @var int|null
     */
    private ?int $assessmentQuestionBankId = null;
    /**
     * @var int|null
     */
    private ?int $position = null;

    /**
     * Static constructor from an associative array.
     *
     * @param array $data
     * @return self
     */
    public static function fromCanvasArray(array $data): self
    {
        $instance = new self();

        foreach ($data as $key => $value) {
            $setter = self::snakeToSetter($key);
            self::_setValue($instance, $key, $setter, $value);
        }

        return $instance;
    }

    /**
     * @return array
     */
    public function toCanvasArray():array
    {
        return ['quiz_groups' => array_filter($this->toArray())];
    }

    // Getters and fluent setters for all properties

    /**
     * @return int|null
     */
    public function getId(): ?int { return $this->id; }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self { $this->id = $id; return $this; }

    /**
     * @return int|null
     */
    public function getQuizId(): ?int { return $this->quizId; }

    /**
     * @param int|null $quizId
     * @return $this
     */
    public function setQuizId(?int $quizId): self { $this->quizId = $quizId; return $this; }

    /**
     * @return string|null
     */
    public function getName(): ?string { return $this->name; }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self { $this->name = $name; return $this; }

    /**
     * @return int|null
     */
    public function getPickCount(): ?int { return $this->pickCount; }

    /**
     * @param int|null $pickCount
     * @return $this
     */
    public function setPickCount(?int $pickCount): self { $this->pickCount = $pickCount; return $this; }

    /**
     * @return int|null
     */
    public function getQuestionPoints(): ?int { return $this->questionPoints; }

    /**
     * @param int|null $questionPoints
     * @return $this
     */
    public function setQuestionPoints(?int $questionPoints): self { $this->questionPoints = $questionPoints; return $this; }

    /**
     * @return int|null
     */
    public function getAssessmentQuestionBankId(): ?int { return $this->assessmentQuestionBankId; }

    /**
     * @param int|null $assessmentQuestionBankId
     * @return $this
     */
    public function setAssessmentQuestionBankId(?int $assessmentQuestionBankId): self { $this->assessmentQuestionBankId = $assessmentQuestionBankId; return $this; }

    /**
     * @return int|null
     */
    public function getPosition(): ?int { return $this->position; }

    /**
     * @param int|null $position
     * @return $this
     */
    public function setPosition(?int $position): self { $this->position = $position; return $this; }
}
