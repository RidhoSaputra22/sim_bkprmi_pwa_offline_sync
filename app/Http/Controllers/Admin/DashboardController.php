<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Santri;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_santri' => Santri::count(),
            'total_units' => Unit::count(),
            'total_activities' => Activity::count(),
            'recent_activities' => Activity::with('unit')
                ->latest('activity_date')
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
