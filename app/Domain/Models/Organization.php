<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'logo',
    ];

    public static function getPrivilegedRoles(): array
    {
        return [
            'admin',
            'owner',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['role', 'id']);
    }

    public function workspaces(): HasMany
    {
        return $this->hasMany(Workspace::class)->with('users');
    }

    public function isUserPrivileged(int $user_id): bool
    {
        return $this->users()->wherePivotIn('role', self::getPrivilegedRoles())->find($user_id) !== null;
    }
}
