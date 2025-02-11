<?php

namespace Hurah\Canvas\Endpoints\Attachment;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;


class AttachmentCollection extends AbstractCollectionDataType
{
    /**
     * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): AttachmentCollection
    {
        $out = new self();
        foreach ($canvasCollection as $attachment) {
            $out->addArray($attachment);
        }
        return $out;
    }

    /**
     * @throws Exception
     */
    public function addArray(array $attachment): self
    {

        $this->array[] = Attachment::fromCanvasArray($attachment);
        return $this;
    }

    public function add(Attachment $attachment): void
    {
        $this->array[] = $attachment;
    }

    public function current(): Attachment
    {
        return $this->array[$this->position];
    }

}