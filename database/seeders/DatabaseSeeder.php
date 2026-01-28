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
     */
    public function run(): void
    {

        $superAdmin = Person::factory()->create([
            'full_name' => 'Super Admin',
        ]);

        $admin = Person::factory()->create([
            'full_name' => 'Admin',
        ]);

        $person = Person::factory()->create([
            'full_name' => 'Santri User',
        ]);

        $userSuperAdmin = User::factory()->create([
            'person_id' => $superAdmin->id,
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin'),
        ]);

        $userAdmin = User::factory()->create([
            'person_id' => $admin->id,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        $userSantri = User::factory()->create([

            'person_id' => $person->id,
            'email' => 'santri@gmail.com',
            'password' => bcrypt('santri'),
        ]);

        UserRole::query()->firstOrCreate([
            'user_id' => $userSuperAdmin->id,
            'role' => RoleType::SUPERADMIN->value,
        ]);

        UserRole::query()->firstOrCreate([
            'user_id' => $userAdmin->id,
            'role' => RoleType::ADMIN->value,
        ]);

        UserRole::query()->firstOrCreate([
            'user_id' => $userSantri->id,
            'role' => RoleType::SANTRI->value,
        ]);

        $this->call([
            MasterDataSeeder::class,
            DemoDataSeeder::class,
        ]);

    }
}
