<?php

namespace Tests\Feature\Admin;

use App\Enum\Gender;
use App\Enum\HubunganWaliSantri;
use App\Enum\JenjangSantri;
use App\Enum\KelasMengaji;
use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use App\Enum\StatusSantri;
use App\Models\City;
use App\Models\District;
use App\Models\Person;
use App\Models\Province;
use App\Models\Region;
use App\Models\Santri;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SantriControllerTest extends TestCase
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
    public function guest_cannot_access_santri_index()
    {
        $response = $this->get(route('admin.santri.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_santri_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.santri.index');
    }

    /** @test */
    public function authenticated_user_can_access_create_santri_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.santri.create');
        $response->assertViewHas('provinces');
    }

    /** @test */
    public function authenticated_user_can_store_new_santri()
    {
        $santriData = $this->getValidSantriData();

        $response = $this->actingAs($this->user)
            ->post(route('admin.santri.store'), $santriData);

        // Check if there's an error flash message
        if ($response->getSession()->has('error')) {
            $this->fail('Store failed with error: '.$response->getSession()->get('error'));
        }

        $response->assertRedirect(route('admin.santri.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('persons', [
            'nik' => $santriData['nik'],
            'full_name' => $santriData['full_name'],
        ]);
    }

    /** @test */
    public function store_santri_requires_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('admin.santri.store'), []);

        // Check if session has any errors
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function nik_must_be_16_digits()
    {
        $santriData = $this->getValidSantriData();
        $santriData['nik'] = '123456'; // Invalid: not 16 digits

        $response = $this->actingAs($this->user)
            ->post(route('admin.santri.store'), $santriData);

        $response->assertSessionHasErrors('nik');
    }

    /** @test */
    public function authenticated_user_can_view_santri_details()
    {
        $santri = $this->createSantri();

        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.show', $santri));

        $response->assertStatus(200);
        $response->assertViewIs('admin.santri.show');
        $response->assertViewHas('santri');
    }

    /** @test */
    public function authenticated_user_can_access_edit_santri_page()
    {
        $santri = $this->createSantri();

        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.edit', $santri));

        $response->assertStatus(200);
        $response->assertViewIs('admin.santri.edit');
        $response->assertViewHas('santri');
        $response->assertViewHas('provinces');
    }

    /** @test */
    public function authenticated_user_can_update_santri()
    {
        $santri = $this->createSantri();

        $updateData = $this->getValidSantriData();
        $updateData['full_name'] = 'Updated Santri Name';

        $response = $this->actingAs($this->user)
            ->put(route('admin.santri.update', $santri), $updateData);

        $response->assertRedirect(route('admin.santri.index'));
        $response->assertSessionHas('success');

        // Verify person name updated
        $this->assertDatabaseHas('persons', [
            'id' => $santri->person_id,
            'full_name' => 'Updated Santri Name',
        ]);
    }

    /** @test */
    public function authenticated_user_can_delete_santri()
    {
        $santri = $this->createSantri();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.santri.destroy', $santri));

        $response->assertRedirect(route('admin.santri.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('santris', [
            'id' => $santri->id,
        ]);
    }

    /** @test */
    public function santri_index_can_filter_by_jenjang()
    {
        $santriTKA = $this->createSantri(['jenjang_santri' => JenjangSantri::TKA->value]);
        $santriTPA = $this->createSantri(['jenjang_santri' => JenjangSantri::TPA->value]);

        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.index', ['jenjang' => JenjangSantri::TKA->value]));

        $response->assertStatus(200);
    }

    /** @test */
    public function santri_index_can_search_by_name()
    {
        $santri = $this->createSantri();

        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.index', ['search' => $santri->person->full_name]));

        $response->assertStatus(200);
    }

    /**
     * Helper method to get valid santri data for testing
     */
    protected function getValidSantriData(): array
    {
        return [
            // Data Diri Santri
            'full_name' => 'Test Santri',
            'nama_panggilan' => 'Santri',
            'nik' => '1234567890123456',
            'birth_place' => 'Jakarta',
            'birth_date' => '2015-05-15',
            'gender' => Gender::LAKI_LAKI->value,
            'child_order' => 1,
            'siblings_count' => 2,

            // Alamat
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test No. 123',
            'rt' => '001',
            'rw' => '002',

            // Orang Tua
            'nama_ayah' => 'Ahmad',
            'nama_ibu' => 'Siti',

            // Wali
            'wali_nik' => '6543210987654321',
            'wali_nama' => 'Ahmad Wali',
            'wali_tempat_lahir' => 'Jakarta',
            'wali_tanggal_lahir' => '1980-01-01',
            'wali_gender' => Gender::LAKI_LAKI->value,
            'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
            'wali_pendidikan' => PendidikanTerakhir::D4_S1->value,
            'wali_pekerjaan' => PekerjaanWali::ASN_PNS->value,
            'wali_phone' => '081234567890',

            // Program
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ];
    }

    /**
     * Helper method to create a santri for testing
     */
    protected function createSantri(array $overrides = []): Santri
    {
        $person = Person::create([
            'nik' => (string) rand(1000000000000000, 9999999999999999),
            'full_name' => 'Test Santri '.rand(1, 100),
            'birth_place' => 'Jakarta',
            'birth_date' => '2015-05-15',
            'gender' => Gender::LAKI_LAKI->value,
        ]);

        return Santri::create(array_merge([
            'person_id' => $person->id,
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'child_order' => 1,
            'siblings_count' => 2,
            'nama_ayah' => 'Ayah Test',
            'nama_ibu' => 'Ibu Test',
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ], $overrides));
    }
}
