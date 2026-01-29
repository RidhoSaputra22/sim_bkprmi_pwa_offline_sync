<?php

namespace App\Models;

use App\Enum\StatusApprovalUnit;
use App\Enum\StatusBangunan;
use App\Enum\TipeLokasi;
use App\Enum\WaktuKegiatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_number',
        'name',
        'region_id',
        'village_id',
        'address',
        'rt',
        'rw',
        'tipe_lokasi',
        'status_bangunan',
        'waktu_kegiatan',
        'mosque_name',
        'founder',
        'formed_at',
        'joined_year',
        'email',
        'jumlah_tka_4_7',
        'jumlah_tpa_7_12',
        'jumlah_tqa_wisuda',
        'jumlah_guru_laki_laki',
        'jumlah_guru_perempuan',
        // Approval System Fields
        'approval_status',
        'approved_at',
        'approved_by',
        'approval_notes',
        'certificate_path',
        'certificate_uploaded_at',
        'admin_user_id',
    ];

    protected $casts = [
        'formed_at' => 'date',
        'joined_year' => 'integer',
        'tipe_lokasi' => TipeLokasi::class,
        'status_bangunan' => StatusBangunan::class,
        'waktu_kegiatan' => WaktuKegiatan::class,
        'approval_status' => StatusApprovalUnit::class,
        'approved_at' => 'datetime',
        'certificate_uploaded_at' => 'datetime',
        'jumlah_tka_4_7' => 'integer',
        'jumlah_tpa_7_12' => 'integer',
        'jumlah_tqa_wisuda' => 'integer',
        'jumlah_guru_laki_laki' => 'integer',
        'jumlah_guru_perempuan' => 'integer',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function unitHead(): HasOne
    {
        return $this->hasOne(UnitHead::class);
    }

    public function unitAdmin(): HasOne
    {
        return $this->hasOne(UnitAdmin::class);
    }

    /**
     * User yang melakukan approval (SuperAdmin)
     */
    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * User akun Admin TPA untuk unit ini
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Santri yang terdaftar di unit ini
     */
    public function santriUnits(): HasMany
    {
        return $this->hasMany(SantriUnit::class);
    }

    /**
     * Kegiatan yang dilaksanakan oleh unit ini
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    // ========================================
    // APPROVAL SYSTEM METHODS
    // ========================================

    /**
     * Check if unit is pending approval
     */
    public function isPending(): bool
    {
        return $this->approval_status === StatusApprovalUnit::PENDING;
    }

    /**
     * Check if unit is approved
     */
    public function isApproved(): bool
    {
        return $this->approval_status === StatusApprovalUnit::APPROVED;
    }

    /**
     * Check if unit is rejected
     */
    public function isRejected(): bool
    {
        return $this->approval_status === StatusApprovalUnit::REJECTED;
    }

    /**
     * Check if certificate has been uploaded
     */
    public function hasCertificate(): bool
    {
        return ! empty($this->certificate_path);
    }

    /**
     * Check if unit can be approved (has certificate uploaded)
     */
    public function canBeApproved(): bool
    {
        return $this->hasCertificate() && $this->isPending();
    }

    /**
     * Check if TPA account can be created
     * Syarat: Unit sudah diapprove oleh SuperAdmin
     */
    public function canCreateAdminAccount(): bool
    {
        return $this->isApproved() && empty($this->admin_user_id);
    }

    /**
     * Check if unit already has admin account
     */
    public function hasAdminAccount(): bool
    {
        return ! empty($this->admin_user_id);
    }

    /**
     * Approve unit by SuperAdmin
     */
    public function approve(User $approver, ?string $notes = null): bool
    {
        if (! $this->canBeApproved()) {
            return false;
        }

        $this->update([
            'approval_status' => StatusApprovalUnit::APPROVED,
            'approved_at' => now(),
            'approved_by' => $approver->id,
            'approval_notes' => $notes,
        ]);

        return true;
    }

    /**
     * Reject unit by SuperAdmin
     */
    public function reject(User $approver, string $notes): bool
    {
        if (! $this->isPending()) {
            return false;
        }

        $this->update([
            'approval_status' => StatusApprovalUnit::REJECTED,
            'approved_at' => now(),
            'approved_by' => $approver->id,
            'approval_notes' => $notes,
        ]);

        return true;
    }

    /**
     * Reset to pending status (for resubmission)
     */
    public function resetToPending(): bool
    {
        if (! $this->isRejected()) {
            return false;
        }

        $this->update([
            'approval_status' => StatusApprovalUnit::PENDING,
            'approved_at' => null,
            'approved_by' => null,
            'approval_notes' => null,
        ]);

        return true;
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Scope: Only pending units
     */
    public function scopePending($query)
    {
        return $query->where('approval_status', StatusApprovalUnit::PENDING);
    }

    /**
     * Scope: Only approved units
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', StatusApprovalUnit::APPROVED);
    }

    /**
     * Scope: Only rejected units
     */
    public function scopeRejected($query)
    {
        return $query->where('approval_status', StatusApprovalUnit::REJECTED);
    }

    /**
     * Scope: Units with certificate uploaded
     */
    public function scopeWithCertificate($query)
    {
        return $query->whereNotNull('certificate_path');
    }

    /**
     * Scope: Units without admin account
     */
    public function scopeWithoutAdminAccount($query)
    {
        return $query->whereNull('admin_user_id');
    }

    /**
     * Scope: Units ready for account creation (approved but no account yet)
     */
    public function scopeReadyForAccount($query)
    {
        return $query->approved()->withoutAdminAccount();
    }
}
