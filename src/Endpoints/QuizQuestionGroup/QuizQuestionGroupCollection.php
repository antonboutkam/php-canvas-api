<?php

namespace Hurah\Canvas\Endpoints\QuizQuestionGroup;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class QuizQuestionGroupCollection extends AbstractCollectionDataType
{


    /**
     * @throws Exception
     */
    public function addArray(array $module): self
    {

        $this->array[] = QuizQuestionGroup::fromCanvasArray($module);
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


    public function current(): QuizQuestionGroup
    {
        return $this->array[$this->position];
    }
}