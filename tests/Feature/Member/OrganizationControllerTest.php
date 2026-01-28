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

/**
 * Feature tests for OrganizationController (Member)
 * Tests all methods: index(), showUnit(), structure()
 */
class OrganizationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $member;
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
    }

    // ========================================
    // Test: index() - Organization Information
    // ========================================

    #[Test]
    public function guest_cannot_access_organization_index(): void
    {
        $response = $this->get(route('member.organization.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_access_organization_index(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.organization.index');
    }

    #[Test]
    public function organization_index_returns_regions_with_units(): void
    {
        Unit::factory()->count(3)->create(['region_id' => $this->region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $response->assertStatus(200);
        $response->assertViewHas('regions');

        $regions = $response->viewData('regions');
        $this->assertTrue($regions->first()->relationLoaded('units'));
    }

    #[Test]
    public function organization_index_returns_statistics(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $response->assertStatus(200);
        $response->assertViewHas('statistics');
    }

    #[Test]
    public function organization_statistics_contains_total_units(): void
    {
        Unit::factory()->count(5)->create(['region_id' => $this->region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $statistics = $response->viewData('statistics');
        $this->assertEquals(5, $statistics['total_units']);
    }

    #[Test]
    public function organization_statistics_contains_total_regions(): void
    {
        Region::factory()->count(3)->create();

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $statistics = $response->viewData('statistics');
        // Total 4 regions (1 from setUp + 3 new)
        $this->assertEquals(4, $statistics['total_regions']);
    }

    #[Test]
    public function organization_statistics_contains_total_santri(): void
    {
        Unit::factory()->create([
            'region_id' => $this->region->id,
            'jumlah_tka_4_7' => 10,
            'jumlah_tpa_7_12' => 20,
            'jumlah_tqa_wisuda' => 5,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $statistics = $response->viewData('statistics');
        $this->assertEquals(35, $statistics['total_santri']);
    }

    #[Test]
    public function organization_statistics_contains_total_guru(): void
    {
        Unit::factory()->create([
            'region_id' => $this->region->id,
            'jumlah_guru_laki_laki' => 5,
            'jumlah_guru_perempuan' => 10,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $statistics = $response->viewData('statistics');
        $this->assertEquals(15, $statistics['total_guru']);
    }

    #[Test]
    public function organization_statistics_zero_when_no_data(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.organization.index'));

        $statistics = $response->viewData('statistics');
        $this->assertEquals(0, $statistics['total_units']);
        $this->assertEquals(0, $statistics['total_santri']);
        $this->assertEquals(0, $statistics['total_guru']);
    }

    // ========================================
    // Test: showUnit() - Unit Detail
    // ========================================

    #[Test]
    public function guest_cannot_access_unit_detail(): void
    {
        $unit = Unit::factory()->create(['region_id' => $this->region->id]);

        $response = $this->get(route('member.organization.unit.show', $unit));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_view_unit_detail(): void
    {
        $unit = Unit::factory()->create(['region_id' => $this->region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.unit.show', $unit));

        $response->assertStatus(200);
        $response->assertViewIs('member.organization.unit-detail');
        $response->assertViewHas('unit');
    }

    #[Test]
    public function unit_detail_loads_region_relationship(): void
    {
        $unit = Unit::factory()->create(['region_id' => $this->region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.unit.show', $unit));

        $viewUnit = $response->viewData('unit');
        $this->assertTrue($viewUnit->relationLoaded('region'));
    }

    #[Test]
    public function unit_detail_loads_village_relationship(): void
    {
        // Use village_id from region which is created by RegionFactory
        $unit = Unit::factory()->create([
            'region_id' => $this->region->id,
            'village_id' => $this->region->village_id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.unit.show', $unit));

        $viewUnit = $response->viewData('unit');
        $this->assertTrue($viewUnit->relationLoaded('village'));
    }

    #[Test]
    public function unit_detail_returns_404_for_non_existent_unit(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.organization.unit.show', 99999));

        $response->assertStatus(404);
    }

    #[Test]
    public function unit_detail_displays_unit_information(): void
    {
        $unit = Unit::factory()->create([
            'region_id' => $this->region->id,
            'name' => 'TPA Al-Ikhlas',
            'jumlah_tka_4_7' => 25,
            'jumlah_tpa_7_12' => 30,
            'jumlah_guru_laki_laki' => 3,
            'jumlah_guru_perempuan' => 5,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.unit.show', $unit));

        $response->assertStatus(200);
        $viewUnit = $response->viewData('unit');
        $this->assertEquals('TPA Al-Ikhlas', $viewUnit->name);
    }

    // ========================================
    // Test: structure() - Organization Structure
    // ========================================

    #[Test]
    public function guest_cannot_access_organization_structure(): void
    {
        $response = $this->get(route('member.organization.structure'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_view_organization_structure(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.organization.structure'));

        $response->assertStatus(200);
        $response->assertViewIs('member.organization.structure');
    }

    #[Test]
    public function organization_structure_returns_regions(): void
    {
        Region::factory()->count(3)->create();

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.structure'));

        $response->assertStatus(200);
        $response->assertViewHas('regions');
    }

    #[Test]
    public function organization_structure_regions_include_units(): void
    {
        Unit::factory()->count(5)->create(['region_id' => $this->region->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.structure'));

        $regions = $response->viewData('regions');
        $regionWithUnits = $regions->where('id', $this->region->id)->first();
        $this->assertTrue($regionWithUnits->relationLoaded('units'));
        $this->assertCount(5, $regionWithUnits->units);
    }

    #[Test]
    public function organization_structure_displays_hierarchy(): void
    {
        $region2 = Region::factory()->create();
        Unit::factory()->count(2)->create(['region_id' => $this->region->id]);
        Unit::factory()->count(3)->create(['region_id' => $region2->id]);

        $response = $this->actingAs($this->member)
            ->get(route('member.organization.structure'));

        $response->assertStatus(200);
        $regions = $response->viewData('regions');
        $this->assertCount(2, $regions);
    }
}
