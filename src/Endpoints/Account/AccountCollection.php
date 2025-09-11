<?php

namespace Hurah\Canvas\Endpoints\Account;

use Exception;
use Hurah\Types\Type\AbstractCollectionDataType;


class AccountCollection extends AbstractCollectionDataType
{
    /**
     * @throws Exception
     */
    public static function fromCanvasArray(array $accountCollection): AccountCollection
    {
        $out = new self();
        foreach ($accountCollection as $course) {
            $out->addArray($course);
        }
        return $out;
    }

    /**
     * @throws Exception
     */
    public function addArray(array $account): self
    {

        $this->array[] = Account::fromArray($account);
        return $this;
    }

    public function add(Account $account): void
    {
        $this->array[] = $account;
    }

    public function current(): Account
    {
        return $this->array[$this->position];
    }

}