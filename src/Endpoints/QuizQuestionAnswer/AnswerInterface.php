<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer;

/**
 * Interface QuizQuestionAnswerInterface
 * Defines the contract for a quiz question answer.
 */
interface AnswerInterface
{
    /**
     * Get the unique identifier for the answer.
     * Do not supply if this answer is part of a new question.
     */
    public function getId(): ?int;

    /**
     * Set the unique identifier for the answer.
     * Do not supply if this answer is part of a new question.
     */
    public function setId(?int $id): self;

    /**
     * Get the text of the answer.
     */
    public function getAnswerText(): ?string;

    /**
     * Set the text of the answer.
     */
    public function setAnswerText(?string $answerText): self;

    /**
     * Get the correctness of the answer.
     * Incorrect answers should be 0, correct answers should be 100.
     */
    public function getAnswerWeight(): ?int;

    /**
     * Set the correctness of the answer.
     * Incorrect answers should be 0, correct answers should be 100.
     */
    public function setAnswerWeight(?int $answerWeight): self;

    /**
     * Get specific contextual comments for a particular answer.
     */
    public function getAnswerComments(): ?string;

    /**
     * Set specific contextual comments for a particular answer.
     */
    public function setAnswerComments(?string $answerComments): self;


}
