<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestion;

use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Types\Exception\InvalidArgumentException;

/**
 * Class QuizQuestion
 *
 * Represents a quiz question with various properties such as id, quizId, position, questionName,
 * questionType, questionText, pointsPossible, correctComments, incorrectComments, neutralComments,
 * and answers.
 *
 * @package YourPackage
 */
class QuizQuestion extends CanvasObject
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
     * @var int|null
     */
    private ?int $quizGroupId = null;

    /**
     * @var int|null
     */
    private ?int $position = null;
    /**
     * @var string|null
     */
    private ?string $questionName = null;
    /**
     * @var string|null
     */
    private ?string $questionType = null;
    /**
     * @var string|null
     */
    private ?string $questionText = null;
    /**
     * @var int|null
     */
    private ?float $pointsPossible = null;
    /**
     * @var string|null
     */
    private ?string $correctComments = null;
    /**
     * @var string|null
     */
    private ?string $incorrectComments = null;
    /**
     * @var string|null
     */
    private ?string $neutralComments = null;
    /**
     * @var string|null
     */
    private ?string $correctCommentsHtml = null;
    /**
     * @var string|null
     */
    private ?string $incorrectCommentsHtml = null;
    /**
     * @var string|null
     */
    private ?string $assessmentQuestionId = null;
    /**
     * @var array|null
     */
    private ?array $answers = null;


    /**
     * @param int|null $quizId
     * @return $this
     */
    public function setAssessmentQuestionId(?string $assessmentQuestionId): self
    {
        $this->assessmentQuestionId = $assessmentQuestionId;
        return $this;
    }

    /**
     * @param int|null $quizId
     * @return $this
     */
    public function setCorrectCommentsHtml(?string $correctCommentsHtml): self
    {
        $this->correctCommentsHtml = $correctCommentsHtml;
        return $this;
    }

    /**
     * @param int|null $quizId
     * @return $this
     */
    public function setIncorrectCommentsHtml(?string $incorrectCommentsHtml): self
    {
        $this->incorrectCommentsHtml = $incorrectCommentsHtml;
        return $this;
    }

    public function getCorrectCommentsHtml(): ?string
    {
        return $this->correctCommentsHtml;
    }

    public function getIncorrectCommentsHtml(): ?string
    {
        return $this->incorrectCommentsHtml;
    }

    public function getAssessmentQuestionId(): ?string
    {
        return $this->assessmentQuestionId;
    }



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
    public function toCanvasArray(): array
    {
        return ['question' => array_filter($this->toArray())];
    }


    // Getters and fluent setters for all properties

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuizId(): ?int
    {
        return $this->quizId;
    }

    /**
     * @param int|null $quizId
     * @return $this
     */
    public function setQuizId(?int $quizId): self
    {
        $this->quizId = $quizId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuizGroupId(): ?int
    {
        return $this->quizGroupId;
    }

    /**
     * @param int|null $quizId
     * @return $this
     */
    public function setQuizGroupId(?int $quizGroupId): self
    {
        $this->quizGroupId = $quizGroupId;
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int|null $position
     * @return $this
     */
    public function setPosition(?int $position): self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getQuestionName(): ?string
    {
        return $this->questionName;
    }

    /**
     * @param string|null $questionName
     * @return $this
     */
    public function setQuestionName(?string $questionName): self
    {
        $this->questionName = $questionName;
        return $this;
    }

    /**
     * @return string|null [calculated_question, essay_question, file_upload_question, fill_in_multiple_blanks_question, matching_question, multiple_answers_question, multiple_choice_question, multiple_dropdowns_question, numerical_question, short_answer_question, text_only_question, true_false_question]
     */
    public function getQuestionType(): ?string
    {
        return $this->questionType;
    }

    /**
     * @param string|null $questionType [calculated_question, essay_question, file_upload_question, fill_in_multiple_blanks_question, matching_question, multiple_answers_question, multiple_choice_question, multiple_dropdowns_question, numerical_question, short_answer_question, text_only_question, true_false_question]
     * @return $this
     */
    public function setQuestionType(?string $questionType): self
    {
        if (!in_array($questionType, self::getSupportedQuestionTypes())) {
            throw new InvalidArgumentException("Question of type $questionType is not supported.");
        }
        $this->questionType = $questionType;
        return $this;
    }

    private static function getSupportedQuestionTypes(): array
    {
        return ['calculated_question', 'essay_question', 'file_upload_question', 'fill_in_multiple_blanks_question',
            'matching_question', 'multiple_answers_question', 'multiple_choice_question', 'multiple_dropdowns_question', 'numerical_question', 'short_answer_question', 'text_only_question', 'true_false_question'];
    }

    /**
     * @return string|null
     */
    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    /**
     * @param string|null $questionText
     * @return $this
     */
    public function setQuestionText(?string $questionText): self
    {
        $this->questionText = $questionText;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPointsPossible(): ?float
    {
        return $this->pointsPossible;
    }

    /**
     * @param int|null $pointsPossible
     * @return $this
     */
    public function setPointsPossible(?float $pointsPossible): self
    {
        $this->pointsPossible = $pointsPossible;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCorrectComments(): ?string
    {
        return $this->correctComments;
    }

    /**
     * @param string|null $correctComments
     * @return $this
     */
    public function setCorrectComments(?string $correctComments): self
    {
        $this->correctComments = $correctComments;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIncorrectComments(): ?string
    {
        return $this->incorrectComments;
    }

    /**
     * @param string|null $incorrectComments
     * @return $this
     */
    public function setIncorrectComments(?string $incorrectComments): self
    {
        $this->incorrectComments = $incorrectComments;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNeutralComments(): ?string
    {
        return $this->neutralComments;
    }

    /**
     * @param string|null $neutralComments
     * @return $this
     */
    public function setNeutralComments(?string $neutralComments): self
    {
        $this->neutralComments = $neutralComments;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    /**
     * @param array|null $answers
     * @return $this
     */
    public function setAnswers(?array $answers): self
    {
        $this->answers = $answers;
        return $this;
    }
}
