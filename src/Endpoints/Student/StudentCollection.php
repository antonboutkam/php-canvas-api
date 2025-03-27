<?php

namespace Hurah\Canvas\Endpoints\Student;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class StudentCollection extends AbstractCollectionDataType
{

    /**
     * @throws Exception
     */
    public function addArray(array $module): self
    {
        $this->array[] = Student::fromCanvasArray($module);
        return $this;
    }

    /**
     * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): self
    {
        $self = new StudentCollection();
        foreach ($canvasCollection as $student) {
            $self->addArray($student);
        }
        return $self;
    }

    /**
     * @return Student
     */
    public function current(): Student
    {
        return $this->array[$this->position];
    }
}