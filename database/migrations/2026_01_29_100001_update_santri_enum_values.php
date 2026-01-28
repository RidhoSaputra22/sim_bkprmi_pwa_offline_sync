<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update jenjang_santri values to match new enum
        DB::table('santris')->where('jenjang_santri', 'pemula')->update(['jenjang_santri' => 'tka']);
        DB::table('santris')->where('jenjang_santri', 'menengah')->update(['jenjang_santri' => 'tpa']);
        DB::table('santris')->where('jenjang_santri', 'lanjutan')->update(['jenjang_santri' => 'tqa']);

        // Update kelas_mengaji values to match new enum
        DB::table('santris')->where('kelas_mengaji', 'Iqro 1')->update(['kelas_mengaji' => 'iqra_1_3']);
        DB::table('santris')->where('kelas_mengaji', 'Iqro 2')->update(['kelas_mengaji' => 'iqra_1_3']);
        DB::table('santris')->where('kelas_mengaji', 'Iqro 3')->update(['kelas_mengaji' => 'iqra_1_3']);
        DB::table('santris')->where('kelas_mengaji', 'Iqro 4')->update(['kelas_mengaji' => 'iqra_4_6']);
        DB::table('santris')->where('kelas_mengaji', 'Iqro 5')->update(['kelas_mengaji' => 'iqra_4_6']);
        DB::table('santris')->where('kelas_mengaji', 'Iqro 6')->update(['kelas_mengaji' => 'iqra_4_6']);
        DB::table('santris')->where('kelas_mengaji', "Al-Qur'an")->update(['kelas_mengaji' => 'tadarrus_1_15']);

        // Update status_santri values to match new enum
        DB::table('santris')->where('status_santri', 'nonaktif')->update(['status_santri' => 'berhenti']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse jenjang_santri
        DB::table('santris')->where('jenjang_santri', 'tka')->update(['jenjang_santri' => 'pemula']);
        DB::table('santris')->where('jenjang_santri', 'tpa')->update(['jenjang_santri' => 'menengah']);
        DB::table('santris')->where('jenjang_santri', 'tqa')->update(['jenjang_santri' => 'lanjutan']);

        // Reverse kelas_mengaji
        DB::table('santris')->where('kelas_mengaji', 'iqra_1_3')->update(['kelas_mengaji' => 'Iqro 1']);
        DB::table('santris')->where('kelas_mengaji', 'iqra_4_6')->update(['kelas_mengaji' => 'Iqro 4']);
        DB::table('santris')->where('kelas_mengaji', 'tadarrus_1_15')->update(['kelas_mengaji' => "Al-Qur'an"]);

        // Reverse status_santri
        DB::table('santris')->where('status_santri', 'berhenti')->update(['status_santri' => 'nonaktif']);
    }
};
