<?php

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer;

interface FillInBlanksInterface
{

    /**
     * Get the blank ID (used in fill-in-multiple-blanks and multiple dropdowns questions).
     */
    public function getBlankId(): ?int;

    /**
     * Set the blank ID (used in fill-in-multiple-blanks and multiple dropdowns questions).
     */
    public function setBlankId(?int $blankId): self;
}