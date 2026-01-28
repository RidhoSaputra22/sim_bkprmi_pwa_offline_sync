<?php

namespace Database\Factories;

use App\Enum\StatusBangunan;
use App\Enum\TipeLokasi;
use App\Enum\WaktuKegiatan;
use App\Models\Region;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'unit_number' => 'UNIT-' . $this->faker->unique()->numerify('#####'),
            'name' => $this->faker->company(),

            'region_id' => Region::query()->inRandomOrder()->value('id') ?? Region::factory(),
            'tipe_lokasi' => Arr::random(TipeLokasi::cases())->value,
            'status_bangunan' => Arr::random(StatusBangunan::cases())->value,
            'waktu_kegiatan' => Arr::random(WaktuKegiatan::cases())->value,

            'mosque_name' => $this->faker->company() . ' Mosque',
            'founder' => $this->faker->name(),
            'formed_at' => $this->faker->date(),
            'joined_year' => (int) $this->faker->numberBetween(2000, (int) date('Y')),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
