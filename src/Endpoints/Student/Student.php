<?php

namespace Hurah\Canvas\Endpoints\Student;

use DateTime;
use Hurah\Canvas\Endpoints\CanvasObject;
use Hurah\Types\Type\Email;

class Student extends CanvasObject
{
    private int $id;
    private string $name;
    private DateTime $created_at;
    private string $sortable_name;
    private string $short_name;
    private ?string $sis_user_id = null;
    private ?string $integration_id = null;
    private string $login_id;
    private Email $email;
    private ?string $has_non_collaborative_groups = null;


    public static function fromCanvasArray(array $data): Student
    {
        $student = new Student();

        if (isset($data['id'])) {
            $student->setId($data['id']);
        }
        if (isset($data['name'])) {
            $student->setName($data['name']);
        }
        if (isset($data['created_at'])) {
            $dateTime = self::makeDate($data['created_at']);

            $student->setCreatedAt($dateTime);
        }
        if (isset($data['sortable_name'])) {
            $student->setSortableName($data['sortable_name']);
        }
        if (isset($data['short_name'])) {
            $student->setShortName($data['short_name']);
        }
        if (isset($data['sis_user_id'])) {
            $student->setSisUserId($data['sis_user_id']);
        }
        if (!empty($data['integration_id'])) {
            $student->setIntegrationId($data['integration_id']);
        }
        if (isset($data['login_id'])) {
            $student->setLoginId($data['login_id']);
        }
        if (isset($data['email'])) {
            $student->setEmail(new Email($data['email']));
        }
        if (!empty($data['has_non_collaborative_groups'])) {
            $student->setHasNonCollaborativeGroups($data['has_non_collaborative_groups']);
        }

        return $student;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function getSortableName(): string
    {
        return $this->sortable_name;
    }

    public function getShortName(): string
    {
        return $this->short_name;
    }

    public function getSisUserId(): ?string
    {
        return $this->sis_user_id;
    }

    public function getIntegrationId(): ?string
    {
        return $this->integration_id;
    }

    public function getLoginId(): string
    {
        return $this->login_id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getHasNonCollaborativeGroups(): ?string
    {
        return $this->has_non_collaborative_groups;
    }

    // Fluent Setters
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setCreatedAt(?DateTime $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function setSortableName(string $sortable_name): self
    {
        $this->sortable_name = $sortable_name;
        return $this;
    }

    public function setShortName(string $short_name): self
    {
        $this->short_name = $short_name;
        return $this;
    }

    public function setSisUserId(string $sis_user_id): self
    {
        $this->sis_user_id = $sis_user_id;
        return $this;
    }

    public function setIntegrationId($integration_id): self
    {
        $this->integration_id = $integration_id;
        return $this;
    }

    public function setLoginId($login_id): self
    {
        $this->login_id = $login_id;
        return $this;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setHasNonCollaborativeGroups(?string $has_non_collaborative_groups): self
    {
        $this->has_non_collaborative_groups = $has_non_collaborative_groups;
        return $this;
    }

}