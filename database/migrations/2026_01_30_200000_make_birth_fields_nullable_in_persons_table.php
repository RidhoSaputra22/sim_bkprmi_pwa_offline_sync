<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        // Kolom ini sebelumnya dibuat NOT NULL, tapi flow pembuatan akun/admin tidak selalu mengisi.
        // Jadi kita ubah agar nullable supaya insert person tidak gagal.

        // SQLite tidak mendukung ALTER COLUMN, jadi kita skip karena SQLite
        // tidak strict enforce NOT NULL constraint saat insert.
        if ($driver === 'sqlite') {
            return;
        }

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE persons MODIFY birth_place VARCHAR(255) NULL');
            DB::statement('ALTER TABLE persons MODIFY birth_date DATE NULL');

            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL');
            DB::statement('ALTER TABLE persons ALTER COLUMN birth_date DROP NOT NULL');

            return;
        }

        // Fallback untuk driver lain: gunakan Schema builder
        Schema::table('persons', function (Blueprint $table) {
            $table->string('birth_place')->nullable()->change();
            $table->date('birth_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        // SQLite tidak mendukung ALTER COLUMN, skip.
        if ($driver === 'sqlite') {
            return;
        }

        // Pastikan tidak ada data null saat rollback.
        DB::table('persons')->whereNull('birth_place')->update(['birth_place' => '-']);
        DB::table('persons')->whereNull('birth_date')->update(['birth_date' => '1970-01-01']);

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE persons MODIFY birth_place VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE persons MODIFY birth_date DATE NOT NULL');

            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE persons ALTER COLUMN birth_place SET NOT NULL');
            DB::statement('ALTER TABLE persons ALTER COLUMN birth_date SET NOT NULL');

            return;
        }

        // Fallback untuk driver lain: gunakan Schema builder
        Schema::table('persons', function (Blueprint $table) {
            $table->string('birth_place')->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->change();
        });
    }
};
