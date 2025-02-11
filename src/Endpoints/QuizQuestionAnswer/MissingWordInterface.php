<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer;

/**
 * Interface QuizQuestionAnswerInterface
 * Defines the contract for a quiz question answer.
 */
interface MissingWordInterface
{
    /**
     * Get the text that follows the missing word (used in missing word questions).
     */
    public function getTextAfterAnswers(): ?string;

    /**
     * Set the text that follows the missing word (used in missing word questions).
     */
    public function setTextAfterAnswers(?string $textAfterAnswers): self;



}
