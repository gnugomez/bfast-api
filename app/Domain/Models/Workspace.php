<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($workspace) {
            $workspace->slug = Str::slug($workspace->name);
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['role', 'id'])->withPivotValue('role', 'member');
    }

    public function organiztion(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
