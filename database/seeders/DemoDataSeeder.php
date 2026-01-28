<?php

namespace Database\Seeders;

use App\Enum\HubunganWaliSantri;
use App\Enum\RoleType;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\EducationLevel;
use App\Models\Guardian;
use App\Models\GuardianSantri;
use App\Models\Job;
use App\Models\Person;
use App\Models\Region;
use App\Models\Santri;
use App\Models\SantriUnit;
use App\Models\Unit;
use App\Models\UnitAdmin;
use App\Models\UnitHead;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Regions
        $regions = Region::factory()->count(20)->create();

        // Persons
        $educationLevelIds = EducationLevel::query()->pluck('id')->all();
        $jobIds = Job::query()->pluck('id')->all();

        $persons = Person::factory()
            ->count(80)
            ->state(function () use ($educationLevelIds, $jobIds) {
                return [
                    'education_level_id' => Arr::random($educationLevelIds),
                    'job_id' => Arr::random($jobIds),
                ];
            })
            ->create();

        // Users (create a predictable admin user for Filament login)
        $adminPerson = Person::factory()->create([
            'full_name' => 'Administrator',
        ]);

        $adminUser = User::query()->firstOrCreate(
            ['email' => 'admin@bkprmi.test'],
            [
                'person_id' => $adminPerson->id,
                // User model casts `password` => 'hashed'
                'password' => 'password',
                'is_active' => true,
            ],
        );

        $users = User::factory()
            ->count(11)
            ->state(function () use ($persons) {
                return [
                    'person_id' => $persons->random()->id,
                ];
            })
            ->create()
            ->prepend($adminUser);

        // Assign roles
        $availableRoles = RoleType::cases();
        foreach ($users as $index => $user) {
            $role = $index === 0
                ? RoleType::SUPERADMIN
                : Arr::random($availableRoles);

            UserRole::query()->firstOrCreate([
                'user_id' => $user->id,
                'role' => $role->value,
            ]);
        }

        // Units
        $units = Unit::factory()->count(10)->create([
            'region_id' => $regions->random()->id,
        ]);

        // Unit heads: one per unit
        foreach ($units as $unit) {
            UnitHead::factory()->create([
                'unit_id' => $unit->id,
                'person_id' => $persons->random()->id,
            ]);
        }

        // Unit admins: 2 per unit
        foreach ($units as $unit) {
            UnitAdmin::factory()->count(2)->create([
                'unit_id' => $unit->id,
                'person_id' => $persons->random()->id,
            ]);
        }

        // Santris
        $santris = Santri::factory()
            ->count(40)
            ->state(function () use ($persons, $regions) {
                return [
                    'person_id' => $persons->random()->id,
                    'region_id' => $regions->random()->id,
                ];
            })
            ->create();

        // SantriUnits (membership)
        foreach ($santris as $santri) {
            SantriUnit::factory()->create([
                'santri_id' => $santri->id,
                'unit_id' => $units->random()->id,
            ]);
        }

        // Guardians
        $guardians = Guardian::factory()
            ->count(25)
            ->state(fn () => ['person_id' => $persons->random()->id])
            ->create();

        // Guardian <-> Santri relationships
        foreach ($santris as $santri) {
            // attach 1-2 guardians per santri
            $attachCount = random_int(1, 2);
            for ($i = 0; $i < $attachCount; $i++) {
                GuardianSantri::factory()->create([
                    'guardian_id' => $guardians->random()->id,
                    'santri_id' => $santri->id,
                    'hubungan' => Arr::random(HubunganWaliSantri::cases())->value,
                ]);
            }
        }

        // Activities
        Activity::factory()->count(30)->create([
            'created_by' => $users->random()->id,
            'unit_id' => $units->random()->id,
        ]);

        Activity::factory()->count(10)->create([
            'created_by' => $users->random()->id,
            'unit_id' => null,
        ]);

        // Activity logs
        ActivityLog::factory()->count(80)->create([
            'user_id' => $users->random()->id,
        ]);
    }
}
