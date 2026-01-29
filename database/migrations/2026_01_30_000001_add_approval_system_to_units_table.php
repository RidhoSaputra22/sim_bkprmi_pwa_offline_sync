<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan sistem approval untuk Unit TPA:
     * - SuperAdmin BKPRMI harus approve sebelum Admin LPPTKA bisa buat akun TPA
     * - Syarat approve: harus upload sertifikat unit ke SuperAdmin
     */
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            // Status approval dari SuperAdmin
            $table->string('approval_status')->default('pending')->after('email');

            // Tanggal disetujui/ditolak
            $table->timestamp('approved_at')->nullable()->after('approval_status');

            // User yang melakukan approval (SuperAdmin)
            $table->foreignId('approved_by')->nullable()->after('approved_at')
                ->constrained('users')->nullOnDelete();

            // Catatan/komentar approval (alasan ditolak, dll)
            $table->text('approval_notes')->nullable()->after('approved_by');

            // Path file sertifikat unit (syarat wajib untuk approval)
            $table->string('certificate_path')->nullable()->after('approval_notes');

            // Tanggal upload sertifikat
            $table->timestamp('certificate_uploaded_at')->nullable()->after('certificate_path');

            // User ID untuk Admin TPA (jika sudah dibuatkan akun)
            $table->foreignId('admin_user_id')->nullable()->after('certificate_uploaded_at')
                ->constrained('users')->nullOnDelete();

            // Add index for faster queries
            $table->index('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['admin_user_id']);
            $table->dropIndex(['approval_status']);

            $table->dropColumn([
                'approval_status',
                'approved_at',
                'approved_by',
                'approval_notes',
                'certificate_path',
                'certificate_uploaded_at',
                'admin_user_id',
            ]);
        });
    }
};
