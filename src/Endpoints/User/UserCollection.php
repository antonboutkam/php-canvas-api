<?php

namespace Hurah\Canvas\Endpoints\User;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;

/**
 *
 */
class UserCollection extends AbstractCollectionDataType
{
    /**
     * @throws Exception
     */
    public static function fromCanvasArray(array $canvasCollection): UserCollection
    {
        $out = new self();
        foreach ($canvasCollection as $user) {
            $out->addArray($user);
        }
        return $out;
    }

    /**
     * @throws Exception
     */
    public function addArray(array $user): self
    {
        $this->add(User::fromCanvasArray($user));
        return $this;
    }

    /**
     * @param User $user
     * @return void
     */
    public function add(User $user): self
    {
        $this->array[] = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function current(): User
    {
        return $this->array[$this->position];
    }
}