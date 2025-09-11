<?php

namespace Hurah\Canvas\Endpoints\Folder;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;


class FolderCollection extends AbstractCollectionDataType
{
    /**
     * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): FolderCollection
    {
        $out = new self();
        foreach ($canvasCollection as $folder) {
            $out->addArray($folder);
        }
        return $out;
    }

    /**
     * @throws Exception
     */
    public function addArray(array $folder): self
    {

        $this->array[] = Folder::fromCanvasArray($folder);
        return $this;
    }

    public function add(Folder $folder): void
    {
        $this->array[] = $folder;
    }

    public function current(): Folder
    {
        return $this->array[$this->position];
    }

}