<?php

namespace Tests\Feature\Member;

use App\Enum\RoleType;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->member = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $this->member->id,
            'role' => RoleType::MEMBER->value,
        ]);
    }

    #[Test]
    public function guest_cannot_access_organization_page(): void
    {
        $response = $this->get(route('member.organization.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_view_organization_info(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.organization.index');
    }

    #[Test]
    public function organization_page_displays_regions(): void
    {
        Region::factory()->count(3)->create();

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $response->assertStatus(200);
        $response->assertViewHas('regions');
    }

    #[Test]
    public function organization_page_displays_units(): void
    {
        $region = Region::factory()->create();
        Unit::factory()->count(3)->create(['region_id' => $region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function organization_page_displays_statistics(): void
    {
        $region = Region::factory()->create();
        Unit::factory()->count(5)->create(['region_id' => $region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $response->assertStatus(200);
        $response->assertViewHas('statistics');
    }

    #[Test]
    public function member_can_view_unit_detail(): void
    {
        $region = Region::factory()->create();
        $unit = Unit::factory()->create(['region_id' => $region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.unit.show', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('member.organization.unit-detail');
        $response->assertViewHas('unit');
    }

    #[Test]
    public function member_can_view_organization_structure(): void
    {
        Region::factory()->count(2)->create();

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.structure'));

        $response->assertStatus(200);
        $response->assertViewIs('member.organization.structure');
        $response->assertViewHas('regions');
    }
}
