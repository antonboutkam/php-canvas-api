<?php

namespace Hurah\Canvas\Endpoints\MasteryPath;

use Hurah\Canvas\Endpoints\CanvasObject;

class MasteryPath extends CanvasObject
{
    private ?bool $locked = null;
    private array $assignmentSets = [];
    private string|int|null $selectedSetId = null;
    private ?bool $awaitingChoice = null;
    private ?bool $stillProcessing = null;
    private ?string $modulesUrl = null;
    private ?string $chooseUrl = null;
    private ?bool $modulesTabDisabled = null;

    public static function fromCanvasArray(array $array): self
    {
        $instance = new self();
        $instance->setLocked($array['locked'] ?? null);
        $instance->setAssignmentSets($array['assignment_sets'] ?? []);
        $instance->setSelectedSetId($array['selected_set_id'] ?? null);
        $instance->setAwaitingChoice($array['awaiting_choice'] ?? null);
        $instance->setStillProcessing($array['still_processing'] ?? null);
        $instance->setModulesUrl($array['modules_url'] ?? null);
        $instance->setChooseUrl($array['choose_url'] ?? null);
        $instance->setModulesTabDisabled($array['modules_tab_disabled'] ?? null);
        return $instance;
    }

    public function toCanvasArray(): array
    {
        return [
            'locked' => $this->getLocked(),
            'assignment_sets' => $this->getAssignmentSets(),
            'selected_set_id' => $this->getSelectedSetId(),
            'awaiting_choice' => $this->getAwaitingChoice(),
            'still_processing' => $this->getStillProcessing(),
            'modules_url' => $this->getModulesUrl(),
            'choose_url' => $this->getChooseUrl(),
            'modules_tab_disabled' => $this->getModulesTabDisabled(),
        ];
    }

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(?bool $locked): static
    {
        $this->locked = $locked;
        return $this;
    }

    public function getAssignmentSets(): array
    {
        return $this->assignmentSets;
    }

    public function setAssignmentSets(array $assignmentSets): static
    {
        $this->assignmentSets = $assignmentSets;
        return $this;
    }

    public function getSelectedSetId(): int|string|null
    {
        return $this->selectedSetId;
    }

    public function setSelectedSetId(int|string|null $selectedSetId): static
    {
        $this->selectedSetId = $selectedSetId;
        return $this;
    }

    public function getAwaitingChoice(): ?bool
    {
        return $this->awaitingChoice;
    }

    public function setAwaitingChoice(?bool $awaitingChoice): static
    {
        $this->awaitingChoice = $awaitingChoice;
        return $this;
    }

    public function getStillProcessing(): ?bool
    {
        return $this->stillProcessing;
    }

    public function setStillProcessing(?bool $stillProcessing): static
    {
        $this->stillProcessing = $stillProcessing;
        return $this;
    }

    public function getModulesUrl(): ?string
    {
        return $this->modulesUrl;
    }

    public function setModulesUrl(?string $modulesUrl): static
    {
        $this->modulesUrl = $modulesUrl;
        return $this;
    }

    public function getChooseUrl(): ?string
    {
        return $this->chooseUrl;
    }

    public function setChooseUrl(?string $chooseUrl): static
    {
        $this->chooseUrl = $chooseUrl;
        return $this;
    }

    public function getModulesTabDisabled(): ?bool
    {
        return $this->modulesTabDisabled;
    }

    public function setModulesTabDisabled(?bool $modulesTabDisabled): static
    {
        $this->modulesTabDisabled = $modulesTabDisabled;
        return $this;
    }
}
