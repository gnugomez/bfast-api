<?php

namespace App\Api\Domain\Entities;

/**
 * @property string $value
 */
class DomainEntity
{
    private $__value;

    public function __get($name)
    {
        return $this->__value;
    }
}