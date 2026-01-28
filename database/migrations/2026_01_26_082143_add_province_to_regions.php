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
        Schema::table('regions', function (Blueprint $table) {
            // Drop legacy unique index first (if present) so MySQL can drop the columns cleanly.
            $table->dropUnique('regions_province_city_district_village_unique');

            $table->dropColumn(['province', 'city', 'district', 'village']);

            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();

            // New unique index on foreign keys.
            $table->unique(['province_id', 'city_id', 'district_id', 'village_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            // Drop new unique index first so MySQL can drop the foreign keys cleanly.
            $table->dropUnique('regions_province_id_city_id_district_id_village_id_unique');

            $table->dropConstrainedForeignId('province_id');
            $table->dropConstrainedForeignId('city_id');
            $table->dropConstrainedForeignId('district_id');
            $table->dropConstrainedForeignId('village_id');

            $table->string('province', 191);
            $table->string('city', 191);
            $table->string('district', 191);
            $table->string('village', 191);

            $table->unique(['province', 'city', 'district', 'village']);

        });
    }
};
