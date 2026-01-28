<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            if (! Schema::hasColumn('units', 'jumlah_tka_4_7')) {
                $table->unsignedInteger('jumlah_tka_4_7')->nullable()->after('email');
            }
            if (! Schema::hasColumn('units', 'jumlah_tpa_7_12')) {
                $table->unsignedInteger('jumlah_tpa_7_12')->nullable()->after('jumlah_tka_4_7');
            }
            if (! Schema::hasColumn('units', 'jumlah_tqa_wisuda')) {
                $table->unsignedInteger('jumlah_tqa_wisuda')->nullable()->after('jumlah_tpa_7_12');
            }
            if (! Schema::hasColumn('units', 'jumlah_guru_laki_laki')) {
                $table->unsignedInteger('jumlah_guru_laki_laki')->nullable()->after('jumlah_tqa_wisuda');
            }
            if (! Schema::hasColumn('units', 'jumlah_guru_perempuan')) {
                $table->unsignedInteger('jumlah_guru_perempuan')->nullable()->after('jumlah_guru_laki_laki');
            }
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            foreach ([
                'jumlah_guru_perempuan',
                'jumlah_guru_laki_laki',
                'jumlah_tqa_wisuda',
                'jumlah_tpa_7_12',
                'jumlah_tka_4_7',
            ] as $column) {
                if (Schema::hasColumn('units', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
