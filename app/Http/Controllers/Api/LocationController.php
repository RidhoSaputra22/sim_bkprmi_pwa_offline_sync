<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LocationFilterService;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function __construct(
        protected LocationFilterService $locationService
    ) {}

    /**
     * Get districts in Makassar for Admin TPA
     * Endpoint: GET /api/location/districts-makassar
     */
    public function districtsMakassar(): JsonResponse
    {
        $districts = $this->locationService->getDistrictsInMakassar();

        return response()->json([
            'success' => true,
            'data' => $districts->map(fn ($d) => [
                'id' => $d->id,
                'name' => $d->name,
            ]),
        ]);
    }

    /**
     * Get villages by district
     * Endpoint: GET /api/location/villages?district_id={id}
     */
    public function villagesByDistrict(): JsonResponse
    {
        $districtId = request('district_id');

        if (! $districtId) {
            return response()->json([
                'success' => false,
                'message' => 'District ID is required',
            ], 400);
        }

        // Validate district is in Makassar
        if (! $this->locationService->isDistrictInMakassar((int) $districtId)) {
            return response()->json([
                'success' => false,
                'message' => 'District is not in Makassar',
            ], 400);
        }

        $villages = $this->locationService->getVillagesByDistrict((int) $districtId);

        return response()->json([
            'success' => true,
            'data' => $villages->map(fn ($v) => [
                'id' => $v->id,
                'name' => $v->name,
            ]),
        ]);
    }

    /**
     * Get Makassar location info
     * Endpoint: GET /api/location/makassar-info
     */
    public function makassarInfo(): JsonResponse
    {
        $province = $this->locationService->getProvinceSulsel();
        $city = $this->locationService->getCityMakassar();

        return response()->json([
            'success' => true,
            'data' => [
                'province' => $province ? [
                    'id' => $province->id,
                    'name' => $province->name,
                ] : null,
                'city' => $city ? [
                    'id' => $city->id,
                    'name' => $city->name,
                ] : null,
            ],
        ]);
    }
}
