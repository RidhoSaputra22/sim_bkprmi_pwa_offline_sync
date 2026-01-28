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

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    protected User $member;
    protected Unit $unit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->member = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $this->member->id,
            'role' => RoleType::MEMBER->value,
        ]);

        $region = Region::factory()->create();
        $this->unit = Unit::factory()->create(['region_id' => $region->id]);
    }

    #[Test]
    public function guest_cannot_access_activities_page(): void
    {
        $response = $this->get(route('member.activities.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_view_activities_list(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.activities.index');
    }

    #[Test]
    public function activities_page_displays_activities(): void
    {
        Activity::factory()->count(5)->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index'));

        $response->assertStatus(200);
        $response->assertViewHas('activities');
    }

    #[Test]
    public function activities_can_be_filtered_by_unit(): void
    {
        $region = Region::factory()->create();
        $unit2 = Unit::factory()->create(['region_id' => $region->id]);

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
    public function member_can_view_activity_detail(): void
    {
        $activity = Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'title' => 'Kegiatan Test',
            'description' => 'Deskripsi kegiatan test',
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.show', $activity));

        $response->assertStatus(200);
        $response->assertViewIs('member.activities.show');
        $response->assertViewHas('activity');
    }

    #[Test]
    public function activities_are_paginated(): void
    {
        Activity::factory()->count(20)->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.activities.index'));

        $response->assertStatus(200);
        $response->assertViewHas('activities', function ($activities) {
            return $activities->hasPages();
        });
    }
}
