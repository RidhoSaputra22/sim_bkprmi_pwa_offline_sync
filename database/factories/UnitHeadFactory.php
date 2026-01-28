<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Unit;
use App\Models\UnitHead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnitHead>
 */
class UnitHeadFactory extends Factory
{
    protected $model = UnitHead::class;

    public function definition(): array
    {
        return [
            'unit_id' => Unit::query()->inRandomOrder()->value('id') ?? Unit::factory(),
            'person_id' => Person::query()->inRandomOrder()->value('id') ?? Person::factory(),
        ];
    }
}
