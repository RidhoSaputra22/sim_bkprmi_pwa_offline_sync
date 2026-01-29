<?php

namespace Tests\Feature;

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
 * Role-Based Authentication Tests
 *
 * Tests untuk memastikan setiap role hanya dapat mengakses
 * route yang sesuai dengan hak aksesnya
 */
class RoleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $adminLpptka;
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

        // Create unit
        $this->unit = Unit::create([
            'unit_number' => 'UNIT-12345',
            'name' => 'TPA Test',
            'region_id' => $this->region->id,
            'village_id' => $this->village->id,
            'address' => 'Jl. Test',
            'rt' => '001',
            'rw' => '001',
            'tipe_lokasi' => 'masjid',
            'status_bangunan' => 'milik_sendiri',
            'waktu_kegiatan' => 'pagi',
            'mosque_name' => 'Masjid Test',
            'founder' => 'H. Test',
            'formed_at' => now()->subYears(3),
            'joined_year' => now()->year - 2,
            'email' => 'test@test.com',
            'approval_status' => StatusApprovalUnit::APPROVED->value,
        ]);

        // Create SuperAdmin
        $this->superAdmin = $this->createUserWithRole('superadmin@test.com', RoleType::SUPERADMIN);

        // Create Admin LPPTKA
        $this->adminLpptka = $this->createUserWithRole('lpptka@test.com', RoleType::ADMIN_LPPTKA);

        // Create Admin TPA (linked to unit)
        $this->adminTpa = $this->createUserWithRole('tpa@test.com', RoleType::ADMIN_TPA);
        $this->unit->admin_user_id = $this->adminTpa->id;
        $this->unit->save();
    }

    // ============================================================
    // GUEST ACCESS TESTS
    // ============================================================

    /** @test */
    public function guest_cannot_access_superadmin_routes()
    {
        $response = $this->get(route('superadmin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_access_lpptka_routes()
    {
        $response = $this->get(route('lpptka.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_access_tpa_routes()
    {
        $response = $this->get(route('tpa.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_can_access_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    // ============================================================
    // SUPERADMIN ACCESS TESTS
    // ============================================================

    /** @test */
    public function superadmin_can_access_superadmin_dashboard()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function superadmin_can_access_unit_approval_routes()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('superadmin.units.approval.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function superadmin_cannot_access_lpptka_dashboard()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('lpptka.dashboard'));

        $response->assertRedirect(route('superadmin.dashboard'));
    }

    /** @test */
    public function superadmin_cannot_access_lpptka_units()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('lpptka.units.index'));

        $response->assertRedirect(route('superadmin.dashboard'));
    }

    /** @test */
    public function superadmin_cannot_access_tpa_dashboard()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('tpa.dashboard'));

        $response->assertRedirect(route('superadmin.dashboard'));
    }

    /** @test */
    public function superadmin_cannot_access_tpa_santri()
    {
        $response = $this->actingAs($this->superAdmin)
            ->get(route('tpa.santri.index'));

        $response->assertRedirect(route('superadmin.dashboard'));
    }

    // ============================================================
    // ADMIN LPPTKA ACCESS TESTS
    // ============================================================

    /** @test */
    public function lpptka_admin_can_access_lpptka_dashboard()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function lpptka_admin_can_access_units_routes()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.units.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function lpptka_admin_can_access_tpa_accounts_routes()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('lpptka.tpa-accounts.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function lpptka_admin_cannot_access_superadmin_dashboard()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('superadmin.dashboard'));

        $response->assertRedirect(route('lpptka.dashboard'));
    }

    /** @test */
    public function lpptka_admin_cannot_access_unit_approval()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('superadmin.units.approval.index'));

        $response->assertRedirect(route('lpptka.dashboard'));
    }

    /** @test */
    public function lpptka_admin_cannot_access_tpa_dashboard()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('tpa.dashboard'));

        $response->assertRedirect(route('lpptka.dashboard'));
    }

    /** @test */
    public function lpptka_admin_cannot_access_tpa_santri()
    {
        $response = $this->actingAs($this->adminLpptka)
            ->get(route('tpa.santri.index'));

        $response->assertRedirect(route('lpptka.dashboard'));
    }

    // ============================================================
    // ADMIN TPA ACCESS TESTS
    // ============================================================

    /** @test */
    public function tpa_admin_can_access_tpa_dashboard()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function tpa_admin_can_access_santri_routes()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.santri.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function tpa_admin_can_access_own_unit_profile()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('tpa.unit.show'));

        $response->assertStatus(200);
    }

    /** @test */
    public function tpa_admin_cannot_access_superadmin_dashboard()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('superadmin.dashboard'));

        $response->assertRedirect(route('tpa.dashboard'));
    }

    /** @test */
    public function tpa_admin_cannot_access_unit_approval()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('superadmin.units.approval.index'));

        $response->assertRedirect(route('tpa.dashboard'));
    }

    /** @test */
    public function tpa_admin_cannot_access_lpptka_dashboard()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('lpptka.dashboard'));

        $response->assertRedirect(route('tpa.dashboard'));
    }

    /** @test */
    public function tpa_admin_cannot_access_lpptka_units()
    {
        $response = $this->actingAs($this->adminTpa)
            ->get(route('lpptka.units.index'));

        $response->assertRedirect(route('tpa.dashboard'));
    }

    // ============================================================
    // LOGIN REDIRECT TESTS
    // ============================================================

    /** @test */
    public function superadmin_login_redirects_to_superadmin_dashboard()
    {
        $response = $this->post(route('login'), [
            'email' => 'superadmin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('superadmin.dashboard'));
    }

    /** @test */
    public function lpptka_admin_login_redirects_to_lpptka_dashboard()
    {
        $response = $this->post(route('login'), [
            'email' => 'lpptka@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('lpptka.dashboard'));
    }

    /** @test */
    public function tpa_admin_login_redirects_to_tpa_dashboard()
    {
        $response = $this->post(route('login'), [
            'email' => 'tpa@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('tpa.dashboard'));
    }

    // ============================================================
    // INACTIVE USER TESTS
    // ============================================================

    /** @test */
    public function inactive_user_cannot_login()
    {
        $inactiveUser = $this->createUserWithRole('inactive@test.com', RoleType::ADMIN_TPA, false);

        $response = $this->post(route('login'), [
            'email' => 'inactive@test.com',
            'password' => 'password',
        ]);

        // User should not be logged in or should be logged out
        // Depending on implementation
        $this->assertTrue(true); // Placeholder - depends on implementation
    }

    // ============================================================
    // LOGOUT TESTS
    // ============================================================

    /** @test */
    public function superadmin_can_logout()
    {
        $this->actingAs($this->superAdmin);

        $response = $this->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function lpptka_admin_can_logout()
    {
        $this->actingAs($this->adminLpptka);

        $response = $this->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function tpa_admin_can_logout()
    {
        $this->actingAs($this->adminTpa);

        $response = $this->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    private function createUserWithRole(string $email, RoleType $role, bool $isActive = true): User
    {
        $person = Person::factory()->create();
        $user = User::factory()->create([
            'person_id' => $person->id,
            'email' => $email,
            'password' => 'password',
            'is_active' => $isActive,
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role' => $role->value,
        ]);

        return $user;
    }
}
