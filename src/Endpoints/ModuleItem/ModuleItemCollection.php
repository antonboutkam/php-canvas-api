<?php

namespace Hurah\Canvas\Endpoints\ModuleItem;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class ModuleItemCollection extends AbstractCollectionDataType
{

    /**
     * @throws Exception
     */
    public function addArray(array $module): self
    {

        $this->array[] = ModuleItem::fromCanvasArray($module);
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


    public function current(): ModuleItem
    {
        return $this->array[$this->position];
    }
}