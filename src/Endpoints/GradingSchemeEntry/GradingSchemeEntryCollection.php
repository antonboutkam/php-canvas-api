<?php

namespace Hurah\Canvas\Endpoints\GradingSchemeEntry;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;


class GradingSchemeEntryCollection extends AbstractCollectionDataType
{
        /**
         * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): GradingSchemeEntryCollection
    {
        $out = new self();
        foreach($canvasCollection as $gradingScheme)
        {
            $out->addArray($gradingScheme);
        }
        return $out;
    }
    /**
     * @throws Exception
     */
    public function addArray(array $gradingScheme): self
    {

        $this->array[] = GradingSchemeEntry::fromArray($gradingScheme);
        return $this;
    }

    public function add(GradingSchemeEntry $gradingScheme): void
    {
        $this->array[] = $gradingScheme;
    }

    public function current():GradingSchemeEntry
    {
        return $this->array[$this->position];
    }

}