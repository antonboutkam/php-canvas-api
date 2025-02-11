<?php

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer;

abstract class AbstractAnswer implements AnswerInterface, NumericalInterface, FillInBlanksInterface, MatchingInterface
{

    /**
     * The unique identifier for the answer.
     * Do not supply if this answer is part of a new question.
     */
    protected ?int $id = null;

    /** The text of the answer. */
    protected ?string $answerText = null;

    /**
     * An integer to determine correctness of the answer.
     * Incorrect answers should be 0, correct answers should be 100.
     */
    protected ?int $answerWeight = null;

    /** Specific contextual comments for a particular answer. */
    protected ?string $answerComments = null;

    /** Used in missing word questions. The text to follow the missing word. */
    protected ?string $textAfterAnswers = null;

    /** Used in matching questions. The static value of the answer on the left. */
    protected ?string $answerMatchLeft = null;

    /** Used in matching questions. The correct match for answer_match_left. */
    protected ?string $answerMatchRight = null;

    /**
     * Used in matching questions.
     * A list of distractors, delimited by new lines.
     */
    protected ?string $matchingAnswerIncorrectMatches = null;

    /**
     * Used in numerical questions.
     * Values: 'exact_answer', 'range_answer', 'precision_answer'.
     */
    protected ?string $numericalAnswerType = null;

    /** The exact value for an 'exact_answer' numerical question. */
    protected ?float $exact = null;

    /** The margin of error for an 'exact_answer' numerical question. */
    protected ?float $margin = null;

    /** The approximate value for a 'precision_answer' numerical question. */
    protected ?float $approximate = null;

    /** The numerical precision used for a 'precision_answer'. */
    protected ?int $precision = null;

    /** The start of the allowed range for a 'range_answer'. */
    protected ?float $start = null;

    /** The end of the allowed range for a 'range_answer'. */
    protected ?float $end = null;

    /** Used in fill-in-multiple-blanks and multiple dropdowns questions. */
    protected ?int $blankId = null;

    // === GETTERS & SETTERS ===

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getAnswerText(): ?string
    {
        return $this->answerText;
    }

    public function setAnswerText(?string $answerText): self
    {
        $this->answerText = $answerText;
        return $this;
    }

    public function getAnswerWeight(): ?int
    {
        return $this->answerWeight;
    }

    public function setAnswerWeight(?int $answerWeight): self
    {
        $this->answerWeight = $answerWeight;
        return $this;
    }

    public function getAnswerComments(): ?string
    {
        return $this->answerComments;
    }

    public function setAnswerComments(?string $answerComments): self
    {
        $this->answerComments = $answerComments;
        return $this;
    }

    public function getTextAfterAnswers(): ?string
    {
        return $this->textAfterAnswers;
    }

    public function setTextAfterAnswers(?string $textAfterAnswers): self
    {
        $this->textAfterAnswers = $textAfterAnswers;
        return $this;
    }

    public function getAnswerMatchLeft(): ?string
    {
        return $this->answerMatchLeft;
    }

    public function setAnswerMatchLeft(?string $answerMatchLeft): self
    {
        $this->answerMatchLeft = $answerMatchLeft;
        return $this;
    }

    public function getAnswerMatchRight(): ?string
    {
        return $this->answerMatchRight;
    }

    public function setAnswerMatchRight(?string $answerMatchRight): self
    {
        $this->answerMatchRight = $answerMatchRight;
        return $this;
    }

    public function getMatchingAnswerIncorrectMatches(): ?string
    {
        return $this->matchingAnswerIncorrectMatches;
    }

    public function setMatchingAnswerIncorrectMatches(?string $matchingAnswerIncorrectMatches): self
    {
        $this->matchingAnswerIncorrectMatches = $matchingAnswerIncorrectMatches;
        return $this;
    }

    public function getNumericalAnswerType(): ?string
    {
        return $this->numericalAnswerType;
    }

    public function setNumericalAnswerType(?string $numericalAnswerType): self
    {
        $this->numericalAnswerType = $numericalAnswerType;
        return $this;
    }

    public function getExact(): ?float
    {
        return $this->exact;
    }

    public function setExact(?float $exact): self
    {
        $this->exact = $exact;
        return $this;
    }

    public function getMargin(): ?float
    {
        return $this->margin;
    }

    public function setMargin(?float $margin): self
    {
        $this->margin = $margin;
        return $this;
    }

    public function getApproximate(): ?float
    {
        return $this->approximate;
    }

    public function setApproximate(?float $approximate): self
    {
        $this->approximate = $approximate;
        return $this;
    }

    public function getPrecision(): ?int
    {
        return $this->precision;
    }
    public function setPrecision(?int $precision): self
    {
        $this->precision = $precision;
        return $this;
    }

    public function getStart(): ?float
    {
        return $this->start;
    }

    public function setStart(?float $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function getEnd(): ?float
    {
        return $this->end;
    }

    public function setEnd(?float $end): self
    {
        $this->end = $end;
        return $this;
    }

    public function getBlankId(): ?int
    {
        return $this->blankId;
    }

    public function setBlankId(?int $blankId): self
    {
        $this->blankId = $blankId;
        return $this;
    }
}

