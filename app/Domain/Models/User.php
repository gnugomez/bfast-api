<?php

namespace App\Domain\Models;

use Faker\Core\Number;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @property mixed $name
 * @property mixed $surname
 * @property mixed $password
 * @property mixed $email
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'surname', 'role',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $table = 'users';

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)->withPivot("role");
    }

    public function workspaces($organization_id): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class)->withPivot("role")->where("organization_id", $organization_id);
    }

    public function isPrivilegedInOrganization(int $organization_id): bool
    {
        return $this->organizations()->wherePivotIn("role", Organization::getPrivilegedRoles())->find($organization_id) !== null;
    }
}
