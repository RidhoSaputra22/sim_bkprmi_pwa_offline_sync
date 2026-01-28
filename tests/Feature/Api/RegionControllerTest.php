<?php

namespace Tests\Feature\Api;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Province $province;
    protected City $city;
    protected District $district;
    protected Village $village;

    protected function setUp(): void
    {
        parent::setUp();

        // Create region hierarchy
        $this->province = Province::create(['name' => 'Aceh']);
        $this->city = City::create(['province_id' => $this->province->id, 'name' => 'Kabupaten Aceh Selatan']);
        $this->district = District::create(['city_id' => $this->city->id, 'name' => 'Bakongan']);
        $this->village = Village::create(['district_id' => $this->district->id, 'name' => 'Keude Bakongan']);
    }

    /** @test */
    public function can_get_provinces()
    {
        $response = $this->getJson('/api/regions/provinces');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Aceh']);
    }

    /** @test */
    public function can_get_cities_by_province()
    {
        $response = $this->getJson('/api/regions/cities?province_id=' . $this->province->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Kabupaten Aceh Selatan']);
    }

    /** @test */
    public function get_cities_requires_province_id()
    {
        $response = $this->getJson('/api/regions/cities');

        // API requires province_id, so returns validation error
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('province_id');
    }

    /** @test */
    public function can_get_districts_by_city()
    {
        $response = $this->getJson('/api/regions/districts?city_id=' . $this->city->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Bakongan']);
    }

    /** @test */
    public function get_districts_requires_city_id()
    {
        $response = $this->getJson('/api/regions/districts');

        // API requires city_id, so returns validation error
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('city_id');
    }

    /** @test */
    public function can_get_villages_by_district()
    {
        $response = $this->getJson('/api/regions/villages?district_id=' . $this->district->id);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Keude Bakongan']);
    }

    /** @test */
    public function get_villages_requires_district_id()
    {
        $response = $this->getJson('/api/regions/villages');

        // API requires district_id, so returns validation error
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('district_id');
    }

    /** @test */
    public function cities_are_ordered_by_name()
    {
        City::create(['province_id' => $this->province->id, 'name' => 'Kota Banda Aceh']);
        City::create(['province_id' => $this->province->id, 'name' => 'Kabupaten Aceh Besar']);

        $response = $this->getJson('/api/regions/cities?province_id=' . $this->province->id);

        $response->assertStatus(200);
        $cities = $response->json();

        // Should be ordered alphabetically
        $this->assertEquals('Kabupaten Aceh Besar', $cities[0]['name']);
        $this->assertEquals('Kabupaten Aceh Selatan', $cities[1]['name']);
        $this->assertEquals('Kota Banda Aceh', $cities[2]['name']);
    }
}
