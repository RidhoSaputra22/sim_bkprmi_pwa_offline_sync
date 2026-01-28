<?php

namespace Database\Factories;

use App\Models\Santri;
use App\Models\SantriUnit;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SantriUnit>
 */
class SantriUnitFactory extends Factory
{
    protected $model = SantriUnit::class;

    public function definition(): array
    {
        $joinedAt = $this->faker->dateTimeBetween('-2 years', 'now');
        $leftAt = $this->faker->dateTimeBetween($joinedAt, 'now');

        return [
            'santri_id' => Santri::query()->inRandomOrder()->value('id') ?? Santri::factory(),
            'unit_id' => Unit::query()->inRandomOrder()->value('id') ?? Unit::factory(),
            'joined_at' => $joinedAt->format('Y-m-d'),
            'left_at' => $leftAt?->format('Y-m-d'),
        ];
    }
}
