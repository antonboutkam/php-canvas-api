<?php

namespace Hurah\Canvas\Endpoints\AssignmentGroup;


use Hurah\Types\Type\AbstractCollectionDataType;

class AssignmentGroupCollection extends AbstractCollectionDataType
{

    /**
     * @throws \Exception
     */
    public static function fromCanvasArray(array $canvasCollection, int $iCanvasCourseId): self
    {
        $out = new self();
        foreach($canvasCollection as $assignment_group)
        {
            $out->addArray($assignment_group, $iCanvasCourseId);
        }
        return $out;
    }
    /**
     * @throws \Exception
     */
    public function addArray(array $assignment_group, int $iCanvasCourseId): self
    {
        $this->array[] = AssignmentGroup::fromCanvasArray($assignment_group, $iCanvasCourseId);
        return $this;
    }

    public function add(AssignmentGroup $assignment_group)
    {
        $this->array[] = $assignment_group;
    }
    #[\ReturnTypeWillChange]
    public function current():AssignmentGroup
    {
        return $this->array[$this->position];
    }

}