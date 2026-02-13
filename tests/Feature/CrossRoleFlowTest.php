<?php

namespace Tests\Feature;

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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Cross-Role Integration Flow Tests
 *
 * Tests yang mensimulasikan alur lengkap dari TPA diinput
 * hingga Admin TPA dapat menginput data santri:
 *
 * 1. Admin LPPTKA membuat profil TPA
 * 2. Admin LPPTKA upload sertifikat
 * 3. SuperAdmin approve TPA
 * 4. Admin LPPTKA membuat akun Admin TPA
 * 5. Admin TPA login dan menginput data santri
 */
class CrossRoleFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $adminLpptka;
    protected Province $province;
    protected City $city;
    protected District $district;
    protected Village $village;
    protected Region $region;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        // Create location data
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

        // Create SuperAdmin
        $superAdminPerson = Person::factory()->create(['full_name' => 'Super Admin']);
        $this->superAdmin = User::factory()->create([
            'person_id' => $superAdminPerson->id,
            'email' => 'superadmin@bkprmi.test',
            'password' => 'password123',
            'is_active' => true,
        ]);
        UserRole::create([
            'user_id' => $this->superAdmin->id,
            'role' => RoleType::SUPERADMIN->value,
        ]);

        // Create Admin LPPTKA
        $lpptkaAdminPerson = Person::factory()->create(['full_name' => 'Admin LPPTKA']);
        $this->adminLpptka = User::factory()->create([
            'person_id' => $lpptkaAdminPerson->id,
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'password123',
            'is_active' => true,
        ]);
        UserRole::create([
            'user_id' => $this->adminLpptka->id,
            'role' => RoleType::ADMIN_LPPTKA->value,
        ]);
    }

    /** @test */
    public function complete_tpa_onboarding_flow_from_creation_to_santri_input()
    {
        // ============================================================
        // PHASE 1: Admin LPPTKA creates TPA profile
        // ============================================================

        // Step 1.1: Admin LPPTKA login
        $response = $this->post(route('login'), [
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('lpptka.dashboard'));

        // Step 1.2: Create new TPA unit
        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.store'), [
                'unit_number' => 'UNIT-INT-' . time(),
                'name' => 'TPA Integration Test',
                'province_id' => $this->province->id,
                'city_id' => $this->city->id,
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'jalan' => 'Jl. Integration No. 123',
                'rt' => '001',
                'rw' => '002',
                'tipe_lokasi' => 'masjid',
                'status_bangunan' => 'milik_sendiri',
                'waktu_kegiatan' => 'pagi',
                'mosque_name' => 'Masjid Integration',
                'founder' => 'H. Integration',
                'formed_at' => '2020-01-01',
                'joined_year' => 2021,
                'email' => 'integration@test.com',
                'phone' => '081234567890',
                'jumlah_tka' => 15,
                'jumlah_tpa' => 25,
                'jumlah_tqa' => 10,
                'guru_laki' => 3,
                'guru_perempuan' => 4,
                'head_nik' => '7371010101800001',
                'head_name' => 'Bapak Integration',
                'head_birth_place' => 'Makassar',
                'head_birth_date' => '1980-01-01',
                'head_gender' => 'laki-laki',
                'head_education' => 'sma',
                'head_job' => 'pedagang',
                'head_phone' => '081234567890',
                'admin_name' => 'Admin Integration',
                'admin_phone' => '081234567891',
                'admin_email' => 'admin.integration@test.com',
            ]);
        $response->assertRedirect();

        $unit = Unit::where('name', 'TPA Integration Test')->first();
        $this->assertNotNull($unit);
        $this->assertEquals(StatusApprovalUnit::PENDING, $unit->approval_status);

        // Step 1.3: Upload certificate
        $certificate = UploadedFile::fake()->create('certificate.pdf', 500, 'application/pdf');
        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.upload-certificate', $unit), [
                'certificate' => $certificate,
            ]);
        $response->assertRedirect();

        $unit->refresh();
        $this->assertNotNull($unit->certificate_path);

        // Step 1.4: Admin LPPTKA logout
        $this->post(route('logout'));
        $this->assertGuest();

        // ============================================================
        // PHASE 2: SuperAdmin approves TPA
        // ============================================================

        // Step 2.1: SuperAdmin login
        $response = $this->post(route('login'), [
            'email' => 'superadmin@bkprmi.test',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('superadmin.dashboard'));

        // Step 2.2: View pending approvals
        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.units.approval.index'));
        $response->assertStatus(200);

        // Step 2.3: View unit detail
        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.units.approval.show', $unit));
        $response->assertStatus(200);

        // Step 2.4: Approve unit
        $response = $this->actingAs($this->superAdmin)
            ->post(route('superadmin.units.approval.approve', $unit), [
                'notes' => 'Approved after verification',
            ]);
        $response->assertRedirect(route('superadmin.units.approval.index'));

        $unit->refresh();
        $this->assertEquals(StatusApprovalUnit::APPROVED, $unit->approval_status);
        $this->assertEquals($this->superAdmin->id, $unit->approved_by);

        // Step 2.5: SuperAdmin logout
        $this->post(route('logout'));
        $this->assertGuest();

        // ============================================================
        // PHASE 3: Admin LPPTKA creates TPA Admin account
        // ============================================================

        // Step 3.1: Admin LPPTKA login again
        $response = $this->post(route('login'), [
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();

        // Step 3.2: Create TPA Admin account
        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.tpa-accounts.store', $unit), [
                'full_name' => 'Admin TPA Integration',
                'nik' => '7371010101900001',
                'email' => 'admin.tpa.integration@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'phone' => '081234567890',
                'gender' => Gender::LAKI_LAKI->value,
                'birth_place' => 'Makassar',
                'birth_date' => '1990-01-01',
            ]);
        $response->assertRedirect(route('lpptka.tpa-accounts.success', $unit));

        // Verify TPA admin was created
        $adminTpa = User::where('email', 'admin.tpa.integration@test.com')->first();
        $this->assertNotNull($adminTpa);
        $this->assertTrue($adminTpa->hasRole(RoleType::ADMIN_TPA));

        // Verify unit linked to admin
        $unit->refresh();
        $this->assertEquals($adminTpa->id, $unit->admin_user_id);

        // Step 3.3: Admin LPPTKA logout
        $this->post(route('logout'));
        $this->assertGuest();

        // ============================================================
        // PHASE 4: Admin TPA inputs santri data
        // ============================================================

        // Step 4.1: Admin TPA login
        $response = $this->post(route('login'), [
            'email' => 'admin.tpa.integration@test.com',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('tpa.dashboard'));

        // Step 4.2: View dashboard
        $response = $this->actingAs($adminTpa)
            ->get(route('tpa.dashboard'));
        $response->assertStatus(200);

        // Step 4.3: Create santri
        $response = $this->actingAs($adminTpa)
            ->post(route('tpa.santri.store'), [
                'nik' => '7371010101150001',
                'full_name' => 'Santri Integration',
                'gender' => Gender::LAKI_LAKI->value,
                'birth_place' => 'Makassar',
                'birth_date' => '2015-06-15',
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'address' => 'Jl. Santri Integration',
                'rt' => '001',
                'rw' => '001',
                'child_order' => 1,
                'siblings_count' => 2,
                'joined_at' => '2023-01-01',
                'nama_ayah' => 'Bapak Integration',
                'nama_ibu' => 'Ibu Integration',
                'jenjang_santri' => JenjangSantri::TPA->value,
                'kelas_mengaji' => KelasMengaji::IQRA_1_3->value,
                'status_santri' => StatusSantri::AKTIF->value,
                'wali_nik' => '7371010101800002',
                'wali_full_name' => 'Bapak Wali Integration',
                'wali_gender' => Gender::LAKI_LAKI->value,
                'wali_hubungan' => HubunganWaliSantri::AYAH_KANDUNG->value,
                'wali_birth_place' => 'Makassar',
                'wali_birth_date' => '1980-01-01',
                'wali_pendidikan' => 'sma',
                'wali_pekerjaan' => ['pedagang'],
                'wali_phone' => '081234567892',
            ]);
        $response->assertRedirect();

        // Verify santri was created
        $this->assertDatabaseHas('persons', [
            'full_name' => 'Santri Integration',
        ]);

        $santri = Santri::whereHas('person', fn($q) => $q->where('full_name', 'Santri Integration'))->first();
        $this->assertNotNull($santri);

        // Step 4.4: View santri detail
        $response = $this->actingAs($adminTpa)
            ->get(route('tpa.santri.show', $santri));
        $response->assertStatus(200);

        // Step 4.5: View unit profile
        $response = $this->actingAs($adminTpa)
            ->get(route('tpa.unit.show'));
        $response->assertStatus(200);

        // Step 4.6: Admin TPA logout
        $this->post(route('logout'));
        $this->assertGuest();

        // ============================================================
        // VERIFICATION: All data is correctly linked
        // ============================================================

        // Reload all data
        $unit->refresh();
        $adminTpa->refresh();

        // Verify unit has admin
        $this->assertEquals($adminTpa->id, $unit->admin_user_id);

        // Verify admin TPA can access their unit
        $this->assertEquals($unit->id, $adminTpa->managedUnit->id);
    }

    /** @test */
    public function rejected_tpa_cannot_have_admin_account_created()
    {
        // Create a rejected TPA
        $unit = Unit::create([
            'unit_number' => 'UNIT-99999',
            'name' => 'TPA Rejected',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Rejected',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => 'masjid',
            'status_bangunan' => 'milik_sendiri',
            'waktu_kegiatan' => 'pagi',
            'mosque_name' => 'Masjid Rejected',
            'founder' => 'H. Rejected',
            'formed_at' => now()->subYears(3),
            'joined_year' => now()->year - 2,
            'email' => 'rejected@test.com',
            'approval_status' => StatusApprovalUnit::REJECTED->value,
        ]);

        // Admin LPPTKA tries to create account for rejected TPA
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.create', $unit));

        // Should be redirected or show error
        $response->assertRedirect();
    }

    /** @test */
    public function pending_tpa_cannot_have_admin_account_created()
    {
        // Create a pending TPA
        $unit = Unit::create([
            'unit_number' => 'UNIT-88888',
            'name' => 'TPA Pending',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Pending',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => 'masjid',
            'status_bangunan' => 'milik_sendiri',
            'waktu_kegiatan' => 'pagi',
            'mosque_name' => 'Masjid Pending',
            'founder' => 'H. Pending',
            'formed_at' => now()->subYears(3),
            'joined_year' => now()->year - 2,
            'email' => 'pending@test.com',
            'approval_status' => StatusApprovalUnit::PENDING->value,
        ]);

        // Admin LPPTKA tries to create account for pending TPA
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.create', $unit));

        // Should be redirected or show error
        $response->assertRedirect();
    }

    /** @test */
    public function superadmin_rejection_flow_with_resubmission()
    {
        // ============================================================
        // PHASE 1: Admin LPPTKA creates TPA and uploads certificate
        // ============================================================

        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.store'), [
                'unit_number' => 'UNIT-RESUB-' . time(),
                'name' => 'TPA Resubmit Test',
                'province_id' => $this->province->id,
                'city_id' => $this->city->id,
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'jalan' => 'Jl. Resubmit No. 123',
                'rt' => '001',
                'rw' => '002',
                'tipe_lokasi' => 'masjid',
                'status_bangunan' => 'milik_sendiri',
                'waktu_kegiatan' => 'pagi',
                'mosque_name' => 'Masjid Resubmit',
                'founder' => 'H. Resubmit',
                'formed_at' => '2020-01-01',
                'joined_year' => 2021,
                'email' => 'resubmit@test.com',
                'phone' => '081234567890',
                'jumlah_tka' => 10,
                'jumlah_tpa' => 20,
                'jumlah_tqa' => 5,
                'guru_laki' => 3,
                'guru_perempuan' => 4,
                'head_nik' => '7371010101800003',
                'head_name' => 'Bapak Resubmit',
                'head_birth_place' => 'Makassar',
                'head_birth_date' => '1980-01-01',
                'head_gender' => 'laki-laki',
                'head_education' => 'sma',
                'head_job' => 'pedagang',
                'head_phone' => '081234567890',
                'admin_name' => 'Admin Resubmit',
                'admin_phone' => '081234567891',
                'admin_email' => 'admin.resubmit@test.com',
            ]);

        $unit = Unit::where('name', 'TPA Resubmit Test')->first();
        $this->assertNotNull($unit);

        // Upload certificate
        Storage::fake('public');
        $certificate = UploadedFile::fake()->create('certificate.pdf', 500, 'application/pdf');
        $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.upload-certificate', $unit), [
                'certificate' => $certificate,
            ]);

        // ============================================================
        // PHASE 2: SuperAdmin rejects TPA
        // ============================================================

        $response = $this->actingAs($this->superAdmin)
            ->post(route('superadmin.units.approval.reject', $unit), [
                'notes' => 'Sertifikat tidak valid, mohon upload ulang',
            ]);

        $unit->refresh();
        $this->assertEquals(StatusApprovalUnit::REJECTED, $unit->approval_status);

        // ============================================================
        // PHASE 3: Admin LPPTKA resubmits
        // ============================================================

        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.resubmit', $unit));
        $response->assertRedirect();

        $unit->refresh();
        $this->assertEquals(StatusApprovalUnit::PENDING, $unit->approval_status);

        // ============================================================
        // PHASE 4: SuperAdmin approves
        // ============================================================

        $response = $this->actingAs($this->superAdmin)
            ->post(route('superadmin.units.approval.approve', $unit), [
                'notes' => 'OK sekarang sudah benar',
            ]);

        $unit->refresh();
        $this->assertEquals(StatusApprovalUnit::APPROVED, $unit->approval_status);
    }
}
