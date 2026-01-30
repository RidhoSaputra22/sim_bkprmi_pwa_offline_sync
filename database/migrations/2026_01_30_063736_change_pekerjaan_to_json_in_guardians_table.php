<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, get existing data
        $guardians = DB::table('guardians')->whereNotNull('pekerjaan')->get();

        // Convert existing string data to JSON array
        foreach ($guardians as $guardian) {
            if ($guardian->pekerjaan && $guardian->pekerjaan !== '') {
                // If it's already a valid JSON, skip
                if (json_decode($guardian->pekerjaan) !== null) {
                    continue;
                }
                // Convert single value to array
                DB::table('guardians')
                    ->where('id', $guardian->id)
                    ->update(['pekerjaan' => json_encode([$guardian->pekerjaan])]);
            }
        }

        // Change column type from string to json
        Schema::table('guardians', function (Blueprint $table) {
            $table->json('pekerjaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get existing data
        $guardians = DB::table('guardians')->whereNotNull('pekerjaan')->get();

        // Convert JSON array back to single string (take first value)
        foreach ($guardians as $guardian) {
            if ($guardian->pekerjaan) {
                $pekerjaan = json_decode($guardian->pekerjaan, true);
                if (is_array($pekerjaan) && count($pekerjaan) > 0) {
                    DB::table('guardians')
                        ->where('id', $guardian->id)
                        ->update(['pekerjaan' => $pekerjaan[0]]);
                }
            }
        }

        // Change column type back to string
        Schema::table('guardians', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->change();
        });
    }
};
