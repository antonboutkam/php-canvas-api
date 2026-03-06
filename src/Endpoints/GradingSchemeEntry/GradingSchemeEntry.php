<?php

namespace Hurah\Canvas\Endpoints\GradingSchemeEntry;


use Hurah\Canvas\Endpoints\CanvasObject;

class GradingSchemeEntry extends CanvasObject{
    private $name;
    private $value;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getValue(): float {
        return $this->value;
    }

    public function setValue(float $value): self {
        $this->value = $value;
        return $this;
    }

    public function toCanvasArray():array
    {
        $aOut = array_filter($this->toArray());
        return ['grading_scheme_entry' => $aOut];
    }
    public static function fromArray(array $aGradingSchemeEntry): self
    {
        $instance = new self();

        $instance->setName($aGradingSchemeEntry['name'] ?? null);
        $instance->setValue($aGradingSchemeEntry['value'] ?? null);

        return $instance;
    }



}
