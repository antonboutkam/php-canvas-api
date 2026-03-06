<?php

namespace Hurah\Canvas\Endpoints\Page;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

class PageCollection extends AbstractCollectionDataType
{


    /**
     * @throws Exception
     */
    public function addArray(array $module): self
    {

        $this->array[] = Page::fromCanvasArray($module);
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


    public function current(): Page
    {
        return $this->array[$this->position];
    }
}