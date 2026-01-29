<?php

namespace App\Models;

use App\Enum\RoleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     * Unit yang dikelola oleh Admin TPA ini
     */
    public function managedUnit(): HasOne
    {
        return $this->hasOne(Unit::class, 'admin_user_id');
    }

    /**
     * Units yang diapprove oleh user ini (SuperAdmin)
     */
    public function approvedUnits(): HasMany
    {
        return $this->hasMany(Unit::class, 'approved_by');
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

    // ========================================
    // ROLE-SPECIFIC CHECKS
    // ========================================

    /**
     * Check if user is SuperAdmin BKPRMI
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleType::SUPERADMIN);
    }

    /**
     * Check if user is Admin LPPTKA
     */
    public function isAdminLpptka(): bool
    {
        return $this->hasRole(RoleType::ADMIN_LPPTKA);
    }

    /**
     * Check if user is Admin TPA
     */
    public function isAdminTpa(): bool
    {
        return $this->hasRole(RoleType::ADMIN_TPA);
    }

    // ========================================
    // PERMISSION CHECKS
    // ========================================

    /**
     * Check if user can approve units
     */
    public function canApproveUnit(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Check if user can create TPA accounts
     * Only Admin LPPTKA can create TPA accounts for approved units
     */
    public function canCreateTpaAccount(): bool
    {
        return $this->isAdminLpptka();
    }

    /**
     * Check if user can manage santri
     * Only Admin TPA can manage santri data
     */
    public function canManageSantri(): bool
    {
        return $this->isAdminTpa();
    }

    /**
     * Check if user can input unit profiles
     * Admin LPPTKA can input unit profiles
     */
    public function canInputUnitProfile(): bool
    {
        return $this->isAdminLpptka();
    }

    /**
     * Check if user can upload certificate
     */
    public function canUploadCertificate(): bool
    {
        return $this->isAdminLpptka();
    }

    /**
     * Check if user can view dashboard
     */
    public function canViewDashboard(): bool
    {
        return $this->isSuperAdmin();
    }

    /**
     * Get the unit this Admin TPA manages
     */
    public function getUnit(): ?Unit
    {
        if (! $this->isAdminTpa()) {
            return null;
        }

        return $this->managedUnit;
    }
}
