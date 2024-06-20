<?php

namespace Hurah\Canvas\Endpoints\Submission;

use Hurah\Canvas\Endpoints\Assignment\Assignment;
use Hurah\Types\Type\AbstractCollectionDataType;

class SubmissionCollection extends AbstractCollectionDataType
{

    /**
     * @throws \Exception
     */
    public static function fromCanvasArray(array $canvasCollection, Assignment $assignment): SubmissionCollection
    {
        $out = new self();
        foreach($canvasCollection as $submission)
        {
            $out->addArray($submission, $assignment);
        }
        return $out;
    }
    /**
     * @throws \Exception
     */
    public function addArray(array $submission, Assignment $assignment): self
    {
        $this->add(Submission::fromCanvasArray($submission, $assignment));
        return $this;
    }

    public function add(Submission $submission)
    {
        $this->array[$this->position] = $submission;
    }

    public function current():Submission
    {
        return $this->array[$this->position];
    }

}