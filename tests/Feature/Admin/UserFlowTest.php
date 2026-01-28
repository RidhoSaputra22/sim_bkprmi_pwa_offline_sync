<?php

namespace Tests\Feature\Admin;

use App\Enum\Gender;
use App\Enum\HubunganWaliSantri;
use App\Enum\JenjangSantri;
use App\Enum\KelasMengaji;
use App\Enum\PekerjaanWali;
use App\Enum\PendidikanTerakhir;
use App\Enum\StatusBangunan;
use App\Enum\StatusSantri;
use App\Enum\TipeLokasi;
use App\Enum\WaktuKegiatan;
use App\Models\Activity;
use App\Models\City;
use App\Models\District;
use App\Models\Person;
use App\Models\Province;
use App\Models\Region;
use App\Models\Santri;
use App\Models\Unit;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * User Flow Tests
 *
 * Tests yang mensimulasikan alur pengguna dari login hingga input data lengkap
 */
class UserFlowTest extends TestCase
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

        // Setup user untuk testing
        $this->user = User::factory()->create([
            'email' => 'admin@bkprmi.test',
            'password' => 'password123',
            'is_active' => true,
        ]);

        // Setup wilayah Indonesia
        $this->province = Province::create(['name' => 'Jawa Barat']);
        $this->city = City::create(['province_id' => $this->province->id, 'name' => 'Kota Bandung']);
        $this->district = District::create(['city_id' => $this->city->id, 'name' => 'Coblong']);
        $this->village = Village::create(['district_id' => $this->district->id, 'name' => 'Dago']);

        $this->region = Region::create([
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'jalan' => 'Jl. Ir. H. Juanda',
            'rt' => '001',
            'rw' => '002',
        ]);
    }

    // ============================================================
    // LOGIN FLOW TESTS
    // ============================================================

    /** @test */
    public function user_can_visit_login_page_and_see_login_form()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('email');
        $response->assertSee('password');
    }

    /** @test */
    public function user_can_login_with_valid_credentials_and_redirected_to_dashboard()
    {
        // Step 1: Visit login page
        $this->get(route('login'))->assertStatus(200);

        // Step 2: Submit login form
        $response = $this->post(route('login'), [
            'email' => 'admin@bkprmi.test',
            'password' => 'password123',
        ]);

        // Step 3: Should be authenticated and redirected to dashboard
        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));

        // Step 4: Visit dashboard should work
        $this->get(route('admin.dashboard'))->assertStatus(200);
    }

    /** @test */
    public function user_cannot_login_with_wrong_password()
    {
        $response = $this->post(route('login'), [
            'email' => 'admin@bkprmi.test',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    // ============================================================
    // SANTRI INPUT FLOW TESTS
    // ============================================================

    /** @test */
    public function user_can_navigate_to_santri_create_form_and_see_all_fields()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.create'));

        $response->assertStatus(200);

        // Check form sections are visible
        $response->assertSee('IDENTITAS SANTRI');
        $response->assertSee('ALAMAT');
        $response->assertSee('NAMA ORANG TUA');
    }

    /** @test */
    public function user_can_input_complete_santri_data_and_submit_form()
    {
        // Simulate user filling out complete santri registration form
        $santriData = [
            // Identitas Santri
            'nik' => '3273012345678901',
            'full_name' => 'Ahmad Fauzan',
            'birth_place' => 'Bandung',
            'birth_date' => '2015-06-15',
            'gender' => Gender::LAKI_LAKI->value,
            'child_order' => 2,
            'siblings_count' => 3,

            // Alamat
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Dipatiukur No. 35',
            'rt' => '005',
            'rw' => '010',

            // Orang Tua
            'nama_ayah' => 'Budi Santoso',
            'nama_ibu' => 'Siti Aminah',

            // Wali Santri
            'wali_nik' => '3273019876543210',
            'wali_nama' => 'Budi Santoso',
            'wali_tempat_lahir' => 'Jakarta',
            'wali_tanggal_lahir' => '1980-03-20',
            'wali_gender' => Gender::LAKI_LAKI->value,
            'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
            'wali_pendidikan' => PendidikanTerakhir::D4_S1->value,
            'wali_pekerjaan' => PekerjaanWali::ASN_PNS->value,
            'wali_phone' => '081234567890',

            // Status Santri
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('admin.santri.store'), $santriData);

        // Should redirect to index with success message
        $response->assertRedirect(route('admin.santri.index'));
        $response->assertSessionHas('success');

        // Verify data was saved correctly
        $this->assertDatabaseHas('persons', [
            'nik' => '3273012345678901',
            'full_name' => 'Ahmad Fauzan',
            'birth_place' => 'Bandung',
            'gender' => Gender::LAKI_LAKI->value,
        ]);

        $this->assertDatabaseHas('santris', [
            'nama_ayah' => 'Budi Santoso',
            'nama_ibu' => 'Siti Aminah',
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ]);
    }

    /** @test */
    public function user_sees_validation_errors_when_submitting_incomplete_santri_form()
    {
        // Submit empty form
        $response = $this->actingAs($this->user)
            ->post(route('admin.santri.store'), []);

        // Should return validation errors
        $response->assertSessionHasErrors([
            'nik',
            'full_name',
            'birth_place',
            'birth_date',
            'gender',
        ]);
    }

    /** @test */
    public function user_can_view_santri_list_after_creating_data()
    {
        // Create santri first
        $person = Person::create([
            'nik' => '3273012345678901',
            'full_name' => 'Ahmad Fauzan',
            'birth_place' => 'Bandung',
            'birth_date' => '2015-06-15',
            'gender' => Gender::LAKI_LAKI->value,
        ]);

        Santri::create([
            'person_id' => $person->id,
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'nama_ayah' => 'Budi Santoso',
            'nama_ibu' => 'Siti Aminah',
            'child_order' => 1,
            'siblings_count' => 2,
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ]);

        // Visit santri index
        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.index'));

        $response->assertStatus(200);
        $response->assertSee('Ahmad Fauzan');
    }

    /** @test */
    public function user_can_search_santri_by_name()
    {
        // Create multiple santri
        $this->createSantriWithName('Ahmad Fauzan');
        $this->createSantriWithName('Fatimah Zahra');
        $this->createSantriWithName('Muhammad Rizki');

        // Search for specific name
        $response = $this->actingAs($this->user)
            ->get(route('admin.santri.index', ['search' => 'Fatimah']));

        $response->assertStatus(200);
        $response->assertSee('Fatimah Zahra');
        $response->assertDontSee('Ahmad Fauzan');
        $response->assertDontSee('Muhammad Rizki');
    }

    /** @test */
    public function user_can_edit_existing_santri_data()
    {
        $person = Person::create([
            'nik' => '3273012345678901',
            'full_name' => 'Ahmad Fauzan',
            'birth_place' => 'Bandung',
            'birth_date' => '2015-06-15',
            'gender' => Gender::LAKI_LAKI->value,
        ]);

        $santri = Santri::create([
            'person_id' => $person->id,
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'nama_ayah' => 'Budi Santoso',
            'nama_ibu' => 'Siti Aminah',
            'child_order' => 1,
            'siblings_count' => 2,
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ]);

        // Visit edit page
        $editResponse = $this->actingAs($this->user)
            ->get(route('admin.santri.edit', $santri));

        $editResponse->assertStatus(200);
        $editResponse->assertSee('Ahmad Fauzan');

        // Update santri - upgrade kelas
        $updateResponse = $this->actingAs($this->user)
            ->put(route('admin.santri.update', $santri), [
                'nik' => '3273012345678901',
                'full_name' => 'Ahmad Fauzan',
                'birth_place' => 'Bandung',
                'birth_date' => '2015-06-15',
                'gender' => Gender::LAKI_LAKI->value,
                'child_order' => 1,
                'siblings_count' => 2,
                'province_id' => $this->province->id,
                'city_id' => $this->city->id,
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'address' => 'Jl. Test',
                'rt' => '001',
                'rw' => '001',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Aminah',
                'wali_nik' => '3273019876543210',
                'wali_nama' => 'Budi Santoso',
                'wali_tempat_lahir' => 'Jakarta',
                'wali_tanggal_lahir' => '1980-03-20',
                'wali_gender' => Gender::LAKI_LAKI->value,
                'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
                'wali_pendidikan' => PendidikanTerakhir::D4_S1->value,
                'wali_pekerjaan' => PekerjaanWali::ASN_PNS->value,
                'wali_phone' => '081234567890',
                'jenjang_santri' => JenjangSantri::TPA->value,
                'kelas_mengaji' => KelasMengaji::IQRA_4_6->value, // Upgraded
                'status_santri' => StatusSantri::AKTIF->value,
            ]);

        $updateResponse->assertRedirect(route('admin.santri.index'));

        // Verify update
        $this->assertDatabaseHas('santris', [
            'id' => $santri->id,
            'kelas_mengaji' => KelasMengaji::IQRA_4_6->value,
        ]);
    }

    // ============================================================
    // UNIT INPUT FLOW TESTS
    // ============================================================

    /** @test */
    public function user_can_navigate_to_unit_create_form()
    {
        $response = $this->actingAs($this->user)
            ->get(route('admin.units.create'));

        $response->assertStatus(200);
        $response->assertSee('IDENTITAS UNIT');
    }

    /** @test */
    public function user_can_input_complete_unit_data_and_submit_form()
    {
        $unitData = [
            // Identitas Unit
            'unit_number' => 'UNIT-001-2026',
            'name' => 'TPQ Al-Hikmah',
            'mosque_name' => 'Masjid Al-Hikmah',
            'founder' => 'Yayasan Al-Hikmah',
            'formed_at' => '2020-01-01',
            'joined_year' => 2021,
            'email' => 'tpq@alhikmah.test',

            // Alamat
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Masjid No. 10',
            'rt' => '003',
            'rw' => '007',
            'tipe_lokasi' => TipeLokasi::MASJID->value,

            // Fasilitas
            'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,

            // Waktu
            'waktu_kegiatan' => WaktuKegiatan::SORE->value,

            // Keadaan Santri
            'jumlah_tka_4_7' => 10,
            'jumlah_tpa_7_12' => 20,
            'jumlah_tqa_wisuda' => 5,

            // Keadaan Guru
            'jumlah_guru_laki_laki' => 3,
            'jumlah_guru_perempuan' => 5,

            // Kepala Unit
            'kepala_nama' => 'Ustadz Ahmad',
            'kepala_nik' => '3273019876543210',
            'kepala_tempat_lahir' => 'Bandung',
            'kepala_tanggal_lahir' => '1980-05-15',
            'kepala_gender' => Gender::LAKI_LAKI->value,
            'kepala_pendidikan' => PendidikanTerakhir::D4_S1->value,
            'kepala_pekerjaan' => PekerjaanWali::WIRASWASTA->value,
            'kepala_phone' => '081234567890',

            // Admin Unit (optional)
            'admin_nama' => '',
            'admin_phone' => '',
            'admin_email' => '',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('admin.units.store'), $unitData);

        // Debug to see where we're redirected
        $response->assertSessionHasNoErrors();

        // Check if there's an error flash message
        if ($response->getSession()->has('error')) {
            $this->fail('Store failed with error: '.$response->getSession()->get('error'));
        }

        $response->assertRedirect(route('admin.units.index'));
        $response->assertSessionHas('success');

        // Verify data was saved
        $this->assertDatabaseHas('units', [
            'unit_number' => 'UNIT-001-2026',
            'name' => 'TPQ Al-Hikmah',
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,
        ]);
    }

    /** @test */
    public function user_sees_error_when_creating_unit_with_duplicate_number()
    {
        // Create first unit
        Unit::create([
            'unit_number' => 'UNIT-001-2026',
            'name' => 'TPQ Al-Hikmah',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,
            'waktu_kegiatan' => WaktuKegiatan::SORE->value,
            'is_active' => true,
        ]);

        // Try to create with same unit_number
        $response = $this->actingAs($this->user)
            ->post(route('admin.units.store'), [
                'unit_number' => 'UNIT-001-2026', // Duplicate
                'name' => 'TPQ Lain',
                'province_id' => $this->province->id,
                'city_id' => $this->city->id,
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'address' => 'Jl. Lain',
                'rt' => '002',
                'rw' => '002',
                'tipe_lokasi' => TipeLokasi::MASJID->value,
                'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,
                'is_active' => true,
            ]);

        $response->assertSessionHasErrors('unit_number');
    }

    /** @test */
    public function user_can_filter_units_by_location_type()
    {
        // Create units with different location types
        Unit::create([
            'unit_number' => 'UNIT-001',
            'name' => 'TPQ Masjid',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Masjid',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,
            'waktu_kegiatan' => WaktuKegiatan::SORE->value,
            'is_active' => true,
        ]);

        Unit::create([
            'unit_number' => 'UNIT-002',
            'name' => 'TPQ Mushallah',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Mushallah',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => TipeLokasi::MUSHALLAH->value,
            'status_bangunan' => StatusBangunan::SEWA->value,
            'waktu_kegiatan' => WaktuKegiatan::SORE->value,
            'is_active' => true,
        ]);

        // Filter by masjid
        $response = $this->actingAs($this->user)
            ->get(route('admin.units.index', ['tipe_lokasi' => TipeLokasi::MASJID->value]));

        $response->assertStatus(200);
        $response->assertSee('TPQ Masjid');
        $response->assertDontSee('TPQ Mushallah');
    }

    // ============================================================
    // ACTIVITY INPUT FLOW TESTS
    // ============================================================

    /** @test */
    public function user_can_create_new_activity_for_unit()
    {
        // Create a unit first
        $unit = Unit::create([
            'unit_number' => 'UNIT-001',
            'name' => 'TPQ Al-Hikmah',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,
            'waktu_kegiatan' => WaktuKegiatan::SORE->value,
            'is_active' => true,
        ]);

        $activityData = [
            'unit_id' => $unit->id,
            'title' => 'Lomba Hafalan Quran',
            'description' => 'Lomba hafalan untuk santri TPA dan TPQ',
            'activity_date' => '2026-02-15',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('admin.activities.store'), $activityData);

        $response->assertRedirect(route('admin.activities.index'));

        $this->assertDatabaseHas('activities', [
            'title' => 'Lomba Hafalan Quran',
            'unit_id' => $unit->id,
        ]);
    }

    /** @test */
    public function user_can_view_activity_details()
    {
        $unit = Unit::create([
            'unit_number' => 'UNIT-001',
            'name' => 'TPQ Al-Hikmah',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,
            'waktu_kegiatan' => WaktuKegiatan::SORE->value,
            'is_active' => true,
        ]);

        $activity = Activity::create([
            'unit_id' => $unit->id,
            'title' => 'Wisuda Santri',
            'description' => 'Acara wisuda santri yang telah menyelesaikan program',
            'activity_date' => '2026-03-01',
            'created_by' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('admin.activities.show', $activity));

        $response->assertStatus(200);
        $response->assertSee('Wisuda Santri');
    }

    // ============================================================
    // COMPLETE USER JOURNEY TEST
    // ============================================================

    /** @test */
    public function complete_user_journey_login_create_unit_create_santri_create_activity()
    {
        // Step 1: Login
        $this->post(route('login'), [
            'email' => 'admin@bkprmi.test',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();

        // Step 2: Create Unit
        $unitResponse = $this->post(route('admin.units.store'), [
            'unit_number' => 'UNIT-JOURNEY-001',
            'name' => 'TPQ Perjalanan',
            'mosque_name' => 'Masjid Perjalanan',
            'founder' => 'Yayasan Perjalanan',
            'formed_at' => '2020-01-01',
            'joined_year' => 2021,
            'email' => 'tpq@perjalanan.test',
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Perjalanan',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => TipeLokasi::MASJID->value,
            'status_bangunan' => StatusBangunan::MILIK_SENDIRI->value,
            'waktu_kegiatan' => WaktuKegiatan::SORE->value,
            'jumlah_tka_4_7' => 10,
            'jumlah_tpa_7_12' => 15,
            'jumlah_tqa_wisuda' => 5,
            'jumlah_guru_laki_laki' => 2,
            'jumlah_guru_perempuan' => 3,
            'kepala_nama' => 'Kepala Unit Perjalanan',
            'kepala_nik' => '3273077777777777',
            'kepala_tempat_lahir' => 'Bandung',
            'kepala_tanggal_lahir' => '1975-03-15',
            'kepala_gender' => Gender::LAKI_LAKI->value,
            'kepala_pendidikan' => PendidikanTerakhir::D4_S1->value,
            'kepala_pekerjaan' => PekerjaanWali::WIRASWASTA->value,
            'kepala_phone' => '081777666555',
            'admin_nama' => '',
            'admin_phone' => '',
            'admin_email' => '',
        ]);

        // Debug if unit store fails
        if ($unitResponse->getSession()->has('error')) {
            $this->fail('Unit store failed: '.$unitResponse->getSession()->get('error'));
        }

        $unit = Unit::where('unit_number', 'UNIT-JOURNEY-001')->first();
        $this->assertNotNull($unit);

        // Step 3: Create Santri
        $this->post(route('admin.santri.store'), [
            'nik' => '3273099999999999',
            'full_name' => 'Santri Perjalanan',
            'birth_place' => 'Bandung',
            'birth_date' => '2016-01-01',
            'gender' => Gender::PEREMPUAN->value,
            'child_order' => 1,
            'siblings_count' => 1,
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Perjalanan',
            'rt' => '001',
            'rw' => '001',
            'nama_ayah' => 'Ayah Perjalanan',
            'nama_ibu' => 'Ibu Perjalanan',
            'wali_nik' => '3273088888888888',
            'wali_nama' => 'Wali Perjalanan',
            'wali_tempat_lahir' => 'Jakarta',
            'wali_tanggal_lahir' => '1985-05-05',
            'wali_gender' => Gender::PEREMPUAN->value,
            'wali_hubungan' => HubunganWaliSantri::IBU_KANDUNG->value,
            'wali_pendidikan' => PendidikanTerakhir::SMA->value,
            'wali_pekerjaan' => PekerjaanWali::IRT->value,
            'wali_phone' => '081999888777',
            'jenjang_santri' => JenjangSantri::TKA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ]);

        $santri = Santri::whereHas('person', fn ($q) => $q->where('full_name', 'Santri Perjalanan'))->first();
        $this->assertNotNull($santri);

        // Step 4: Create Activity
        $this->post(route('admin.activities.store'), [
            'unit_id' => $unit->id,
            'title' => 'Kegiatan Perjalanan',
            'description' => 'Kegiatan dalam journey test',
            'activity_date' => '2026-06-01',
        ]);

        $activity = Activity::where('title', 'Kegiatan Perjalanan')->first();
        $this->assertNotNull($activity);

        // Step 5: Verify all data exists
        $this->assertDatabaseCount('units', 1);
        $this->assertDatabaseCount('santris', 1);
        $this->assertDatabaseCount('activities', 1);

        // Step 6: Logout
        $this->post(route('logout'));
        $this->assertGuest();
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    protected function createSantriWithName(string $name): Santri
    {
        $person = Person::create([
            'nik' => (string) rand(1000000000000000, 9999999999999999),
            'full_name' => $name,
            'birth_place' => 'Test Place',
            'birth_date' => '2015-01-01',
            'gender' => Gender::LAKI_LAKI->value,
        ]);

        return Santri::create([
            'person_id' => $person->id,
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'nama_ayah' => 'Ayah '.$name,
            'nama_ibu' => 'Ibu '.$name,
            'child_order' => 1,
            'siblings_count' => 1,
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
        ]);
    }
}
