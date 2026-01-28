<?php

namespace Tests\Feature\Admin;

use App\Enum\Gender;
use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use App\Enum\StatusBangunan;
use App\Enum\TipeLokasi;
use App\Enum\WaktuKegiatan;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Province $province;
    protected City $city;
    protected District $district;
    protected Village $village;
    protected Region $region;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for authentication
        $this->user = User::factory()->create();

        // Create region data for address selection
        $this->province = Province::create(['name' => 'Aceh']);
        $this->city = City::create(['province_id' => $this->province->id, 'name' => 'Kabupaten Aceh Selatan']);
        $this->district = District::create(['city_id' => $this->city->id, 'name' => 'Bakongan']);
        $this->village = Village::create(['district_id' => $this->district->id, 'name' => 'Keude Bakongan']);

        // Create Region record
        $this->region = Region::create([
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'jalan' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
        ]);
    }

    /** @test */
    public function guest_cannot_access_units_index()
    {
        $response = $this->get(route('admin.units.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_units_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.units.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.units.index');
    }

    /** @test */
    public function authenticated_user_can_access_create_unit_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.units.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.units.create');
        $response->assertViewHas('provinces');
        $response->assertViewHas('tipeLokasiOptions');
        $response->assertViewHas('statusBangunanOptions');
    }

    /** @test */
    public function authenticated_user_can_store_new_unit()
    {
        $unitData = $this->getValidUnitData();

        $response = $this->actingAs($this->user)
            ->post(route('admin.units.store'), $unitData);

        // Check if there's an error flash message
        if ($response->getSession()->has('error')) {
            $this->fail('Store failed with error: ' . $response->getSession()->get('error'));
        }

        $response->assertRedirect(route('admin.units.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('units', [
            'unit_number' => $unitData['unit_number'],
            'name' => $unitData['name'],
        ]);

        // Check kepala unit person created
        $this->assertDatabaseHas('persons', [
            'nik' => $unitData['kepala_nik'],
            'full_name' => $unitData['kepala_nama'],
        ]);
    }

    /** @test */
    public function store_unit_requires_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('admin.units.store'), []);

        $response->assertSessionHasErrors([
            'unit_number',
            'name',
            'tipe_lokasi',
            'status_bangunan',
            'waktu_kegiatan',
            'village_id',
            'address',
            'rt',
            'rw',
            'kepala_nama',
            'kepala_nik',
        ]);
    }

    /** @test */
    public function unit_number_must_be_unique()
    {
        // Create existing unit
        $existingUnit = Unit::create([
            'unit_number' => 'UNIT-00001',
            'name' => 'Existing Unit',
            'region_id' => $this->region->id,
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::WAQAF->value,
            'waktu_kegiatan' => WaktuKegiatan::SIANG->value,
        ]);

        $unitData = $this->getValidUnitData();
        $unitData['unit_number'] = 'UNIT-00001'; // Same as existing

        $response = $this->actingAs($this->user)
            ->post(route('admin.units.store'), $unitData);

        $response->assertSessionHasErrors('unit_number');
    }

    /** @test */
    public function authenticated_user_can_view_unit_details()
    {
        $unit = $this->createUnit();

        $response = $this->actingAs($this->user)
            ->get(route('admin.units.show', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('admin.units.show');
        $response->assertViewHas('unit');
    }

    /** @test */
    public function authenticated_user_can_access_edit_unit_page()
    {
        $unit = $this->createUnit();

        $response = $this->actingAs($this->user)
            ->get(route('admin.units.edit', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('admin.units.edit');
        $response->assertViewHas('unit');
        $response->assertViewHas('provinces');
    }

    /** @test */
    public function authenticated_user_can_update_unit()
    {
        $unit = $this->createUnit();

        $updateData = $this->getValidUnitData();
        $updateData['name'] = 'Updated Unit Name';

        $response = $this->actingAs($this->user)
            ->put(route('admin.units.update', $unit), $updateData);

        $response->assertRedirect(route('admin.units.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('units', [
            'id' => $unit->id,
            'name' => 'Updated Unit Name',
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_unit()
    {
        $unit = $this->createUnit();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.units.destroy', $unit));

        $response->assertRedirect(route('admin.units.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('units', [
            'id' => $unit->id,
        ]);
    }

    /** @test */
    public function units_index_can_filter_by_tipe_lokasi()
    {
        $unitMasjid = $this->createUnit(['tipe_lokasi' => TipeLokasi::MASJID->value]);
        $unitMushallah = $this->createUnit(['tipe_lokasi' => TipeLokasi::MUSHALLAH->value]);

        $response = $this->actingAs($this->user)
            ->get(route('admin.units.index', ['tipe_lokasi' => TipeLokasi::MASJID->value]));

        $response->assertStatus(200);
        $response->assertSee($unitMasjid->name);
    }

    /** @test */
    public function units_index_can_search_by_name()
    {
        $unitA = $this->createUnit(['name' => 'TPA Al-Hidayah']);
        $unitB = $this->createUnit(['name' => 'TPQ Baitul Quran']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.units.index', ['search' => 'Al-Hidayah']));

        $response->assertStatus(200);
        $response->assertSee('TPA Al-Hidayah');
    }

    /**
     * Helper method to get valid unit data for testing
     */
    protected function getValidUnitData(): array
    {
        return [
            'unit_number' => 'UNIT-' . rand(10000, 99999),
            'name' => 'TPA Test Unit',
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::WAQAF->value,
            'mosque_name' => 'Masjid Test',
            'founder' => 'Yayasan Test',
            'formed_at' => '2020-01-01',
            'joined_year' => 2021,
            'waktu_kegiatan' => WaktuKegiatan::SIANG->value,
            'email' => 'unit@test.com',

            // Alamat
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test No. 123',
            'rt' => '001',
            'rw' => '002',

            // Keadaan Santri
            'jumlah_tka_4_7' => 10,
            'jumlah_tpa_7_12' => 20,
            'jumlah_tqa_wisuda' => 5,

            // Keadaan Guru
            'jumlah_guru_laki_laki' => 3,
            'jumlah_guru_perempuan' => 5,

            // Kepala Unit
            'kepala_nama' => 'Budi Santoso',
            'kepala_nik' => '1234567890123456',
            'kepala_tempat_lahir' => 'Jakarta',
            'kepala_tanggal_lahir' => '1985-05-15',
            'kepala_gender' => Gender::LAKI_LAKI->value,
            'kepala_pendidikan' => PendidikanTerakhir::D4_S1->value,
            'kepala_pekerjaan' => PekerjaanWali::WIRASWASTA->value,
            'kepala_phone' => '081234567890',

            // Admin (optional)
            'admin_nama' => '',
            'admin_phone' => '',
            'admin_email' => '',
        ];
    }

    /**
     * Helper method to create a unit for testing
     */
    protected function createUnit(array $overrides = []): Unit
    {
        return Unit::create(array_merge([
            'unit_number' => 'UNIT-' . rand(10000, 99999),
            'name' => 'Test Unit ' . rand(1, 100),
            'region_id' => $this->region->id,
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::WAQAF->value,
            'waktu_kegiatan' => WaktuKegiatan::SIANG->value,
        ], $overrides));
    }
}
