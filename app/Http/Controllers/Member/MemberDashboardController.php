<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberDashboardController extends Controller
{
    /**
     * Display the member dashboard.
     */
    public function index(): View
    {
        // Get recent activities
        $recentActivities = Activity::with(['unit'])
            ->latest()
            ->take(5)
            ->get();

        // Get total units
        $totalUnits = Unit::count();

        // Get total activities
        $totalActivities = Activity::count();

        return view('member.dashboard', compact(
            'recentActivities',
            'totalUnits',
            'totalActivities'
        ));
    }
}
