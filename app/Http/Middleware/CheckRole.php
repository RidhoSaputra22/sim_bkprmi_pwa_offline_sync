<?php

namespace App\Http\Middleware;

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
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Get user roles
        $userRoles = $request->user()->roles->pluck('role')->toArray();

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }

        // If user doesn't have required role, redirect based on their role
        if (in_array('member', $userRoles) || in_array('anggota', $userRoles)) {
            return redirect()->route('member.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect()->route('admin.dashboard')
            ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
