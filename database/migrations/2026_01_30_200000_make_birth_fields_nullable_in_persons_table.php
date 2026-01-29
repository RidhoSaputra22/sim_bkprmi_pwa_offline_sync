<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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

        // Fallback: coba statement generik yang aman untuk driver lain.
        DB::statement('ALTER TABLE persons ALTER COLUMN birth_place DROP NOT NULL');
        DB::statement('ALTER TABLE persons ALTER COLUMN birth_date DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

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

        DB::statement('ALTER TABLE persons ALTER COLUMN birth_place SET NOT NULL');
        DB::statement('ALTER TABLE persons ALTER COLUMN birth_date SET NOT NULL');
    }
};
