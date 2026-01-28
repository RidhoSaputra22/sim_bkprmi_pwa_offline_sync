<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            if (! Schema::hasColumn('santris', 'nama_ayah')) {
                $table->string('nama_ayah')->nullable()->after('siblings_count');
            }
            if (! Schema::hasColumn('santris', 'nama_ibu')) {
                $table->string('nama_ibu')->nullable()->after('nama_ayah');
            }
        });
    }

    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            if (Schema::hasColumn('santris', 'nama_ibu')) {
                $table->dropColumn('nama_ibu');
            }
            if (Schema::hasColumn('santris', 'nama_ayah')) {
                $table->dropColumn('nama_ayah');
            }
        });
    }
};
