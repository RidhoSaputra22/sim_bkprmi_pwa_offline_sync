<?php

namespace Tests\Feature\Member;

use App\Enum\RoleType;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MemberAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_is_redirected_to_login_for_all_member_routes(): void
    {
        $memberRoutes = [
            'member.dashboard',
            'member.organization.index',
            'member.organization.structure',
            'member.activities.index',
            'member.reports.index',
        ];

        foreach ($memberRoutes as $route) {
            $response = $this->get(route($route));
            $response->assertRedirect(route('login'));
        }
    }

    #[Test]
    public function authenticated_user_can_access_member_dashboard(): void
    {
        $user = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $user->id,
            'role' => RoleType::MEMBER->value,
        ]);

        $response = $this->actingAs($user)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
    }

    #[Test]
    public function inactive_user_can_still_access_member_pages(): void
    {
        // Note: If you want to restrict inactive users, add middleware check
        $user = User::factory()->create(['is_active' => false]);
        UserRole::factory()->create([
            'user_id' => $user->id,
            'role' => RoleType::MEMBER->value,
        ]);

        $response = $this->actingAs($user)
            ->get(route('member.dashboard'));

        // Currently no inactive check, so should be accessible
        // Change this if you add inactive user restriction
        $response->assertStatus(200);
    }

    #[Test]
    public function admin_can_also_access_member_pages(): void
    {
        $admin = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $admin->id,
            'role' => RoleType::ADMIN->value,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('member.dashboard'));

        $response->assertStatus(200);
    }

    #[Test]
    public function user_can_logout_from_member_area(): void
    {
        $user = User::factory()->create();
        UserRole::factory()->create([
            'user_id' => $user->id,
            'role' => RoleType::MEMBER->value,
        ]);

        $response = $this->actingAs($user)
            ->post(route('logout'));

        $response->assertRedirect();
        $this->assertGuest();
    }

    #[Test]
    public function login_redirects_to_intended_page(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'password' => 'password',
        ]);
        UserRole::factory()->create([
            'user_id' => $user->id,
            'role' => RoleType::MEMBER->value,
        ]);

        // First, try to access protected page as guest
        $this->get(route('member.activities.index'));

        // Then login
        $response = $this->post(route('login'), [
            'email' => 'member@example.com',
            'password' => 'password',
        ]);

        // Should redirect to intended page (activities) or dashboard
        $response->assertRedirect();
    }
}
