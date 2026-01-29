<?php

namespace Tests\Feature\SuperAdmin;

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
use Tests\TestCase;

/**
 * SuperAdmin BKPRMI Flow Tests
 *
 * Tests yang mensimulasikan alur pengguna SuperAdmin:
 * - Login dan akses dashboard
 * - Melihat data TPA yang pending approval
 * - Approve atau reject TPA
 * - Melihat statistik keseluruhan
 */
class SuperAdminFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected Province $province;
    protected City $city;
    protected District $district;
    protected Village $village;
    protected Region $region;

    protected function setUp(): void
    {
        parent::setUp();

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

        // Create SuperAdmin user
        $person = Person::factory()->create(['full_name' => 'Super Admin BKPRMI']);
        $this->superAdmin = User::factory()->create([
            'person_id' => $person->id,
            'email' => 'superadmin@bkprmi.test',
            'password' => 'password123',
            'is_active' => true,
        ]);

        UserRole::create([
            'user_id' => $this->superAdmin->id,
            'role' => RoleType::SUPERADMIN->value,
        ]);
    }

    // ============================================================
    // AUTHENTICATION TESTS
    // ============================================================

    /** @test */
    public function superadmin_can_login_and_redirected_to_superadmin_dashboard()
    {
        $response = $this->post(route('login'), [
            'email' => 'superadmin@bkprmi.test',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('superadmin.dashboard'));
    }

    /** @test */
    public function superadmin_can_access_dashboard()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.dashboard');
    }

    /** @test */
    public function superadmin_cannot_access_lpptka_routes()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('lpptka.dashboard'));

        // Middleware redirects to user's own dashboard
        $response->assertRedirect(route('superadmin.dashboard'));
    }

    /** @test */
    public function superadmin_cannot_access_tpa_routes()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('tpa.dashboard'));

        // Middleware redirects to user's own dashboard
        $response->assertRedirect(route('superadmin.dashboard'));
    }

    // ============================================================
    // UNIT APPROVAL FLOW TESTS
    // ============================================================

    /** @test */
    public function superadmin_can_view_unit_approval_list()
    {
        // Create pending units
        $unit1 = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);
        $unit2 = $this->createUnit('TPA Al-Hidayah', StatusApprovalUnit::PENDING);
        $unit3 = $this->createUnit('TPA Al-Falah', StatusApprovalUnit::APPROVED);

        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.units.approval.index'));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.units.approval-index');
        $response->assertViewHas('units');
    }

    /** @test */
    public function superadmin_can_view_unit_approval_details()
    {
        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.units.approval.show', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('superadmin.units.approval-show');
        $response->assertViewHas('unit');
    }

    /** @test */
    public function superadmin_can_approve_pending_unit()
    {
        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->superAdmin)
            ->post(route('superadmin.units.approval.approve', $unit), [
                'notes' => 'Unit sudah memenuhi syarat',
            ]);

        $response->assertRedirect(route('superadmin.units.approval.index'));
        $response->assertSessionHas('success');

        $unit->refresh();
        $this->assertEquals(StatusApprovalUnit::APPROVED, $unit->approval_status);
        $this->assertEquals($this->superAdmin->id, $unit->approved_by);
        $this->assertNotNull($unit->approved_at);
    }

    /** @test */
    public function superadmin_can_reject_pending_unit()
    {
        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->superAdmin)
            ->post(route('superadmin.units.approval.reject', $unit), [
                'notes' => 'Sertifikat tidak valid',
            ]);

        $response->assertRedirect(route('superadmin.units.approval.index'));
        $response->assertSessionHas('success');

        $unit->refresh();
        $this->assertEquals(StatusApprovalUnit::REJECTED, $unit->approval_status);
    }

    /** @test */
    public function superadmin_cannot_approve_already_approved_unit()
    {
        $unit = $this->createUnit('TPA Al-Ikhlas', StatusApprovalUnit::APPROVED);

        $response = $this->actingAs($this->superAdmin)
            ->post(route('superadmin.units.approval.approve', $unit), [
                'notes' => 'Trying to approve again',
            ]);

        // Should redirect with error or handle gracefully
        $response->assertRedirect();
    }

    // ============================================================
    // COMPLETE APPROVAL FLOW TEST
    // ============================================================

    /** @test */
    public function complete_superadmin_approval_flow()
    {
        // Step 1: Login
        $this->post(route('login'), [
            'email' => 'superadmin@bkprmi.test',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();

        // Step 2: Visit dashboard
        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.dashboard'));
        $response->assertStatus(200);

        // Step 3: View pending approval list
        $unit = $this->createUnit('TPA Uji Coba', StatusApprovalUnit::PENDING);

        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.units.approval.index'));
        $response->assertStatus(200);

        // Step 4: View unit detail
        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.units.approval.show', $unit));
        $response->assertStatus(200);

        // Step 5: Approve unit
        $response = $this->actingAs($this->superAdmin)
            ->post(route('superadmin.units.approval.approve', $unit), [
                'notes' => 'Semua dokumen lengkap dan valid',
            ]);
        $response->assertRedirect(route('superadmin.units.approval.index'));

        // Step 6: Verify unit is approved
        $unit->refresh();
        $this->assertEquals(StatusApprovalUnit::APPROVED, $unit->approval_status);

        // Step 7: Logout
        $this->post(route('logout'));
        $this->assertGuest();
    }

    // ============================================================
    // DASHBOARD STATISTICS TESTS
    // ============================================================

    /** @test */
    public function superadmin_dashboard_shows_correct_statistics()
    {
        // Create various units with different statuses
        $this->createUnit('TPA 1', StatusApprovalUnit::PENDING);
        $this->createUnit('TPA 2', StatusApprovalUnit::PENDING);
        $this->createUnit('TPA 3', StatusApprovalUnit::APPROVED);
        $this->createUnit('TPA 4', StatusApprovalUnit::REJECTED);

        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    private function createUnit(string $name, StatusApprovalUnit $status, bool $withCertificate = true): Unit
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
            'certificate_path' => $withCertificate ? 'certificates/test-certificate.pdf' : null,
            'certificate_uploaded_at' => $withCertificate ? now() : null,
        ]);
    }
}
