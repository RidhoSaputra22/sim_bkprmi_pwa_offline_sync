<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // Relasi ke unit
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');

            // Data Identitas Pribadi
            $table->string('nik', 16)->unique();
            $table->string('full_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('gender', 20); // laki-laki or perempuan
            $table->string('phone', 15);
            $table->string('photo_path')->nullable(); // Path untuk foto 1/2 badan

            // Pendidikan dan Pekerjaan
            $table->foreignId('education_level_id')->nullable()->constrained('education_levels')->onDelete('set null');
            $table->foreignId('job_id')->nullable()->constrained('jobs')->onDelete('set null');

            // Alamat Lengkap
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('district_id')->nullable()->constrained('districts')->onDelete('set null');
            $table->foreignId('village_id')->nullable()->constrained('villages')->onDelete('set null');
            $table->string('jalan')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();

            // Jabatan di TPA (Tugas Utama)
            $table->enum('jabatan_utama', [
                'kepala_unit',
                'wakil_kepala_unit',
                'kepala_tata_usaha',
                'bendahara',
                'wali_kelas',
                'guru_iqra',
                'guru_tadarrus',
                'karyawan_tenaga_kependidikan'
            ]);

            // Tugas Tambahan (Multiple - stored as JSON)
            $table->json('tugas_tambahan')->nullable(); // Array of: admin_operator, guru_iqra, guru_tadarrus

            // Riwayat Pelatihan - LMD
            $table->enum('level_lmd', ['lmd_1', 'lmd_2', 'lmd_3', 'belum_pernah'])->default('belum_pernah');
            $table->string('sertifikat_lmd_path')->nullable(); // Path untuk sertifikat LMD (PDF)

            // Riwayat Pelatihan - Pelatihan Guru Mengaji
            $table->enum('level_pelatihan_guru', ['level_a', 'level_b', 'level_c', 'belum_pernah'])->default('belum_pernah');
            $table->string('sertifikat_pelatihan_path')->nullable(); // Path untuk sertifikat Pelatihan Guru (PDF)

            // Status Aktif
            $table->boolean('is_active')->default(true);

            // Metadata
            $table->timestamps();
            $table->softDeletes(); // Soft delete untuk history

            // Indexes
            $table->index(['unit_id', 'is_active']);
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
