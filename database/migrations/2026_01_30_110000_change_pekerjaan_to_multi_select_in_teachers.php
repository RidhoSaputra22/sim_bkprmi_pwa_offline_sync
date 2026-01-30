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
        Schema::table('teachers', function (Blueprint $table) {
            // Drop old single pekerjaan field
            $table->dropForeign(['job_id']);
            $table->dropColumn('job_id');

            // Add new multi-select pekerjaan field as JSON
            $table->json('pekerjaan')->nullable()->after('education_level_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Remove JSON pekerjaan field
            $table->dropColumn('pekerjaan');

            // Restore old job_id field
            $table->foreignId('job_id')->nullable()->after('education_level_id')->constrained('jobs')->onDelete('set null');
        });
    }
};
