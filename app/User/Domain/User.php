<?php

namespace App\User\Domain;

use App\User\Domain\Exceptions\DomainException;
use App\User\Domain\ValueObjects\UserEmail;
use App\User\Domain\ValueObjects\UserId;
use App\User\Domain\ValueObjects\UserName;
use App\User\Domain\ValueObjects\UserPassword;

/**
 * Class User
 * @property UserId $id
 * @package App\User\Domain
 * @OA\Schema (
 *     description="User",
 *     title="User",
 * )
 */
class User
{

    /**
     * @var UserId
     *
     * @OA\Property(
     *     type="integer",
     * )
     */
    public UserId $id;

    /**
     * @var UserName
     *
     * @OA\Property(
     *     type="string",
     * )
     */
    public UserName $username;

    /**
     * @var UserEmail
     *
     * @OA\Property(
     *     type="string",
     * )
     */
    public UserEmail $email;

    protected UserPassword $password;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     * )
     */
    public string $created_at;

    /**
     * @var string
     * @OA\Property(
     *     type="string",
     * )
     */
    public string $updated_at;

    public function __construct(?string $userId)
    {
        $this->id = new UserId($userId);
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }

}
