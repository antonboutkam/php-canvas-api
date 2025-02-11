<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer;

/**
 * Interface QuizQuestionAnswerInterface
 * Defines the contract for a quiz question answer.
 */
interface MatchingInterface
{
    /**
     * Get the static value displayed on the left for students to match in matching questions.
     */
    public function getAnswerMatchLeft(): ?string;

    /**
     * Set the static value displayed on the left for students to match in matching questions.
     */
    public function setAnswerMatchLeft(?string $answerMatchLeft): self;

    /**
     * Get the correct match for answer_match_left (used in matching questions).
     */
    public function getAnswerMatchRight(): ?string;

    /**
     * Set the correct match for answer_match_left (used in matching questions).
     */
    public function setAnswerMatchRight(?string $answerMatchRight): self;

    /**
     * Get a list of distractors (incorrect matches), delimited by new lines.
     * Used in matching questions.
     */
    public function getMatchingAnswerIncorrectMatches(): ?string;

    /**
     * Set a list of distractors (incorrect matches), delimited by new lines.
     * Used in matching questions.
     */
    public function setMatchingAnswerIncorrectMatches(?string $matchingAnswerIncorrectMatches): self;


}
