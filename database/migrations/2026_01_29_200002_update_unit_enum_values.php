<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Update old tipe_lokasi and status_bangunan enum values in units table
     */
    public function up(): void
    {
        // Map old tipe_lokasi values to new values
        $tipeLokasiMapping = [
            'perkotaan' => 'masjid',
            'pedesaan' => 'mushallah',
            'pesisir' => 'rumah_biasa',
            'pegunungan' => 'bangunan_khusus',
        ];

        foreach ($tipeLokasiMapping as $old => $new) {
            DB::table('units')
                ->where('tipe_lokasi', $old)
                ->update(['tipe_lokasi' => $new]);
        }

        // Map old status_bangunan values to new values
        $statusBangunanMapping = [
            'milik_sendiri' => 'milik_sendiri',
            'sewa' => 'sewa',
            'pinjam' => 'waqaf',
        ];

        foreach ($statusBangunanMapping as $old => $new) {
            DB::table('units')
                ->where('status_bangunan', $old)
                ->update(['status_bangunan' => $new]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Map new values back to old values
        $tipeLokasiMapping = [
            'masjid' => 'perkotaan',
            'mushallah' => 'pedesaan',
            'rumah_biasa' => 'pesisir',
            'bangunan_khusus' => 'pegunungan',
        ];

        foreach ($tipeLokasiMapping as $new => $old) {
            DB::table('units')
                ->where('tipe_lokasi', $new)
                ->update(['tipe_lokasi' => $old]);
        }

        $statusBangunanMapping = [
            'waqaf' => 'pinjam',
        ];

        foreach ($statusBangunanMapping as $new => $old) {
            DB::table('units')
                ->where('status_bangunan', $new)
                ->update(['status_bangunan' => $old]);
        }
    }
};
