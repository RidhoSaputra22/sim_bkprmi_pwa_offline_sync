<?php

namespace Database\Seeders;

use App\Enum\RoleType;
use App\Models\Person;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Struktur Role:
     * 1. SuperAdmin BKPRMI - Dashboard pemantauan & approval TPA
     * 2. Admin LPPTKA - Input profil TPA & buat akun TPA
     * 3. Admin TPA - Input data santri & data TPA sendiri
     */
    public function run(): void
    {
        // Create SuperAdmin BKPRMI
        $superAdminPerson = Person::factory()->create([
            'full_name' => 'SuperAdmin BKPRMI',
        ]);

        // Create Admin LPPTKA
        $adminLpptka = Person::factory()->create([
            'full_name' => 'Admin LPPTKA',
        ]);

        // Create Admin LPPTKA
        $adminTpa = Person::factory()->create([
            'full_name' => 'Admin TPA',
        ]);

        // Create User SuperAdmin
        $userSuperAdmin = User::factory()->create([
            'person_id' => $superAdminPerson->id,
            'email' => 'superadmin@bkprmi.com',
            'password' => bcrypt('superadmin'),
        ]);

        // Create User Admin LPPTKA
        $userAdminLpptka = User::factory()->create([
            'person_id' => $adminLpptka->id,
            'email' => 'admin.lpptka@bkprmi.com',
            'password' => bcrypt('adminlpptka'),
        ]);

        $userAdminTpa = User::factory()->create([
            'person_id' => $adminTpa->id,
            'email' => 'admin.tpa@bkprmi.com',
            'password' => bcrypt('admintpa'),
        ]);

        // Assign Role SuperAdmin
        UserRole::query()->firstOrCreate([
            'user_id' => $userSuperAdmin->id,
            'role' => RoleType::SUPERADMIN->value,
        ]);

        // Assign Role Admin LPPTKA
        UserRole::query()->firstOrCreate([
            'user_id' => $userAdminLpptka->id,
            'role' => RoleType::ADMIN_LPPTKA->value,
        ]);

        // Assign Role Admin TPA
        UserRole::query()->firstOrCreate([
            'user_id' => $userAdminTpa->id,
            'role' => RoleType::ADMIN_TPA->value,
        ]);

        $this->call([
            MasterDataSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
