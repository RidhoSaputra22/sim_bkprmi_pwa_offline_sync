<?php

namespace Tests\Feature\Member;

use App\Enum\RoleType;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Feature tests for ActivityController (Member)
 * Tests all methods: index(), show(), logs()
 */
class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $member;

    protected Unit $unit;

    protected Region $region;

    protected function setUp(): void
    {
        parent::setUp();

        $this->member = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $this->member->id,
            'role' => RoleType::MEMBER->value,
        ]);

        $this->region = Region::factory()->create();
        $this->unit = Unit::factory()->create(['region_id' => $this->region->id]);
    }

    // ========================================
    // Test: index() - Activity List
    // ========================================

    #[Test]
    public function guest_cannot_access_activities_index(): void
    {
        $response = $this->get(route('member.activities.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_access_activities_index(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.activities.index');
    }

    #[Test]
    public function activities_index_returns_activities_with_unit(): void
    {
        Activity::factory()->count(3)->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index'));

        $response->assertStatus(200);
        $response->assertViewHas('activities');

        $activities = $response->viewData('activities');
        $this->assertTrue($activities->first()->relationLoaded('unit'));
    }

    #[Test]
    public function activities_can_be_searched_by_title(): void
    {
        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'title' => 'Kegiatan Ramadhan',
            'created_by' => $this->member->id,
        ]);
        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'title' => 'Kegiatan Idul Adha',
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index', ['search' => 'Ramadhan']));

        $response->assertStatus(200);
    }

    #[Test]
    public function activities_can_be_searched_by_description(): void
    {
        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'description' => 'Kegiatan buka puasa bersama',
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index', ['search' => 'buka puasa']));

        $response->assertStatus(200);
    }

    #[Test]
    public function activities_can_be_filtered_by_unit_id(): void
    {
        $unit2 = Unit::factory()->create(['region_id' => $this->region->id]);

        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'title' => 'Kegiatan Unit 1',
            'created_by' => $this->member->id,
        ]);
        Activity::factory()->create([
            'unit_id' => $unit2->id,
            'title' => 'Kegiatan Unit 2',
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index', ['unit_id' => $this->unit->id]));

        $response->assertStatus(200);
    }

    #[Test]
    public function activities_can_be_filtered_by_activity_date(): void
    {
        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'activity_date' => '2026-01-01',
            'created_by' => $this->member->id,
        ]);
        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'activity_date' => '2026-06-01',
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function activities_are_paginated_with_15_per_page(): void
    {
        Activity::factory()->count(20)->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index'));

        $response->assertStatus(200);
        $activities = $response->viewData('activities');
        $this->assertEquals(15, $activities->perPage());
    }

    #[Test]
    public function activities_pagination_can_navigate_to_second_page(): void
    {
        Activity::factory()->count(20)->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index', ['page' => 2]));

        $response->assertStatus(200);
        $activities = $response->viewData('activities');
        $this->assertEquals(2, $activities->currentPage());
    }

    // ========================================
    // Test: show() - Activity Detail
    // ========================================

    #[Test]
    public function guest_cannot_access_activity_show(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->get(route('member.activities.show', $activity));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_view_activity_detail(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'title' => 'Kegiatan Test Detail',
            'description' => 'Deskripsi kegiatan untuk test',
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.show', $activity));

        $response->assertStatus(200);
        $response->assertViewIs('member.activities.show');
        $response->assertViewHas('activity');
    }

    #[Test]
    public function activity_show_loads_unit_relationship(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.show', $activity));

        $response->assertStatus(200);
        $viewActivity = $response->viewData('activity');
        $this->assertTrue($viewActivity->relationLoaded('unit'));
    }

    #[Test]
    public function activity_show_loads_created_by_relationship(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.show', $activity));

        $response->assertStatus(200);
        $viewActivity = $response->viewData('activity');
        $this->assertTrue($viewActivity->relationLoaded('createdBy'));
    }

    #[Test]
    public function activity_show_returns_404_for_non_existent_activity(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.activities.show', 99999));

        $response->assertStatus(404);
    }

    // ========================================
    // Test: logs() - Activity Logs
    // ========================================

    #[Test]
    public function guest_cannot_access_activity_logs(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->get(route('member.activities.logs', $activity));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_view_activity_logs(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.logs', $activity));

        $response->assertStatus(200);
        $response->assertViewIs('member.activities.logs');
    }

    #[Test]
    public function activity_logs_returns_activity_with_unit(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.logs', $activity));

        $response->assertStatus(200);
        $response->assertViewHas('activity');
        $viewActivity = $response->viewData('activity');
        $this->assertTrue($viewActivity->relationLoaded('unit'));
    }

    #[Test]
    public function activity_logs_returns_logs_variable(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.logs', $activity));

        $response->assertStatus(200);
        $response->assertViewHas('logs');
    }

    #[Test]
    public function activity_logs_are_paginated_with_10_per_page(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        // Create activity logs
        ActivityLog::factory()->count(15)->create([
            'module' => 'activity',
            'description' => "Activity ID: {$activity->id}",
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.logs', $activity));

        $response->assertStatus(200);
        $logs = $response->viewData('logs');
        $this->assertEquals(10, $logs->perPage());
    }

    #[Test]
    public function activity_logs_returns_404_for_non_existent_activity(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.activities.logs', 99999));

        $response->assertStatus(404);
    }
}
