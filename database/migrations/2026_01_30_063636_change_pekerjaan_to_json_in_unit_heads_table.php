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
        $unitHeads = DB::table('unit_heads')->whereNotNull('pekerjaan')->get();

        // Convert existing string data to JSON array
        foreach ($unitHeads as $unitHead) {
            if ($unitHead->pekerjaan && $unitHead->pekerjaan !== '') {
                // If it's already a valid JSON, skip
                if (json_decode($unitHead->pekerjaan) !== null) {
                    continue;
                }
                // Convert single value to array
                DB::table('unit_heads')
                    ->where('id', $unitHead->id)
                    ->update(['pekerjaan' => json_encode([$unitHead->pekerjaan])]);
            }
        }

        // Change column type from string to json
        Schema::table('unit_heads', function (Blueprint $table) {
            $table->json('pekerjaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get existing data
        $unitHeads = DB::table('unit_heads')->whereNotNull('pekerjaan')->get();

        // Convert JSON array back to single string (take first value)
        foreach ($unitHeads as $unitHead) {
            if ($unitHead->pekerjaan) {
                $pekerjaan = json_decode($unitHead->pekerjaan, true);
                if (is_array($pekerjaan) && count($pekerjaan) > 0) {
                    DB::table('unit_heads')
                        ->where('id', $unitHead->id)
                        ->update(['pekerjaan' => $pekerjaan[0]]);
                }
            }
        }

        // Change column type back to string
        Schema::table('unit_heads', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->change();
        });
    }
};
