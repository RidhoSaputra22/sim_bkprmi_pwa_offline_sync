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
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Get user roles
        $userRoles = $request->user()->roles->pluck('role')->toArray();

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if (in_array(RoleType::from($role), $userRoles)) {
                return $next($request);
            }
        }

        // If user doesn't have required role, redirect based on their role
        // SuperAdmin BKPRMI
        if (in_array(RoleType::SUPERADMIN, $userRoles)) {
            return redirect()->route('superadmin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        // Admin LPPTKA
        if (in_array(RoleType::ADMIN_LPPTKA, $userRoles)) {
            return redirect()->route('lpptka.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        // Admin TPA
        if (in_array(RoleType::ADMIN_TPA, $userRoles)) {
            return redirect()->route('tpa.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect()->route('login')
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
