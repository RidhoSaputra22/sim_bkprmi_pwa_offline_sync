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

class ReportTest extends TestCase
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
    public function guest_cannot_access_reports_page(): void
    {
        $response = $this->get(route('member.reports.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_view_reports_page(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.reports.index');
    }

    #[Test]
    public function reports_page_shows_available_report_types(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function download_santri_report_requires_authentication(): void
    {
        $response = $this->post(route('member.reports.download.santri'), [
            'format' => 'pdf',
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function download_activity_report_requires_authentication(): void
    {
        $response = $this->post(route('member.reports.download.activity'), [
            'format' => 'pdf',
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function download_unit_report_requires_authentication(): void
    {
        $response = $this->post(route('member.reports.download.unit'), [
            'format' => 'pdf',
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function print_report_requires_authentication(): void
    {
        $response = $this->get(route('member.reports.print', ['type' => 'santri']));

        $response->assertRedirect(route('login'));
    }
}
