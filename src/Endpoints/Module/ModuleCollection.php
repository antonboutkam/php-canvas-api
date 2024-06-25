<?php

namespace Hurah\Canvas\Endpoints\Module;

use Exception;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Type\AbstractCollectionDataType;

class ModuleCollection extends AbstractCollectionDataType
{

    public function findOneByName(string $sModuleName):Module
    {
        foreach ($this as $oModule)
        {
            if($oModule->getName() === $sModuleName)
            {
                return $oModule;
            }
        }
        throw new NullPointerException("No module found that goes by the name {$sModuleName}");
    }

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