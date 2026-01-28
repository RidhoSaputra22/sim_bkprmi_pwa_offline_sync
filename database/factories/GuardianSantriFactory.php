<?php

namespace Database\Factories;

use App\Enum\HubunganKeluarga;
use App\Models\Guardian;
use App\Models\GuardianSantri;
use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<GuardianSantri>
 */
class GuardianSantriFactory extends Factory
{
    protected $model = GuardianSantri::class;

    public function definition(): array
    {
        return [
            'guardian_id' => Guardian::query()->inRandomOrder()->value('id') ?? Guardian::factory(),
            'santri_id' => Santri::query()->inRandomOrder()->value('id') ?? Santri::factory(),
            'hubungan_keluarga' => Arr::random(HubunganKeluarga::cases())->value,
        ];
    }
}
