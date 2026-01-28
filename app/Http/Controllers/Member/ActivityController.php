<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    /**
     * Display a listing of activities (Lihat Data Kegiatan).
     */
    public function index(Request $request): View
    {
        $query = Activity::with(['unit']);

        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '') {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Filter by unit
        if ($request->has('unit_id') && $request->unit_id != '') {
            $query->where('unit_id', $request->unit_id);
        }

        $activities = $query->latest('start_date')->paginate(15);

        return view('member.activities.index', compact('activities'));
    }

    /**
     * Display the specified activity.
     */
    public function show(Activity $activity): View
    {
        $activity->load(['unit', 'activityLogs']);

        return view('member.activities.show', compact('activity'));
    }

    /**
     * Display activity logs.
     */
    public function logs(Activity $activity): View
    {
        $activity->load(['unit']);
        $logs = $activity->activityLogs()
            ->orderBy('log_date', 'desc')
            ->paginate(10);

        return view('member.activities.logs', compact('activity', 'logs'));
    }
}
