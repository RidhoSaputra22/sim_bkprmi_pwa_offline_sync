<?php

namespace Tests\Feature\Member;

use App\Enum\RoleType;
use App\Models\Activity;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Feature tests for MemberDashboardController
 * Tests all methods: index()
 */
class MemberDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $member;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create member user
        $this->member = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $this->member->id,
            'role' => RoleType::MEMBER->value,
        ]);

        // Create admin user
        $this->admin = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $this->admin->id,
            'role' => RoleType::ADMIN->value,
        ]);
    }

    // ========================================
    // Test: index() - Dashboard Page
    // ========================================

    #[Test]
    public function guest_cannot_access_member_dashboard(): void
    {
        $response = $this->get(route('member.dashboard'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('member.dashboard');
    }

    #[Test]
    public function admin_can_also_access_member_dashboard(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('member.dashboard');
    }

    #[Test]
    public function dashboard_returns_total_units_count(): void
    {
        $region = Region::factory()->create();
        Unit::factory()->count(5)->create(['region_id' => $region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalUnits', 5);
    }

    #[Test]
    public function dashboard_returns_total_activities_count(): void
    {
        $region = Region::factory()->create();
        $unit = Unit::factory()->create(['region_id' => $region->id]);
        Activity::factory()->count(10)->create([
            'unit_id' => $unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalActivities', 10);
    }

    #[Test]
    public function dashboard_returns_recent_activities_limited_to_five(): void
    {
        $region = Region::factory()->create();
        $unit = Unit::factory()->create(['region_id' => $region->id]);
        Activity::factory()->count(10)->create([
            'unit_id' => $unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('recentActivities');

        $recentActivities = $response->viewData('recentActivities');
        $this->assertCount(5, $recentActivities);
    }

    #[Test]
    public function dashboard_recent_activities_ordered_by_latest(): void
    {
        $region = Region::factory()->create();
        $unit = Unit::factory()->create(['region_id' => $region->id]);

        $oldActivity = Activity::factory()->create([
            'unit_id' => $unit->id,
            'created_by' => $this->member->id,
            'created_at' => now()->subDays(5),
        ]);

        $newActivity = Activity::factory()->create([
            'unit_id' => $unit->id,
            'created_by' => $this->member->id,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $recentActivities = $response->viewData('recentActivities');
        $this->assertEquals($newActivity->id, $recentActivities->first()->id);
    }

    #[Test]
    public function dashboard_activities_eager_load_unit_relationship(): void
    {
        $region = Region::factory()->create();
        $unit = Unit::factory()->create(['region_id' => $region->id]);
        Activity::factory()->create([
            'unit_id' => $unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $recentActivities = $response->viewData('recentActivities');
        $this->assertTrue($recentActivities->first()->relationLoaded('unit'));
    }

    #[Test]
    public function dashboard_shows_zero_when_no_data_exists(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalUnits', 0);
        $response->assertViewHas('totalActivities', 0);
        $response->assertViewHas('recentActivities');
    }

    #[Test]
    public function dashboard_displays_quick_action_links(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertSee(route('member.organization.index'));
        $response->assertSee(route('member.activities.index'));
        $response->assertSee(route('member.reports.index'));
    }
}
