<?php

declare(strict_types=1);

namespace Hurah\Canvas\Endpoints\QuizQuestionAnswer\Type;

use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AbstractAnswer;
use Hurah\Canvas\Endpoints\QuizQuestionAnswer\AnswerInterface;

/**
 * Class FileUploadQuestion
 * Represents a file_upload_question type answer in the Canvas LMS API.
 */
class FileUploadQuestion extends AbstractAnswer implements AnswerInterface
{
    /**
     * Returns the type of the quiz question answer.
     */
    public function getType(): string
    {
        return 'file_upload_question';
    }
}
