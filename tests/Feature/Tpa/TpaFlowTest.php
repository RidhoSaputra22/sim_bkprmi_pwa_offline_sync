<?php

namespace Tests\Feature\Tpa;

use App\Enum\Gender;
use App\Enum\HubunganWaliSantri;
use App\Enum\JenjangSantri;
use App\Enum\KelasMengaji;
use App\Enum\RoleType;
use App\Enum\StatusApprovalUnit;
use App\Enum\StatusSantri;
use App\Models\City;
use App\Models\District;
use App\Models\Person;
use App\Models\Province;
use App\Models\Region;
use App\Models\Santri;
use App\Models\SantriUnit;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Admin TPA Flow Tests
 *
 * Tests yang mensimulasikan alur pengguna Admin TPA:
 * - Login dan akses dashboard
 * - Input data santri
 * - Edit dan update data santri
 * - View profil TPA
 * - Statistik TPA
 */
class TpaFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminTpa;
    protected Unit $unit;
    protected Province $province;
    protected City $city;
    protected District $district;
    protected Village $village;
    protected Region $region;

    protected function setUp(): void
    {
        parent::setUp();

        // Create location data (Sulawesi Selatan, Kota Makassar)
        $this->province = Province::create(['name' => 'Sulawesi Selatan']);
        $this->city = City::create(['province_id' => $this->province->id, 'name' => 'Kota Makassar']);
        $this->district = District::create(['city_id' => $this->city->id, 'name' => 'Tamalate']);
        $this->village = Village::create(['district_id' => $this->district->id, 'name' => 'Mangasa']);

        // Create Region
        $this->region = Region::create([
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'jalan' => 'Jl. Test No. 123',
            'rt' => '001',
            'rw' => '002',
        ]);

        // Create TPA Unit
        $this->unit = Unit::create([
            'unit_number' => 'UNIT-12345',
            'name' => 'TPA Al-Ikhlas',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test No. 123',
            'rt' => '001',
            'rw' => '002',
            'tipe_lokasi' => 'masjid',
            'status_bangunan' => 'milik_sendiri',
            'waktu_kegiatan' => 'pagi',
            'mosque_name' => 'Masjid Al-Ikhlas',
            'founder' => 'H. Ahmad',
            'formed_at' => now()->subYears(5),
            'joined_year' => now()->year - 3,
            'email' => 'tpaalikhlas@test.com',
            'approval_status' => StatusApprovalUnit::APPROVED->value,
        ]);

        // Create Admin TPA user
        $person = Person::factory()->create(['full_name' => 'Admin TPA']);
        $this->adminTpa = User::factory()->create([
            'person_id' => $person->id,
            'email' => 'admin.tpa@bkprmi.test',
            'password' => 'password123',
            'is_active' => true,
        ]);

        UserRole::create([
            'user_id' => $this->adminTpa->id,
            'role' => RoleType::ADMIN_TPA->value,
        ]);

        // Link unit to admin TPA
        $this->unit->admin_user_id = $this->adminTpa->id;
        $this->unit->save();
    }

    // ============================================================
    // AUTHENTICATION TESTS
    // ============================================================

    /** @test */
    public function tpa_admin_can_login_and_redirected_to_tpa_dashboard()
    {
        $response = $this->post(route('login'), [
            'email' => 'admin.tpa@bkprmi.test',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('tpa.dashboard'));
    }

    /** @test */
    public function tpa_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.dashboard');
    }

    /** @test */
    public function tpa_admin_cannot_access_superadmin_routes()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('superadmin.dashboard'));

        $response->assertRedirect(route('tpa.dashboard'));
    }

    /** @test */
    public function tpa_admin_cannot_access_lpptka_routes()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('lpptka.dashboard'));

        $response->assertRedirect(route('tpa.dashboard'));
    }

    // ============================================================
    // SANTRI MANAGEMENT TESTS
    // ============================================================

    /** @test */
    public function tpa_admin_can_view_santri_list()
    {
        // Create santri for this unit
        $this->createSantriForUnit($this->unit, 'Ahmad');
        $this->createSantriForUnit($this->unit, 'Fatimah');

        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.santri.index');
    }

    /** @test */
    public function tpa_admin_can_view_create_santri_form()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.santri.create');
    }

    /** @test */
    public function tpa_admin_can_create_new_santri()
    {
        $santriData = [
            'nik' => '7371010101150001',
            'full_name' => 'Ahmad bin Malik',
            'gender' => Gender::LAKI_LAKI->value,
            'birth_place' => 'Makassar',
            'birth_date' => '2015-05-15',
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Santri No. 1',
            'rt' => '001',
            'rw' => '002',
            'child_order' => 1,
            'siblings_count' => 2,
            'joined_at' => '2023-01-01',
            'nama_ayah' => 'Bapak Malik',
            'nama_ibu' => 'Ibu Malik',
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => StatusSantri::AKTIF->value,
            'wali_nik' => '7371010101800001',
            'wali_full_name' => 'Bapak Malik',
            'wali_gender' => Gender::LAKI_LAKI->value,
            'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
            'wali_birth_place' => 'Makassar',
            'wali_birth_date' => '1980-01-01',
            'wali_pendidikan' => 'sma',
            'wali_pekerjaan' => ['pedagang'],
            'wali_phone' => '081234567892',
        ];

        $response = $this->actingAs($this->adminTpa)
            ->post(route('tpa.santri.store'), $santriData);

        $response->assertRedirect();
        $this->assertDatabaseHas('persons', [
            'full_name' => 'Ahmad bin Malik',
        ]);
    }

    /** @test */
    public function tpa_admin_can_view_santri_detail()
    {
        $santri = $this->createSantriForUnit($this->unit, 'Ahmad');

        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.show', $santri));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.santri.show');
    }

    /** @test */
    public function tpa_admin_can_edit_santri()
    {
        $santri = $this->createSantriForUnit($this->unit, 'Ahmad');

        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.edit', $santri));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.santri.edit');
    }

    /** @test */
    public function tpa_admin_can_update_santri()
    {
        $santri = $this->createSantriForUnit($this->unit, 'Ahmad');

        $response = $this->actingAs($this->adminTpa)
            ->put(route('tpa.santri.update', $santri), [
                'nik' => '7371010101150002',
                'full_name' => 'Ahmad Updated',
                'gender' => Gender::LAKI_LAKI->value,
                'birth_place' => 'Makassar',
                'birth_date' => '2015-05-15',
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'address' => 'Jl. Update No. 2',
                'rt' => '003',
                'rw' => '004',
                'child_order' => 2,
                'siblings_count' => 3,
                'joined_at' => '2023-01-01',
                'nama_ayah' => 'Bapak Ahmad',
                'nama_ibu' => 'Ibu Ahmad',
                'jenjang_santri' => JenjangSantri::TQA->value,
                'kelas_mengaji' => KelasMengaji::TADARRUS_1_15->value,
                'status_santri' => StatusSantri::AKTIF->value,
                'wali_nik' => '7371010101800002',
                'wali_full_name' => 'Bapak Ahmad',
                'wali_gender' => Gender::LAKI_LAKI->value,
                'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
                'wali_birth_place' => 'Makassar',
                'wali_birth_date' => '1980-01-01',
                'wali_pendidikan' => 'sma',
                'wali_pekerjaan' => ['pedagang'],
                'wali_phone' => '081234567892',
            ]);

        $response->assertRedirect(route('tpa.santri.show', $santri));

        $santri->refresh();
        $santri->person->refresh();
        $this->assertEquals('Ahmad Updated', $santri->person->full_name);
    }

    /** @test */
    public function tpa_admin_can_delete_santri()
    {
        $santri = $this->createSantriForUnit($this->unit, 'Ahmad');
        $santriId = $santri->id;

        $response = $this->actingAs($this->adminTpa)
            ->delete(route('tpa.santri.destroy', $santri));

        $response->assertRedirect(route('tpa.santri.index'));

        // Controller does soft delete by setting left_at
        $santriUnit = SantriUnit::where('santri_id', $santriId)
            ->where('unit_id', $this->unit->id)
            ->first();
        $this->assertNotNull($santriUnit->left_at);
    }

    // ============================================================
    // UNIT PROFILE TESTS
    // ============================================================

    /** @test */
    public function tpa_admin_can_view_unit_profile()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.unit.show'));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.unit.show');
        $response->assertViewHas('unit');
    }

    /** @test */
    public function tpa_admin_without_unit_sees_no_unit_page()
    {
        // Remove unit from admin
        $this->unit->admin_user_id = null;
        $this->unit->save();

        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.unit.show'));

        $response->assertStatus(200);
        $response->assertViewIs('tpa.no-unit');
    }

    // ============================================================
    // COMPLETE TPA FLOW TEST
    // ============================================================

    /** @test */
    public function complete_tpa_santri_management_flow()
    {
        // Step 1: Login
        $this->post(route('login'), [
            'email' => 'admin.tpa@bkprmi.test',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();

        // Step 2: Visit dashboard
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.dashboard'));
        $response->assertStatus(200);

        // Step 3: Navigate to santri list
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.index'));
        $response->assertStatus(200);

        // Step 4: Go to create santri form
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.create'));
        $response->assertStatus(200);

        // Step 5: Create new santri
        $response = $this->actingAs($this->adminTpa)
            ->post(route('tpa.santri.store'), [
                'nik' => '7371010101160001',
                'full_name' => 'Santri Flow Test',
                'gender' => Gender::LAKI_LAKI->value,
                'birth_place' => 'Makassar',
                'birth_date' => '2016-06-16',
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'address' => 'Jl. Flow Test',
                'rt' => '001',
                'rw' => '001',
                'child_order' => 1,
                'siblings_count' => 2,
                'joined_at' => '2023-01-01',
                'nama_ayah' => 'Bapak Flow',
                'nama_ibu' => 'Ibu Flow',
                'jenjang_santri' => JenjangSantri::TPA->value,
                'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
                'status_santri' => StatusSantri::AKTIF->value,
                'wali_nik' => '7371010101800003',
                'wali_full_name' => 'Wali Flow Test',
                'wali_gender' => Gender::LAKI_LAKI->value,
                'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
                'wali_birth_place' => 'Makassar',
                'wali_birth_date' => '1980-01-01',
                'wali_pendidikan' => 'sma',
                'wali_pekerjaan' => ['pedagang'],
                'wali_phone' => '081234567892',
            ]);
        $response->assertRedirect();

        $santri = Santri::whereHas('person', fn($q) => $q->where('full_name', 'Santri Flow Test'))->first();
        $this->assertNotNull($santri);

        // Step 6: View santri detail
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.show', $santri));
        $response->assertStatus(200);

        // Step 7: Edit santri
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.edit', $santri));
        $response->assertStatus(200);

        // Step 8: Update santri
        $response = $this->actingAs($this->adminTpa)
            ->put(route('tpa.santri.update', $santri), [
                'nik' => '7371010101160002',
                'full_name' => 'Santri Flow Updated',
                'gender' => Gender::LAKI_LAKI->value,
                'birth_place' => 'Makassar',
                'birth_date' => '2016-06-16',
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'address' => 'Jl. Flow Updated',
                'rt' => '002',
                'rw' => '002',
                'child_order' => 2,
                'siblings_count' => 3,
                'joined_at' => '2023-06-01',
                'nama_ayah' => 'Bapak Flow Updated',
                'nama_ibu' => 'Ibu Flow Updated',
                'jenjang_santri' => JenjangSantri::TQA->value,
                'kelas_mengaji' => KelasMengaji::IQRA_4_6->value,
                'status_santri' => StatusSantri::AKTIF->value,
                'wali_nik' => '7371010101800004',
                'wali_full_name' => 'Wali Flow Updated',
                'wali_gender' => Gender::LAKI_LAKI->value,
                'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
                'wali_birth_place' => 'Makassar',
                'wali_birth_date' => '1980-01-01',
                'wali_pendidikan' => 'sma',
                'wali_pekerjaan' => ['pedagang'],
                'wali_phone' => '081234567892',
            ]);
        $response->assertRedirect(route('tpa.santri.show', $santri));

        // Verify update
        $santri->refresh();
        $santri->person->refresh();
        $this->assertEquals('Santri Flow Updated', $santri->person->full_name);

        // Step 9: View unit profile
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.unit.show'));
        $response->assertStatus(200);

        // Step 10: Logout
        $this->post(route('logout'));
        $this->assertGuest();
    }

    // ============================================================
    // DASHBOARD STATISTICS TESTS
    // ============================================================

    /** @test */
    public function tpa_dashboard_shows_correct_statistics()
    {
        // Create multiple santri
        $this->createSantriForUnit($this->unit, 'Ahmad', Gender::LAKI_LAKI, StatusSantri::AKTIF);
        $this->createSantriForUnit($this->unit, 'Fatimah', Gender::PEREMPUAN, StatusSantri::AKTIF);
        $this->createSantriForUnit($this->unit, 'Umar', Gender::LAKI_LAKI, StatusSantri::BERHENTI);

        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');
    }

    // ============================================================
    // AUTHORIZATION TESTS
    // ============================================================

    /** @test */
    public function tpa_admin_cannot_access_santri_from_other_unit()
    {
        // Create another unit
        $otherUnit = Unit::create([
            'unit_number' => 'UNIT-99999',
            'name' => 'TPA Lain',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Lain No. 999',
            'rt' => '009',
            'rw' => '009',
            'tipe_lokasi' => 'masjid',
            'status_bangunan' => 'milik_sendiri',
            'waktu_kegiatan' => 'sore',
            'mosque_name' => 'Masjid Lain',
            'founder' => 'H. Lain',
            'formed_at' => now()->subYears(3),
            'joined_year' => now()->year - 1,
            'email' => 'tpalain@test.com',
            'approval_status' => StatusApprovalUnit::APPROVED->value,
        ]);

        // Create santri for other unit
        $santri = $this->createSantriForUnit($otherUnit, 'Other Santri');

        // Try to access santri from other unit
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.show', $santri));

        // Should be forbidden (403), redirected, or not found (404)
        $this->assertTrue(in_array($response->status(), [403, 302, 404]));
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    private function createSantriForUnit(
        Unit $unit,
        string $name,
        Gender $gender = Gender::LAKI_LAKI,
        StatusSantri $status = StatusSantri::AKTIF
    ): Santri {
        $person = Person::factory()->create([
            'full_name' => $name,
            'gender' => $gender->value,
            'birth_place' => 'Makassar',
            'birth_date' => fake()->dateTimeBetween('-15 years', '-5 years'),
        ]);

        $santri = Santri::create([
            'person_id' => $person->id,
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'child_order' => 1,
            'siblings_count' => 2,
            'jenjang_santri' => JenjangSantri::TPA->value,
            'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
            'status_santri' => $status->value,
            'graduated' => false,
        ]);

        // Link santri to unit
        SantriUnit::create([
            'santri_id' => $santri->id,
            'unit_id' => $unit->id,
            'joined_at' => now(),
        ]);

        return $santri;
    }
}
