<?php

namespace App\User\Domain\Objects;

class UserId extends DomainProperty
{

    public function __construct(?int $id)
    {
        $this->value = $id;
    }

}
