<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert existing single values to JSON arrays
        DB::table('units')->whereNotNull('waktu_kegiatan')->orderBy('id')->each(function ($unit) {
            $value = $unit->waktu_kegiatan;
            // Skip if already valid JSON array
            if (str_starts_with($value, '[')) {
                return;
            }
            DB::table('units')->where('id', $unit->id)->update([
                'waktu_kegiatan' => json_encode([$value]),
            ]);
        });

        Schema::table('units', function (Blueprint $table) {
            $table->json('waktu_kegiatan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert JSON arrays back to single string values
        DB::table('units')->whereNotNull('waktu_kegiatan')->orderBy('id')->each(function ($unit) {
            $value = $unit->waktu_kegiatan;
            $decoded = json_decode($value, true);
            if (is_array($decoded) && count($decoded) > 0) {
                DB::table('units')->where('id', $unit->id)->update([
                    'waktu_kegiatan' => $decoded[0],
                ]);
            }
        });

        Schema::table('units', function (Blueprint $table) {
            $table->string('waktu_kegiatan')->nullable()->change();
        });
    }
};
