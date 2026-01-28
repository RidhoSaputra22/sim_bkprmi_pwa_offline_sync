<?php

namespace Database\Factories;

use App\Enum\JenjangSantri;
use App\Enum\KelasMengaji;
use App\Enum\StatusSantri;
use App\Models\Person;
use App\Models\Region;
use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Santri>
 */
class SantriFactory extends Factory
{
    protected $model = Santri::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::query()->inRandomOrder()->value('id') ?? Person::factory(),
            'region_id' => Region::query()->inRandomOrder()->value('id') ?? Region::factory(),

            'child_order' => $this->faker->numberBetween(1, 10),
            'siblings_count' => $this->faker->numberBetween(0, 10),

            'jenjang_santri' => Arr::random(JenjangSantri::cases())->value,
            'kelas_mengaji' => Arr::random(KelasMengaji::cases())->value,
            'status_santri' => Arr::random(StatusSantri::cases())->value,

            'graduated' => $this->faker->boolean(10),
        ];
    }
}
