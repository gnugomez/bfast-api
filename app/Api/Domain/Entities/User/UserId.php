<?php

namespace App\Api\Domain\Entities\User;

class UserId extends DomainEntity
{

    public function __construct(?int $id)
    {
        $this->value = $id;
    }

}
