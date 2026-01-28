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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            // MySQL (utf8mb4) composite unique index length safety:
            // 4 columns * 191 chars * 4 bytes ~= 3056 bytes (< 3072 limit)
            $table->string('province', 191);
            $table->string('city', 191);
            $table->string('district', 191);
            $table->string('village', 191);
            $table->timestamps();

            $table->unique(['province', 'city', 'district', 'village']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
