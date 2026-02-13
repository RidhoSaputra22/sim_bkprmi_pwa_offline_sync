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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable()->unique();
            $table->string('full_name');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->foreignId('education_level_id')->nullable();
            $table->foreignId('job_id')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
