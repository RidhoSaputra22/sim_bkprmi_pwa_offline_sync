<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Region;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Region>
 */
class RegionFactory extends Factory
{
    protected $model = Region::class;

    public function definition(): array
    {
        $token = $this->faker->unique()->numerify('###');

        $province = Province::query()->firstOrCreate(['name' => "Provinsi {$token}"]);
        $city = City::query()->firstOrCreate(['name' => "Kota {$token}", 'province_id' => $province->id]);
        $district = District::query()->firstOrCreate(['name' => "Kecamatan {$token}", 'city_id' => $city->id]);
        $village = Village::query()->firstOrCreate(['name' => "Desa {$token}", 'district_id' => $district->id]);

        return [
            'province_id' => $province->id,
            'city_id' => $city->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
            'jalan' => $this->faker->streetAddress(),
            'rt' => $this->faker->numerify('###'),
            'rw' => $this->faker->numerify('###'),
        ];
    }
}
