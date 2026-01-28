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

class MemberDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $member;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a member user
        $this->member = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $this->member->id,
            'role' => RoleType::MEMBER->value,
        ]);
    }

    #[Test]
    public function guest_cannot_access_member_dashboard(): void
    {
        $response = $this->get(route('member.dashboard'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function authenticated_member_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('member.dashboard');
    }

    #[Test]
    public function dashboard_displays_statistics(): void
    {
        // Create test data
        $region = Region::factory()->create();
        $units = Unit::factory()->count(3)->create(['region_id' => $region->id]);
        $activities = Activity::factory()->count(5)->create([
            'unit_id' => $units->first()->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalUnits');
        $response->assertViewHas('totalActivities');
    }

    #[Test]
    public function dashboard_displays_recent_activities(): void
    {
        $region = Region::factory()->create();
        $unit = Unit::factory()->create(['region_id' => $region->id]);
        Activity::factory()->count(10)->create(['unit_id' => $unit->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('recentActivities');
    }

    #[Test]
    public function dashboard_has_quick_action_links(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertSee(route('member.organization.index'));
        $response->assertSee(route('member.activities.index'));
        $response->assertSee(route('member.reports.index'));
    }
}
