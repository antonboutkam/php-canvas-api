<?php

namespace Hurah\Canvas\Endpoints\Module;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class ModuleCollection extends AbstractCollectionDataType
{


    /**
     * @throws Exception
     */
    public function addArray(array $module): self
    {

        $this->array[] = Module::fromCanvasArray($module);
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


    public function current(): Module
    {
        return $this->array[$this->position];
    }
}