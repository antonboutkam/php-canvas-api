<?php

namespace Hurah\Canvas\Endpoints\Student;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class StudentCollection extends AbstractCollectionDataType
{

    /**
     * @throws Exception
     */
    public function addArray(array $student): self
    {
        $this->add(Student::fromCanvasArray($student));
        return $this;
    }

    public function add(Student $oStudent): void
    {
        $this->array[] = $oStudent;
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