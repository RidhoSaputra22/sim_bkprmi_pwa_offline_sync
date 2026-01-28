<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2'] as $name) {
            EducationLevel::query()->firstOrCreate(['name' => $name]);
        }

        foreach (['Pelajar', 'Mahasiswa', 'Guru', 'Wiraswasta', 'Pegawai'] as $name) {
            Job::query()->firstOrCreate(['name' => $name]);
        }

        // run sql file
        $sqlFilePath = [
            'database/seeders/sql/01_provinces.sql',
            'database/seeders/sql/02_cities.sql',
            'database/seeders/sql/03_districts.sql',
            'database/seeders/sql/04_villages.sql',
        ];

        foreach ($sqlFilePath as $path) {
            if (File::exists($path)) {
                DB::unprepared(File::get($path));
            } else {
                $this->command->error("File SQL tidak ditemukan: $path");
            }
        }

    }
}
