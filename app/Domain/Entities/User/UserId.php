<?php

namespace App\Domain\Entities\User;

class UserId extends DomainEntity
{

    public function __construct(?int $id)
    {
        $this->value = $id;
    }

}
