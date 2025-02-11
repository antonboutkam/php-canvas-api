<?php

namespace Hurah\Canvas\Endpoints\GradingStandard;

use Hurah\Canvas\Endpoints\GradingStandard\GradingStandard;
use Hurah\Types\Type\AbstractCollectionDataType;


class GradingStandardCollection extends AbstractCollectionDataType
{
        /**
     * @throws \Exception
     */
    public static function fromCanvasArray(array $canvasCollection): GradingStandardCollection
    {
        $out = new self();
        foreach($canvasCollection as $gradingStandard)
        {
            $out->addArray($gradingStandard);
        }
        return $out;
    }
    /**
     * @throws \Exception
     */
    public function addArray(array $gradingStandard): self
    {

        $this->array[] = GradingStandard::fromArray($gradingStandard);
        return $this;
    }

    public function add(GradingStandard $gradingStandard): void
    {
        $this->array[] = $gradingStandard;
    }

    public function current():GradingStandard
    {
        return $this->array[$this->position];
    }

}