<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Get all provinces
     */
    public function provinces()
    {
        $provinces = Province::orderBy('name')->get(['id', 'name']);
        return response()->json($provinces);
    }

    /**
     * Get cities by province
     */
    public function cities(Request $request)
    {
        $request->validate([
            'province_id' => 'required|exists:provinces,id'
        ]);

        $cities = City::where('province_id', $request->province_id)
            ->orderBy('name')
            ->get(['id', 'name', 'province_id']);

        return response()->json($cities);
    }

    /**
     * Get districts by city
     */
    public function districts(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id'
        ]);

        $districts = District::where('city_id', $request->city_id)
            ->orderBy('name')
            ->get(['id', 'name', 'city_id']);

        return response()->json($districts);
    }

    /**
     * Get villages by district
     */
    public function villages(Request $request)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id'
        ]);

        $villages = Village::where('district_id', $request->district_id)
            ->orderBy('name')
            ->get(['id', 'name', 'district_id']);

        return response()->json($villages);
    }
}
