<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\FillInBlanksInterface;

/**
 * Class FillInMultipleBlanksQuestion
 * Represents a fill_in_multiple_blanks_question type answer in the Canvas LMS API.
 */
class FillInMultipleBlanksQuestion extends AbstractAnswer implements FillInBlanksInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'fill_in_multiple_blanks_question';
    }
}
