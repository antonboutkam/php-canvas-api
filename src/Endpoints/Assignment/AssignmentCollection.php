<?php

namespace Hurah\Canvas\Endpoints\Assignment;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class AssignmentCollection extends AbstractCollectionDataType
{

    /**
     * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): self
    {
        $out = new self();
        foreach($canvasCollection as $assignment)
        {
            $out->addArray($assignment);
        }
        return $out;
    }
    /**
     * @throws Exception
     */
    public function addArray(array $assignment): self
    {
        $this->array[] = Assignment::fromCanvasArray($assignment);
        return $this;
    }
    public function add(Assignment $assignment): void
    {
        $this->array[] = $assignment;
    }
    public function current():Assignment
    {
        return $this->array[$this->position];
    }
}