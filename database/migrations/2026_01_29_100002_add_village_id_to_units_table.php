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
            if (!Schema::hasColumn('units', 'village_id')) {
                $table->foreignId('village_id')->nullable()->after('region_id')->constrained('villages')->nullOnDelete();
            }
            if (!Schema::hasColumn('units', 'address')) {
                $table->text('address')->nullable()->after('village_id');
            }
            if (!Schema::hasColumn('units', 'rt')) {
                $table->string('rt', 5)->nullable()->after('address');
            }
            if (!Schema::hasColumn('units', 'rw')) {
                $table->string('rw', 5)->nullable()->after('rt');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            if (Schema::hasColumn('units', 'village_id')) {
                $table->dropConstrainedForeignId('village_id');
            }
            if (Schema::hasColumn('units', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('units', 'rt')) {
                $table->dropColumn('rt');
            }
            if (Schema::hasColumn('units', 'rw')) {
                $table->dropColumn('rw');
            }
        });
    }
};
