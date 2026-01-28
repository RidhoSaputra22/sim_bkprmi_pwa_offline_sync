<?php

namespace Database\Factories;

use App\Models\Guardian;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guardian>
 */
class GuardianFactory extends Factory
{
    protected $model = Guardian::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::query()->inRandomOrder()->value('id') ?? Person::factory(),
        ];
    }
}
