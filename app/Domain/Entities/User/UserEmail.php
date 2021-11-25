<?php

namespace App\Domain\Entities\User;

use App\Domain\Exceptions\User\InvalidEmailException;

class UserEmail extends DomainEntity
{

    /**
     * @throws InvalidEmailException
     */
    public function __construct(?string $email){
        if (empty($email)) {
            throw new InvalidEmailException('cannot be empty');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email . " is not a valid email adress");
        }else{
            $this->value = $email;
        }
    }

}
