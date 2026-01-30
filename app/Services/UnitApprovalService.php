<?php

namespace App\Services;

use App\Enum\RoleType;
use App\Models\Person;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Service untuk mengelola approval unit dan pembuatan akun TPA
 *
 * Alur kerja:
 * 1. Admin LPPTKA input profil TPA
 * 2. Admin LPPTKA upload sertifikat unit
 * 3. SuperAdmin approve/reject unit
 * 4. Jika approved, Admin LPPTKA bisa buat akun TPA
 */
class UnitApprovalService
{
    /**
     * Upload sertifikat unit
     * Hanya bisa dilakukan oleh Admin LPPTKA
     */
    public function uploadCertificate(Unit $unit, string $certificatePath): bool
    {
        $unit->update([
            'certificate_path' => $certificatePath,
            'certificate_uploaded_at' => now(),
        ]);

        return true;
    }

    /**
     * Approve unit oleh SuperAdmin
     *
     * @throws \Exception
     */
    public function approveUnit(Unit $unit, User $approver, ?string $notes = null): bool
    {
        // Validasi: hanya SuperAdmin yang bisa approve
        if (! $approver->isSuperAdmin()) {
            throw new \Exception('Hanya SuperAdmin yang dapat menyetujui unit.');
        }

        // Validasi: unit harus punya sertifikat
        if (! $unit->hasCertificate()) {
            throw new \Exception('Unit harus memiliki sertifikat sebelum disetujui.');
        }

        // Validasi: unit harus dalam status pending
        if (! $unit->isPending()) {
            throw new \Exception('Hanya unit dengan status pending yang dapat disetujui.');
        }

        return $unit->approve($approver, $notes);
    }

    /**
     * Reject unit oleh SuperAdmin
     *
     * @throws \Exception
     */
    public function rejectUnit(Unit $unit, User $approver, string $notes): bool
    {
        // Validasi: hanya SuperAdmin yang bisa reject
        if (! $approver->isSuperAdmin()) {
            throw new \Exception('Hanya SuperAdmin yang dapat menolak unit.');
        }

        // Validasi: unit harus dalam status pending
        if (! $unit->isPending()) {
            throw new \Exception('Hanya unit dengan status pending yang dapat ditolak.');
        }

        // Validasi: harus ada alasan penolakan
        if (empty($notes)) {
            throw new \Exception('Alasan penolakan harus diisi.');
        }

        return $unit->reject($approver, $notes);
    }

    /**
     * Buat akun Admin TPA untuk unit
     * Hanya bisa dilakukan oleh Admin LPPTKA setelah unit diapprove
     *
     * @throws \Exception
     */
    public function createAdminTpaAccount(
        Unit $unit,
        User $creator,
        array $personData,
        string $email,
        ?string $password = null
    ): User {
        // Validasi: hanya Admin LPPTKA yang bisa buat akun
        if (! $creator->isAdminLpptka()) {
            throw new \Exception('Hanya Admin LPPTKA yang dapat membuat akun TPA.');
        }

        // Validasi: unit harus sudah diapprove
        if (! $unit->isApproved()) {
            throw new \Exception('Unit harus disetujui terlebih dahulu sebelum membuat akun.');
        }

        // Validasi: unit belum punya akun
        if ($unit->hasAdminAccount()) {
            throw new \Exception('Unit ini sudah memiliki akun Admin TPA.');
        }

        // Generate password jika tidak disediakan
        $password = $password ?? Str::random(12);

        return DB::transaction(function () use ($unit, $personData, $email, $password) {
            // Buat Person untuk admin
            $person = Person::firstOrCreate([

                'nik' => $personData['nik'] ?? null,
                'full_name' => $personData['full_name'],
                'gender' => $personData['gender'] ?? null,

            ], [
                'birth_place' => $personData['birth_place'] ?? null,
                'birth_date' => $personData['birth_date'] ?? null,
                'phone' => $personData['phone'] ?? null,
                'email' => $email,
            ]);

            // Buat User
            $user = User::create([
                'person_id' => $person->id,
                'email' => $email,
                'password' => Hash::make($password),
                'is_active' => true,
            ]);

            // Assign role Admin TPA
            UserRole::create([
                'user_id' => $user->id,
                'role' => RoleType::ADMIN_TPA->value,
            ]);

            // Link user ke unit
            $unit->update(['admin_user_id' => $user->id]);

            // Return user dengan plain password untuk dikirim ke admin
            $user->plain_password = $password;

            return $user;
        });
    }

    /**
     * Reset unit ke status pending (untuk resubmission setelah ditolak)
     *
     * @throws \Exception
     */
    public function resetToPending(Unit $unit): bool
    {
        if (! $unit->isRejected()) {
            throw new \Exception('Hanya unit dengan status ditolak yang dapat direset.');
        }

        return $unit->resetToPending();
    }

    /**
     * Get units pending approval
     */
    public function getPendingUnits()
    {
        return Unit::pending()
            ->withCertificate()
            ->with(['region.province', 'region.city', 'region.district', 'village'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get units ready for account creation
     */
    public function getUnitsReadyForAccount()
    {
        return Unit::readyForAccount()
            ->with(['region.province', 'region.city', 'region.district', 'village'])
            ->orderBy('approved_at', 'desc')
            ->get();
    }

    /**
     * Get approval statistics for dashboard
     */
    public function getApprovalStats(): array
    {
        return [
            'total_units' => Unit::count(),
            'pending' => Unit::pending()->count(),
            'pending_units' => Unit::pending()->count(),
            'approved' => Unit::approved()->count(),
            'approved_units' => Unit::approved()->count(),
            'rejected' => Unit::rejected()->count(),
            'with_certificate' => Unit::withCertificate()->count(),
            'without_account' => Unit::approved()->withoutAdminAccount()->count(),
            'with_account' => Unit::approved()->whereNotNull('admin_user_id')->count(),
            'active_accounts' => Unit::approved()->whereNotNull('admin_user_id')->count(),
        ];
    }
}
