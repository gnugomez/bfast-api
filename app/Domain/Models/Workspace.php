<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Workspace extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'slug',
    ];

    public static function getPrivilegedRoles(): array
    {
        return [
            'manager',
        ];
    }

    public static function getRoles(): array
    {
        return [
            'manager',
            'member',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($workspace) {
            $slug = Str::slug($workspace->name);

            if (static::where([
                ['slug', '=', $slug],
                ['organization_id', '=', $workspace->organization_id]
            ])->exists()) {
                $slug = $slug . '-' . uniqid();
            }

            $workspace->slug = $slug;
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['role', 'id']);
    }

    public function organiztion(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function changeUserRole(User $user, string $role): bool
    {
        if (in_array($role, Workspace::getRoles())) {
            $this->users()->updateExistingPivot($user->id, ['role' => $role]);
            return true;
        } else {
            return false;
        }
    }
}
