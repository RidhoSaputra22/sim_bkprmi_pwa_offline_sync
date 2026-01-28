<?php

namespace Database\Factories;

use App\Enum\Gender;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        $hasNik = $this->faker->boolean(100);

        return [
            'nik' => $hasNik ? $this->faker->unique()->numerify('################') : null,
            'full_name' => $this->faker->name(),
            'birth_place' => $this->faker->city(),
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(Gender::cases()),
            'education_level_id' => null,
            'job_id' => null,
            'phone' => $this->faker->optional()->phoneNumber(),
        ];
    }
}
