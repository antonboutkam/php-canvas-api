<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\NumericalInterface;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;

/**
 * Class NumericalQuestion
 * Represents a numerical_question type answer in the Canvas LMS API.
 */
class NumericalQuestion extends AbstractAnswer implements NumericalInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'numerical_question';
    }
}
