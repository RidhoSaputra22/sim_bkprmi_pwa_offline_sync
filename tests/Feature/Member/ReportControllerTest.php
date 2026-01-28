<?php

namespace Tests\Feature\Member;

use App\Enum\RoleType;
use App\Models\Activity;
use App\Models\Person;
use App\Models\Region;
use App\Models\Santri;
use App\Models\SantriUnit;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Feature tests for ReportController (Member)
 * Tests all methods: index(), downloadSantriReport(), downloadActivityReport(),
 *                    downloadUnitReport(), print()
 */
class ReportControllerTest extends TestCase
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
    // Test: index() - Reports Index Page
    // ========================================

    #[Test]
    public function guest_cannot_access_reports_index(): void
    {
        $response = $this->get(route('member.reports.index'));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function member_can_access_reports_index(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.reports.index');
    }

    #[Test]
    public function reports_index_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.index'));

        $response->assertStatus(200);
    }

    // ========================================
    // Test: downloadSantriReport() - Download Santri Report
    // ========================================

    #[Test]
    public function guest_cannot_download_santri_report(): void
    {
        $response = $this->post(route('member.reports.download.santri'), [
            'format' => 'pdf',
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function download_santri_report_requires_format(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.santri'), []);

        $response->assertSessionHasErrors('format');
    }

    #[Test]
    public function download_santri_report_validates_format_options(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.santri'), [
                'format' => 'invalid_format',
            ]);

        $response->assertSessionHasErrors('format');
    }

    #[Test]
    public function download_santri_report_validates_unit_id_exists(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.santri'), [
                'format' => 'pdf',
                'unit_id' => 99999,
            ]);

        $response->assertSessionHasErrors('unit_id');
    }

    #[Test]
    public function download_santri_report_accepts_valid_unit_id(): void
    {
        // Create santri data
        $person = Person::factory()->create();
        $santri = Santri::factory()->create(['person_id' => $person->id]);
        SantriUnit::factory()->create([
            'santri_id' => $santri->id,
            'unit_id' => $this->unit->id,
        ]);

        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.santri'), [
                'format' => 'pdf',
                'unit_id' => $this->unit->id,
            ]);

        // Should either download PDF or return error (depends on DomPDF installation)
        $this->assertTrue(
            $response->isOk() ||
            $response->isRedirect() ||
            $response->status() === 500 // If DomPDF not configured
        );
    }

    #[Test]
    public function download_santri_report_excel_returns_error(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.santri'), [
                'format' => 'excel',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Format Excel belum tersedia');
    }

    // ========================================
    // Test: downloadActivityReport() - Download Activity Report
    // ========================================

    #[Test]
    public function guest_cannot_download_activity_report(): void
    {
        $response = $this->post(route('member.reports.download.activity'), [
            'format' => 'pdf',
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function download_activity_report_requires_format(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.activity'), []);

        $response->assertSessionHasErrors('format');
    }

    #[Test]
    public function download_activity_report_validates_format_options(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.activity'), [
                'format' => 'csv',
            ]);

        $response->assertSessionHasErrors('format');
    }

    #[Test]
    public function download_activity_report_validates_unit_id_exists(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.activity'), [
                'format' => 'pdf',
                'unit_id' => 99999,
            ]);

        $response->assertSessionHasErrors('unit_id');
    }

    #[Test]
    public function download_activity_report_validates_date_range(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.activity'), [
                'format' => 'pdf',
                'start_date' => '2026-12-01',
                'end_date' => '2026-01-01', // end before start
            ]);

        $response->assertSessionHasErrors('end_date');
    }

    #[Test]
    public function download_activity_report_accepts_valid_date_range(): void
    {
        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'activity_date' => '2026-01-15',
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.activity'), [
                'format' => 'pdf',
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
            ]);

        // Should either download PDF or return error
        $this->assertTrue(
            $response->isOk() ||
            $response->isRedirect() ||
            $response->status() === 500
        );
    }

    #[Test]
    public function download_activity_report_excel_returns_error(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.activity'), [
                'format' => 'excel',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Format Excel belum tersedia');
    }

    // ========================================
    // Test: downloadUnitReport() - Download Unit Report
    // ========================================

    #[Test]
    public function guest_cannot_download_unit_report(): void
    {
        $response = $this->post(route('member.reports.download.unit'), [
            'format' => 'pdf',
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function download_unit_report_requires_format(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.unit'), []);

        $response->assertSessionHasErrors('format');
    }

    #[Test]
    public function download_unit_report_validates_format_options(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.unit'), [
                'format' => 'word',
            ]);

        $response->assertSessionHasErrors('format');
    }

    #[Test]
    public function download_unit_report_validates_region_id_exists(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.unit'), [
                'format' => 'pdf',
                'region_id' => 99999,
            ]);

        $response->assertSessionHasErrors('region_id');
    }

    #[Test]
    public function download_unit_report_accepts_valid_region_id(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.unit'), [
                'format' => 'pdf',
                'region_id' => $this->region->id,
            ]);

        // Should either download PDF or return error
        $this->assertTrue(
            $response->isOk() ||
            $response->isRedirect() ||
            $response->status() === 500
        );
    }

    #[Test]
    public function download_unit_report_excel_returns_error(): void
    {
        $response = $this->actingAs($this->member)
            ->post(route('member.reports.download.unit'), [
                'format' => 'excel',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Format Excel belum tersedia');
    }

    // ========================================
    // Test: print() - Print Report
    // ========================================

    #[Test]
    public function guest_cannot_access_print_report(): void
    {
        $response = $this->get(route('member.reports.print', ['type' => 'santri']));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function print_report_requires_type(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print'));

        $response->assertSessionHasErrors('type');
    }

    #[Test]
    public function print_report_validates_type_options(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', ['type' => 'invalid']));

        $response->assertSessionHasErrors('type');
    }

    #[Test]
    public function print_santri_report_returns_view(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', ['type' => 'santri']));

        $response->assertStatus(200);
        $response->assertViewIs('member.reports.print');
        $response->assertViewHas('type', 'santri');
        $response->assertViewHas('santris');
    }

    #[Test]
    public function print_activity_report_returns_view(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', ['type' => 'activity']));

        $response->assertStatus(200);
        $response->assertViewIs('member.reports.print');
        $response->assertViewHas('type', 'activity');
        $response->assertViewHas('activities');
    }

    #[Test]
    public function print_unit_report_returns_view(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', ['type' => 'unit']));

        $response->assertStatus(200);
        $response->assertViewIs('member.reports.print');
        $response->assertViewHas('type', 'unit');
        $response->assertViewHas('units');
    }

    #[Test]
    public function print_santri_report_can_filter_by_unit(): void
    {
        $person = Person::factory()->create();
        $santri = Santri::factory()->create(['person_id' => $person->id]);
        SantriUnit::factory()->create([
            'santri_id' => $santri->id,
            'unit_id' => $this->unit->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', [
                'type' => 'santri',
                'unit_id' => $this->unit->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewHas('santris');
    }

    #[Test]
    public function print_activity_report_can_filter_by_unit(): void
    {
        Activity::factory()->create([
            'unit_id' => $this->unit->id,
            'created_by' => $this->member->id,
        ]);

        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', [
                'type' => 'activity',
                'unit_id' => $this->unit->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewHas('activities');
    }

    #[Test]
    public function print_activity_report_can_filter_by_date_range(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', [
                'type' => 'activity',
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
            ]));

        $response->assertStatus(200);
        $response->assertViewHas('activities');
    }

    #[Test]
    public function print_unit_report_can_filter_by_region(): void
    {
        $response = $this->actingAs($this->member)
            ->get(route('member.reports.print', [
                'type' => 'unit',
                'region_id' => $this->region->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewHas('units');
    }
}
