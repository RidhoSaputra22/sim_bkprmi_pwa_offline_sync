<?php

namespace App\Models;

use App\Enum\RoleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'person_id',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(RoleType|string $role): bool
    {
        $roleValue = $role instanceof RoleType ? $role->value : $role;

        return $this->roles()
            ->where('role', $roleValue)
            ->exists();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        $roleValues = collect($roles)->map(function ($role) {
            return $role instanceof RoleType ? $role->value : $role;
        })->toArray();

        return $this->roles()
            ->whereIn('role', $roleValues)
            ->exists();
    }

    /**
     * Get user's primary role.
     */
    public function getPrimaryRole(): ?RoleType
    {
        $firstRole = $this->roles()->first();

        if (! $firstRole) {
            return null;
        }

        return RoleType::tryFrom($firstRole->role);
    }
}
