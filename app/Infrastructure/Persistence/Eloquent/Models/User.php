<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

/**
 * @property mixed $username
 * @property mixed $password
 * @property mixed $email
 * @method find($id)
 * @method create(array $data)
 * @method first()
 * @method paginate(mixed|null $perPage, string[] $columns)
 * @method count()
 * @method where(string $field, string $operator, $value)
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $table = 'Users';

    public function findForPassport($username)
    {
        return $user = (new User)->where('email', '=', $username)->orWhere('username', $username)->first();
    }
}
