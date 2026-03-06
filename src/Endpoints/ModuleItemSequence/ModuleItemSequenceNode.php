<?php

namespace Hurah\Canvas\Endpoints\ModuleItemSequence;

use Hurah\Canvas\Endpoints\MasteryPath\MasteryPath;

class ModuleItemSequenceNode
{
    private array $prev = [];
    private array $current = [];
    private array $next = [];
    private ?MasteryPath $masteryPath = null;

    public static function fromCanvasArray(array $array): self
    {
        $instance = new self();
        $instance->setPrev($array['prev'] ?? []);
        $instance->setCurrent($array['current'] ?? []);
        $instance->setNext($array['next'] ?? []);

        if (isset($array['mastery_path']) && is_array($array['mastery_path'])) {
            $instance->setMasteryPath(MasteryPath::fromCanvasArray($array['mastery_path']));
        }

        return $instance;
    }

    public function toCanvasArray(): array
    {
        $out = [
            'prev' => $this->getPrev(),
            'current' => $this->getCurrent(),
            'next' => $this->getNext(),
        ];

        if ($this->getMasteryPath() !== null) {
            $out['mastery_path'] = $this->getMasteryPath()->toCanvasArray();
        }

        return $out;
    }

    public function getPrev(): array
    {
        return $this->prev;
    }

    public function setPrev(array $prev): static
    {
        $this->prev = $prev;
        return $this;
    }

    public function getCurrent(): array
    {
        return $this->current;
    }

    public function setCurrent(array $current): static
    {
        $this->current = $current;
        return $this;
    }

    public function getNext(): array
    {
        return $this->next;
    }

    public function setNext(array $next): static
    {
        $this->next = $next;
        return $this;
    }

    public function getMasteryPath(): ?MasteryPath
    {
        return $this->masteryPath;
    }

    public function setMasteryPath(?MasteryPath $masteryPath): static
    {
        $this->masteryPath = $masteryPath;
        return $this;
    }
}
