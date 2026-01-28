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
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('persons');
            $table->foreignId('region_id')->constrained();

            $table->unsignedInteger('child_order')->nullable();
            $table->unsignedInteger('siblings_count')->nullable();

            $table->string('jenjang_santri')->nullable();
            $table->string('kelas_mengaji')->nullable();
            $table->string('status_santri')->nullable();

            $table->boolean('graduated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
