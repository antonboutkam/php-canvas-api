<?php

namespace Hurah\Canvas\Endpoints\Course;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;


class CourseCollection extends AbstractCollectionDataType
{
        /**
         * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): CourseCollection
    {
        $out = new self();
        foreach($canvasCollection as $course)
        {
            $out->addArray($course);
        }
        return $out;
    }
    /**
     * @throws Exception
     */
    public function addArray(array $course): self
    {

        $this->array[] = Course::fromArray($course);
        return $this;
    }

    public function add(Course $course): void
    {
        $this->array[] = $course;
    }

    public function current():Course
    {
        return $this->array[$this->position];
    }

}