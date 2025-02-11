<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;

/**
 * Class EssayQuestion
 * Represents a essay_question type answer in the Canvas LMS API.
 *
 * A question on a test or examination on a given topic requiring a written analysis or explanation, usually of a
 * specified length.
 */
class EssayQuestion extends AbstractAnswer implements AnswerInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'essay_question';
    }
}
