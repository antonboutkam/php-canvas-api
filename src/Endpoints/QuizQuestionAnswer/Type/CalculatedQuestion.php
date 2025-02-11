<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\NumericalInterface;

/**
 * Class CalculatedQuestion
 * Represents a calculated_question type answer in the Canvas LMS API.
 */
class CalculatedQuestion extends AbstractAnswer implements NumericalInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'calculated_question';
    }
}
