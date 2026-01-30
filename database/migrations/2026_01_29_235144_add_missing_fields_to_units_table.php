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
        Schema::table('units', function (Blueprint $table) {
            if (! Schema::hasColumn('units', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (! Schema::hasColumn('units', 'jumlah_tka')) {
                $table->integer('jumlah_tka')->default(0);
            }
            if (! Schema::hasColumn('units', 'jumlah_tpa')) {
                $table->integer('jumlah_tpa')->default(0);
            }
            if (! Schema::hasColumn('units', 'jumlah_tqa')) {
                $table->integer('jumlah_tqa')->default(0);
            }
            if (! Schema::hasColumn('units', 'guru_laki')) {
                $table->integer('guru_laki')->default(0);
            }
            if (! Schema::hasColumn('units', 'guru_perempuan')) {
                $table->integer('guru_perempuan')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $columns = ['phone', 'jumlah_tka', 'jumlah_tpa', 'jumlah_tqa', 'guru_laki', 'guru_perempuan'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('units', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
