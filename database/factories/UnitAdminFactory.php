<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Unit;
use App\Models\UnitAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnitAdmin>
 */
class UnitAdminFactory extends Factory
{
    protected $model = UnitAdmin::class;

    public function definition(): array
    {
        return [
            'unit_id' => Unit::query()->inRandomOrder()->value('id') ?? Unit::factory(),
            'person_id' => Person::query()->inRandomOrder()->value('id') ?? Person::factory(),
        ];
    }
}
