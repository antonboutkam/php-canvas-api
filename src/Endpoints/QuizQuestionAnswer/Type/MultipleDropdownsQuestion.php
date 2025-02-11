<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;

/**
 * Class MultipleDropdownsQuestion
 * Represents a multiple_dropdowns_question type answer in the Canvas LMS API.
 */
class MultipleDropdownsQuestion extends AbstractAnswer implements AnswerInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'multiple_dropdowns_question';
    }
}
