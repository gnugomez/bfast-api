<?php

namespace App\Domain\Entities\User;

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
    public UserName $name;

    /**
     * @var UserName
     *
     * @OA\Property(
     *     type="string",
     * )
     */
    public UserSurname $surname;

    /**
     * @var UserEmail
     *
     * @OA\Property(
     *     type="string",
     * )
     */
    public UserEmail $email;
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
    protected UserPassword $password;

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
