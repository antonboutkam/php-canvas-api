<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;

/**
 * Class TrueFalseQuestion
 * Represents a true_false_question type answer in the Canvas LMS API.
 */
class TrueFalseQuestion extends AbstractAnswer implements AnswerInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'true_false_question';
    }
}
