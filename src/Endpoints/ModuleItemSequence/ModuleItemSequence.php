<?php

namespace Hurah\Canvas\Endpoints\ModuleItemSequence;

class ModuleItemSequence
{
    /**
     * @var ModuleItemSequenceNode[]
     */
    private array $items = [];

    private array $modules = [];

    public static function fromCanvasArray(array $array): self
    {
        $instance = new self();

        if (isset($array['items']) && is_array($array['items'])) {
            foreach ($array['items'] as $item) {
                if (!is_array($item)) {
                    continue;
                }
                $instance->addItem(ModuleItemSequenceNode::fromCanvasArray($item));
            }
        }

        $instance->setModules(is_array($array['modules'] ?? null) ? $array['modules'] : []);
        return $instance;
    }

    public function toCanvasArray(): array
    {
        return [
            'items' => array_map(
                static fn(ModuleItemSequenceNode $item) => $item->toCanvasArray(),
                $this->items
            ),
            'modules' => $this->modules,
        ];
    }

    public function addItem(ModuleItemSequenceNode $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return ModuleItemSequenceNode[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function setModules(array $modules): static
    {
        $this->modules = $modules;
        return $this;
    }

    public function getModules(): array
    {
        return $this->modules;
    }
}
