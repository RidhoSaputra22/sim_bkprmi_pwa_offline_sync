<?php

namespace App\Http\Middleware;

use App\Enum\RoleType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // dd($roles, $request->user());

        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Get user roles
        $userRoles = $request->user()->roles->pluck('role')->toArray();

        // dd($userRoles);

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if (in_array(RoleType::from($role), $userRoles)) {
                return $next($request);
            }
        }

        // If user doesn't have required role, redirect based on their role
        if (in_array(RoleType::MEMBER, $userRoles) || in_array(RoleType::ANGGOTA, $userRoles)) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        if (in_array(RoleType::ADMIN, $userRoles)) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect()->route('login')
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');

    }
}
