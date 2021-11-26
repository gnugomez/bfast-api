<?php

namespace App\Domain\Entities\User;

use App\Domain\Entities\DomainEntity;

class UserId extends DomainEntity
{

    public function __construct(?int $id)
    {
        $this->value = $id;
    }

}
