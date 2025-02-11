<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;

/**
 * Class MultipleChoiceQuestion
 * Represents a multiple_choice_question type answer in the Canvas LMS API.
 */
class MultipleChoiceQuestion extends AbstractAnswer implements AnswerInterface
{

    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'multiple_choice_question';
    }
}
