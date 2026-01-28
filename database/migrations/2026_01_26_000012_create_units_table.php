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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique();
            $table->string('name');

            $table->foreignId('region_id')->constrained();
            $table->string('tipe_lokasi');
            $table->string('status_bangunan');
            $table->string('waktu_kegiatan');

            $table->string('mosque_name')->nullable();
            $table->string('founder')->nullable();
            $table->date('formed_at')->nullable();
            $table->year('joined_year')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
