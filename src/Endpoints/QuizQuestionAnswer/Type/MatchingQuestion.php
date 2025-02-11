<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\MatchingInterface;

/**
 * Class MatchingQuestion
 * Represents a matching_question type answer in the Canvas LMS API.
 */
class MatchingQuestion extends AbstractAnswer implements MatchingInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'matching_question';
    }
}
