<?php

namespace Hurah\Canvas\Endpoints\QuizQuestion;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

/**
 *
 */
class QuizQuestionCollection extends AbstractCollectionDataType
{


    /**
     * @throws Exception
     */
    public function addArray(array $module): self
    {

        $this->array[] = QuizQuestion::fromCanvasArray($module);
        return $this;
    }

    /**
     * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): self
    {

        $out = new self();
        foreach ($canvasCollection as $module) {
            $out->addArray($module);
        }
        return $out;
    }


    /**
     * @return QuizQuestion
     */
    public function current(): QuizQuestion
    {
        return $this->array[$this->position];
    }
}