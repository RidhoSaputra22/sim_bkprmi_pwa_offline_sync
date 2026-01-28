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
        // Update unit_heads table - add pendidikan and pekerjaan
        Schema::table('unit_heads', function (Blueprint $table) {
            $table->string('pendidikan_terakhir')->nullable()->after('person_id');
            $table->string('pekerjaan')->nullable()->after('pendidikan_terakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_heads', function (Blueprint $table) {
            $table->dropColumn(['pendidikan_terakhir', 'pekerjaan']);
        });
    }
};
