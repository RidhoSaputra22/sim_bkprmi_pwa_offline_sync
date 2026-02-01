<?php

namespace Tests\Feature\Lpptka;

use App\Enum\Gender;
use App\Enum\RoleType;
use App\Enum\StatusApprovalUnit;
use App\Models\City;
use App\Models\District;
use App\Models\Person;
use App\Models\Province;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Admin LPPTKA Flow Tests
 *
 * Tests yang mensimulasikan alur pengguna Admin LPPTKA:
 * - Login dan akses dashboard
 * - Input profil TPA (unit)
 * - Upload sertifikat TPA
 * - Submit TPA untuk approval
 * - Membuat akun Admin TPA setelah TPA diapprove
 */
class LpptkaFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminLpptka;
    protected Province $province;
    protected City $city;
    protected District $district;
    protected Village $village;
    protected Region $region;

    protected function setUp(): void
    {
        parent::setUp();

        // Create location data (restricted to Sulawesi Selatan, Kota Makassar)
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

        // Create Admin LPPTKA user
        $person = Person::factory()->create(['full_name' => 'Admin LPPTKA']);
        $this->adminLpptka = User::factory()->create([
            'person_id' => $person->id,
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'password123',
            'is_active' => true,
        ]);

        UserRole::create([
            'user_id' => $this->adminLpptka->id,
            'role' => RoleType::ADMIN_LPPTKA->value,
        ]);
    }

    // ============================================================
    // AUTHENTICATION TESTS
    // ============================================================

    /** @test */
    public function lpptka_admin_can_login_and_redirected_to_lpptka_dashboard()
    {
        $response = $this->post(route('login'), [
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('lpptka.dashboard'));
    }

    /** @test */
    public function lpptka_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.dashboard');
    }

    /** @test */
    public function lpptka_admin_cannot_access_superadmin_routes()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('superadmin.dashboard'));

        $response->assertRedirect(route('lpptka.dashboard'));
    }

    /** @test */
    public function lpptka_admin_cannot_access_tpa_routes()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('tpa.dashboard'));

        $response->assertRedirect(route('lpptka.dashboard'));
    }

    // ============================================================
    // UNIT MANAGEMENT TESTS
    // ============================================================

    /** @test */
    public function lpptka_admin_can_view_unit_list()
    {
        $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);
        $this->createUnit('TPA Al-Hidayah', StatusApprovalUnit::APPROVED);

        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.units.index'));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.units.index');
    }

    /** @test */
    public function lpptka_admin_can_view_create_unit_form()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.units.create'));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.units.create');
    }

    /** @test */
    public function lpptka_admin_can_create_new_unit()
    {
        $unitData = [
            'unit_number' => 'UNIT-' . time(),
            'name' => 'TPA Baru Test',
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'district_id' => $this->district->id,
            'village_id' => $this->village->id,
            'jalan' => 'Jl. Baru No. 123',
            'rt' => '001',
            'rw' => '002',
            'tipe_lokasi' => 'masjid',
            'status_bangunan' => 'milik_sendiri',
            'waktu_kegiatan' => 'pagi',
            'mosque_name' => 'Masjid Al-Baru',
            'founder' => 'H. Ahmad',
            'formed_at' => '2020-01-01',
            'joined_year' => 2021,
            'email' => 'tpabaru@test.com',
            'head_name' => 'Bapak Ahmad',
            'head_birth_place' => 'Makassar',
            'head_birth_date' => '1980-01-01',
            'head_gender' => 'laki-laki',
            'head_phone' => '081234567890',
        ];

        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.store'), $unitData);

        $response->assertRedirect();
        $this->assertDatabaseHas('units', [
            'name' => 'TPA Baru Test',
            'email' => 'tpabaru@test.com',
            'approval_status' => StatusApprovalUnit::PENDING->value,
        ]);
    }

    /** @test */
    public function lpptka_admin_can_view_unit_detail()
    {
        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.units.show', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.units.show');
        $response->assertViewHas('unit');
    }

    /** @test */
    public function lpptka_admin_can_edit_unit()
    {
        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.units.edit', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.units.edit');
    }

    /** @test */
    public function lpptka_admin_can_update_unit()
    {
        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.units.update', $unit), [
                'unit_number' => $unit->unit_number,
                'name' => 'TPA Al-Ikhlas Updated',
                'province_id' => $this->province->id,
                'city_id' => $this->city->id,
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'jalan' => 'Jl. Update No. 456',
                'rt' => '003',
                'rw' => '004',
                'tipe_lokasi' => 'mushallah',
                'status_bangunan' => 'sewa',
                'waktu_kegiatan' => 'sore',
                'mosque_name' => 'Mushallah Update',
                'founder' => 'H. Budi',
                'formed_at' => '2019-01-01',
                'joined_year' => 2020,
                'email' => 'updated@test.com',
                'head_name' => 'Bapak Ahmad Updated',
                'head_birth_place' => 'Makassar',
                'head_birth_date' => '1980-01-01',
                'head_gender' => 'laki-laki',
                'head_phone' => '081234567890',
            ]);

        $response->assertRedirect(route('lpptka.units.show', $unit));

        $unit->refresh();
        $this->assertEquals('TPA Al-Ikhlas Updated', $unit->name);
    }

    // ============================================================
    // CERTIFICATE UPLOAD TESTS
    // ============================================================

    /** @test */
    public function lpptka_admin_can_upload_certificate()
    {
        Storage::fake('public');

        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);
        $file = UploadedFile::fake()->create('certificate.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.upload-certificate', $unit), [
                'certificate' => $file,
            ]);

        $response->assertRedirect();

        $unit->refresh();
        $this->assertNotNull($unit->certificate_path);
    }

    // ============================================================
    // TPA ACCOUNT CREATION TESTS
    // ============================================================

    /** @test */
    public function lpptka_admin_can_view_tpa_accounts_list()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.tpa-accounts.index');
    }

    /** @test */
    public function lpptka_admin_can_view_create_tpa_account_form_for_approved_unit()
    {
        $unit = $this->createUnit('TPA Approved', StatusApprovalUnit::APPROVED);

        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.create', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.tpa-accounts.create');
    }

    /** @test */
    public function lpptka_admin_can_create_tpa_account_for_approved_unit()
    {
        $unit = $this->createUnit('TPA Approved', StatusApprovalUnit::APPROVED);

        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.tpa-accounts.store', $unit), [
                'full_name' => 'Admin TPA Test',
                'email' => 'admintpa@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'phone' => '081234567890',
                'gender' => Gender::LAKI_LAKI->value,
                'birth_place' => 'Makassar',
                'birth_date' => '1990-01-01',
            ]);

        $response->assertRedirect(route('lpptka.tpa-accounts.success', $unit));

        // Verify user was created
        $this->assertDatabaseHas('users', [
            'email' => 'admintpa@test.com',
        ]);

        // Verify role was assigned
        $newUser = User::where('email', 'admintpa@test.com')->first();
        $this->assertTrue($newUser->hasRole(RoleType::ADMIN_TPA));

        // Verify unit is linked to admin
        $unit->refresh();
        $this->assertEquals($newUser->id, $unit->admin_user_id);
    }

    /** @test */
    public function lpptka_admin_cannot_create_tpa_account_for_pending_unit()
    {
        $unit = $this->createUnit('TPA Pending', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.create', $unit));

        // Should be redirected or show error
        $response->assertRedirect();
    }

    // ============================================================
    // COMPLETE LPPTKA FLOW TEST
    // ============================================================

    /** @test */
    public function complete_lpptka_unit_creation_flow()
    {
        Storage::fake('public');

        // Step 1: Login
        $this->post(route('login'), [
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();

        // Step 2: Visit dashboard
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.dashboard'));
        $response->assertStatus(200);

        // Step 3: Navigate to unit list
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.units.index'));
        $response->assertStatus(200);

        // Step 4: Create new unit
        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.store'), [
                'unit_number' => 'UNIT-FLOW-' . time(),
                'name' => 'TPA Flow Test',
                'province_id' => $this->province->id,
                'city_id' => $this->city->id,
                'district_id' => $this->district->id,
                'village_id' => $this->village->id,
                'jalan' => 'Jl. Flow Test No. 123',
                'rt' => '001',
                'rw' => '002',
                'tipe_lokasi' => 'masjid',
                'status_bangunan' => 'milik_sendiri',
                'waktu_kegiatan' => 'pagi',
                'mosque_name' => 'Masjid Flow Test',
                'founder' => 'H. Flow',
                'formed_at' => '2020-01-01',
                'joined_year' => 2021,
                'email' => 'flowtest@test.com',
                'head_name' => 'Bapak Flow',
                'head_birth_place' => 'Makassar',
                'head_birth_date' => '1980-01-01',
                'head_gender' => 'laki-laki',
                'head_phone' => '081234567890',
            ]);
        $response->assertRedirect();

        $unit = Unit::where('name', 'TPA Flow Test')->first();
        $this->assertNotNull($unit);
        $this->assertEquals(StatusApprovalUnit::PENDING, $unit->approval_status);

        // Step 5: Upload certificate
        $file = UploadedFile::fake()->create('certificate.pdf', 500, 'application/pdf');
        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.units.upload-certificate', $unit), [
                'certificate' => $file,
            ]);
        $response->assertRedirect();

        // Step 6: View unit detail
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.units.show', $unit));
        $response->assertStatus(200);

        // Step 7: Logout
        $this->post(route('logout'));
        $this->assertGuest();
    }

    /** @test */
    public function complete_tpa_account_creation_flow()
    {
        // Create an approved unit
        $unit = $this->createUnit('TPA Approved Flow', StatusApprovalUnit::APPROVED);

        // Step 1: Login
        $this->post(route('login'), [
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'password123',
        ]);
        $this->assertAuthenticated();

        // Step 2: Navigate to TPA accounts list
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.index'));
        $response->assertStatus(200);

        // Step 3: Go to create account page
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.create', $unit));
        $response->assertStatus(200);

        // Step 4: Create TPA account
        $response = $this->actingAs($this->adminLpptka)
            ->post(route('lpptka.tpa-accounts.store', $unit), [
                'full_name' => 'Admin TPA Flow',
                'email' => 'admintpaflow@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'phone' => '081234567890',
                'gender' => Gender::LAKI_LAKI->value,
                'birth_place' => 'Makassar',
                'birth_date' => '1990-01-01',
            ]);
        $response->assertRedirect(route('lpptka.tpa-accounts.success', $unit));

        // Step 5: View success page
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.success', $unit));
        $response->assertStatus(200);

        // Verify admin user created with correct role
        $adminUser = User::where('email', 'admintpaflow@test.com')->first();
        $this->assertTrue($adminUser->hasRole(RoleType::ADMIN_TPA));

        // Verify unit linked to admin
        $unit->refresh();
        $this->assertEquals($adminUser->id, $unit->admin_user_id);

        // Step 6: Logout
        $this->post(route('logout'));
        $this->assertGuest();
    }

    // ============================================================
    // PROFILE TESTS
    // ============================================================

    /** @test */
    public function lpptka_admin_can_view_profile()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('lpptka.profile');
        $response->assertViewHas('user');
        $response->assertViewHas('stats');
        $response->assertSee('Profil Admin LPPTKA');
        $response->assertSee($this->adminLpptka->person->full_name);
        $response->assertSee($this->adminLpptka->email);
    }

    /** @test */
    public function lpptka_admin_can_update_profile()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.profile.update'), [
                'full_name' => 'Admin LPPTKA Updated',
                'email' => 'admin.lpptka.updated@bkprmi.test',
                'phone' => '081234567890',
            ]);

        $response->assertRedirect(route('lpptka.profile'));
        $response->assertSessionHas('success', 'Profil berhasil diperbarui');

        // Verify person updated
        $this->adminLpptka->person->refresh();
        $this->assertEquals('Admin LPPTKA Updated', $this->adminLpptka->person->full_name);
        $this->assertEquals('081234567890', $this->adminLpptka->person->phone);

        // Verify user email updated
        $this->adminLpptka->refresh();
        $this->assertEquals('admin.lpptka.updated@bkprmi.test', $this->adminLpptka->email);
    }

    /** @test */
    public function lpptka_admin_profile_requires_full_name_and_email()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.profile.update'), [
                'full_name' => '',
                'email' => '',
            ]);

        $response->assertSessionHasErrors(['full_name', 'email']);
    }

    /** @test */
    public function lpptka_admin_email_must_be_unique()
    {
        // Create another user with different email
        $otherPerson = Person::factory()->create(['full_name' => 'Other Admin']);
        $otherUser = User::factory()->create([
            'person_id' => $otherPerson->id,
            'email' => 'other.admin@bkprmi.test',
        ]);

        // Try to update with existing email
        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.profile.update'), [
                'full_name' => 'Admin LPPTKA',
                'email' => 'other.admin@bkprmi.test', // Email already exists
                'phone' => '081234567890',
            ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function lpptka_admin_can_update_password()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.password.update'), [
                'current_password' => 'password123',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect(route('lpptka.profile'));
        $response->assertSessionHas('success', 'Password berhasil diperbarui');

        // Verify can login with new password
        $this->post(route('logout'));
        $this->assertGuest();

        $loginResponse = $this->post(route('login'), [
            'email' => 'admin.lpptka@bkprmi.test',
            'password' => 'newpassword123',
        ]);

        $this->assertAuthenticated();
        $loginResponse->assertRedirect(route('lpptka.dashboard'));
    }

    /** @test */
    public function lpptka_admin_password_update_requires_correct_current_password()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.password.update'), [
                'current_password' => 'wrongpassword',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertSessionHasErrors(['current_password']);
    }

    /** @test */
    public function lpptka_admin_password_update_requires_confirmation()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.password.update'), [
                'current_password' => 'password123',
                'password' => 'newpassword123',
                'password_confirmation' => 'differentpassword',
            ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function lpptka_admin_password_must_be_at_least_8_characters()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->put(route('lpptka.password.update'), [
                'current_password' => 'password123',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function lpptka_admin_profile_shows_correct_statistics()
    {
        // Create some units with different statuses
        $unit1 = $this->createUnit('TPA Test 1', StatusApprovalUnit::APPROVED);
        $unit2 = $this->createUnit('TPA Test 2', StatusApprovalUnit::PENDING);
        $unit3 = $this->createUnit('TPA Test 3', StatusApprovalUnit::APPROVED);

        // Create admin TPA user
        $adminTpaPerson = Person::factory()->create(['full_name' => 'Admin TPA']);
        $adminTpa = User::factory()->create([
            'person_id' => $adminTpaPerson->id,
            'email' => 'admin.tpa@test.com',
            'is_active' => true,
        ]);
        UserRole::create([
            'user_id' => $adminTpa->id,
            'role' => RoleType::ADMIN_TPA->value,
        ]);

        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.profile'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');

        $stats = $response->viewData('stats');
        $this->assertEquals(3, $stats['total_units']);
        $this->assertEquals(1, $stats['pending_units']);
        $this->assertEquals(2, $stats['approved_units']);
        $this->assertEquals(1, $stats['active_accounts']);
    }

    /** @test */
    public function non_lpptka_admin_cannot_access_profile()
    {
        // Create user with different role (admin TPA)
        $tpaPerson = Person::factory()->create(['full_name' => 'Admin TPA']);
        $tpaUser = User::factory()->create([
            'person_id' => $tpaPerson->id,
            'email' => 'admin.tpa.test@test.com',
        ]);
        UserRole::create([
            'user_id' => $tpaUser->id,
            'role' => RoleType::ADMIN_TPA->value,
        ]);

        $response = $this->actingAs($tpaUser)
            ->get(route('lpptka.profile'));

        // Middleware redirects when access is denied
        $response->assertStatus(302);
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    private function createUnit(string $name, StatusApprovalUnit $status): Unit
    {
        return Unit::create([
            'unit_number' => 'UNIT-' . fake()->unique()->numerify('#####'),
            'name' => $name,
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test No. 123',
            'rt' => '001',
            'rw' => '002',
            'tipe_lokasi' => 'masjid',
            'status_bangunan' => 'milik_sendiri',
            'waktu_kegiatan' => 'pagi',
            'mosque_name' => 'Masjid ' . $name,
            'founder' => 'Founder ' . $name,
            'formed_at' => now()->subYears(5),
            'joined_year' => now()->year - 3,
            'email' => strtolower(str_replace(' ', '', $name)) . '@test.com',
            'approval_status' => $status->value,
            'certificate_path' => 'certificates/test-certificate.pdf',
            'certificate_uploaded_at' => now(),
        ]);
    }
}
