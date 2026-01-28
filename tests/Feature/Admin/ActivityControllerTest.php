<?php

namespace Tests\Feature\Admin;

use App\Enum\WaktuKegiatan;
use App\Models\Activity;
use App\Models\Unit;
use App\Models\User;
use App\Models\Village;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Region;
use App\Enum\TipeLokasi;
use App\Enum\StatusBangunan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Unit $unit;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for authentication
        $this->user = User::factory()->create();

        // Create region and unit for activity
        $province = Province::create(['name' => 'Aceh']);
        $city = City::create(['province_id' => $province->id, 'name' => 'Kabupaten Aceh Selatan']);
        $district = District::create(['city_id' => $city->id, 'name' => 'Bakongan']);
        $village = Village::create(['district_id' => $district->id, 'name' => 'Keude Bakongan']);

        $region = Region::create([
            'province_id' => $province->id,
            'city_id' => $city->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
            'jalan' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
        ]);

        $this->unit = Unit::create([
            'unit_number' => 'UNIT-00001',
            'name' => 'TPA Test',
            'region_id' => $region->id,
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::WAQAF->value,
            'waktu_kegiatan' => WaktuKegiatan::SIANG->value,
        ]);
    }

    /** @test */
    public function guest_cannot_access_activities_index()
    {
        $response = $this->get(route('admin.activities.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_activities_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.activities.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.activities.index');
    }

    /** @test */
    public function authenticated_user_can_access_create_activity_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.activities.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.activities.create');
    }

    /** @test */
    public function authenticated_user_can_store_new_activity()
    {
        $activityData = [
            'unit_id' => $this->unit->id,
            'title' => 'Kegiatan Test',
            'description' => 'Deskripsi kegiatan test',
            'activity_date' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('admin.activities.store'), $activityData);

        $response->assertRedirect(route('admin.activities.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('activities', [
            'title' => 'Kegiatan Test',
            'unit_id' => $this->unit->id,
        ]);
    }

    /** @test */
    public function store_activity_requires_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('admin.activities.store'), []);

        $response->assertSessionHasErrors([
            'title',
            'activity_date',
        ]);
    }

    /** @test */
    public function authenticated_user_can_view_activity_details()
    {
        $activity = $this->createActivity();

        $response = $this->actingAs($this->user)
            ->get(route('admin.activities.show', $activity));

        $response->assertStatus(200);
        $response->assertViewIs('admin.activities.show');
        $response->assertViewHas('activity');
    }

    /** @test */
    public function authenticated_user_can_access_edit_activity_page()
    {
        $activity = $this->createActivity();

        $response = $this->actingAs($this->user)
            ->get(route('admin.activities.edit', $activity));

        $response->assertStatus(200);
        $response->assertViewIs('admin.activities.edit');
        $response->assertViewHas('activity');
    }

    /** @test */
    public function authenticated_user_can_update_activity()
    {
        $activity = $this->createActivity();

        $updateData = [
            'unit_id' => $this->unit->id,
            'title' => 'Updated Activity Title',
            'description' => 'Updated description',
            'activity_date' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)
            ->put(route('admin.activities.update', $activity), $updateData);

        $response->assertRedirect(route('admin.activities.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'Updated Activity Title',
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_activity()
    {
        $activity = $this->createActivity();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.activities.destroy', $activity));

        $response->assertRedirect(route('admin.activities.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('activities', [
            'id' => $activity->id,
        ]);
    }

    /** @test */
    public function activities_index_can_filter_by_unit()
    {
        $activity = $this->createActivity();

        $response = $this->actingAs($this->user)
            ->get(route('admin.activities.index', ['unit_id' => $this->unit->id]));

        $response->assertStatus(200);
        $response->assertSee($activity->name);
    }

    /** @test */
    public function activities_index_can_search_by_name()
    {
        $activity = $this->createActivity(['title' => 'Kegiatan Ramadhan']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.activities.index', ['search' => 'Ramadhan']));

        $response->assertStatus(200);
        $response->assertSee('Kegiatan Ramadhan');
    }

    /**
     * Helper method to create an activity for testing
     */
    protected function createActivity(array $overrides = []): Activity
    {
        return Activity::create(array_merge([
            'unit_id' => $this->unit->id,
            'title' => 'Test Activity ' . rand(1, 100),
            'description' => 'Test activity description',
            'activity_date' => now()->format('Y-m-d'),
            'created_by' => $this->user->id,
        ], $overrides));
    }
}
