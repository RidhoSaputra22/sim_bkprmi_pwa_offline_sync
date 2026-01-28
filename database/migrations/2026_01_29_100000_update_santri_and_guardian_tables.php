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
        // Update santris table
        Schema::table('santris', function (Blueprint $table) {
            if (!Schema::hasColumn('santris', 'village_id')) {
                $table->foreignId('village_id')->nullable()->after('region_id')->constrained('villages')->nullOnDelete();
            }
            if (!Schema::hasColumn('santris', 'address')) {
                $table->text('address')->nullable()->after('nama_ibu');
            }
            if (!Schema::hasColumn('santris', 'rt')) {
                $table->string('rt', 5)->nullable()->after('address');
            }
            if (!Schema::hasColumn('santris', 'rw')) {
                $table->string('rw', 5)->nullable()->after('rt');
            }
        });

        // Update guardians table
        Schema::table('guardians', function (Blueprint $table) {
            if (!Schema::hasColumn('guardians', 'pendidikan_terakhir')) {
                $table->string('pendidikan_terakhir')->nullable()->after('person_id');
            }
            if (!Schema::hasColumn('guardians', 'pekerjaan')) {
                $table->string('pekerjaan')->nullable()->after('pendidikan_terakhir');
            }
            if (!Schema::hasColumn('guardians', 'created_at')) {
                $table->timestamps();
            }
        });

        // Update guardian_santri table
        Schema::table('guardian_santri', function (Blueprint $table) {
            if (Schema::hasColumn('guardian_santri', 'hubungan_keluarga')) {
                $table->renameColumn('hubungan_keluarga', 'hubungan');
            } elseif (!Schema::hasColumn('guardian_santri', 'hubungan')) {
                $table->string('hubungan')->nullable()->after('santri_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->dropConstrainedForeignId('village_id');
            $table->dropColumn(['address', 'rt', 'rw']);
        });

        Schema::table('guardians', function (Blueprint $table) {
            $table->dropColumn(['pendidikan_terakhir', 'pekerjaan']);
        });

        Schema::table('guardian_santri', function (Blueprint $table) {
            $table->renameColumn('hubungan', 'hubungan_keluarga');
        });
    }
};
