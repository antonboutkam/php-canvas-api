<?php

namespace Hurah\Canvas\Endpoints\Quiz;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class QuizCollection extends AbstractCollectionDataType
{


    /**
     * @throws Exception
     */
    public function addArray(array $module): self
    {

        $this->array[] = Quiz::fromCanvasArray($module);
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


    public function current(): Quiz
    {
        return $this->array[$this->position];
    }
}