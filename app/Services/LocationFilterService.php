<?php

namespace App\Services;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Support\Collection;

/**
 * Service untuk mengelola filter lokasi
 *
 * Khusus untuk Admin TPA:
 * - Provinsi: Sulawesi Selatan (Sulsel)
 * - Kota: Makassar
 * - Kecamatan: Otomatis filter berdasarkan Kota Makassar
 * - Kelurahan: Berdasarkan kecamatan yang dipilih
 */
class LocationFilterService
{
    /**
     * Nama Provinsi Sulawesi Selatan
     */
    public const PROVINCE_SULSEL = 'Sulawesi Selatan';

    /**
     * Nama Kota Makassar
     */
    public const CITY_MAKASSAR = 'Makassar';

    /**
     * Get Provinsi Sulawesi Selatan
     */
    public function getProvinceSulsel(): ?Province
    {
        return Province::where('name', 'like', '%' . self::PROVINCE_SULSEL . '%')
            ->orWhere('name', 'like', '%SULAWESI SELATAN%')
            ->orWhere('name', 'like', '%Sulsel%')
            ->first();
    }

    /**
     * Get Kota Makassar
     */
    public function getCityMakassar(): ?City
    {
        $province = $this->getProvinceSulsel();

        if (! $province) {
            return null;
        }

        return City::where('province_id', $province->id)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . self::CITY_MAKASSAR . '%')
                    ->orWhere('name', 'like', '%MAKASSAR%');
            })
            ->first();
    }

    /**
     * Get Kecamatan di Kota Makassar
     */
    public function getDistrictsInMakassar(): Collection
    {
        $city = $this->getCityMakassar();

        if (! $city) {
            return collect();
        }

        return District::where('city_id', $city->id)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get Kelurahan berdasarkan Kecamatan
     */
    public function getVillagesByDistrict(int $districtId): Collection
    {
        return Village::where('district_id', $districtId)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get Kelurahan di Kota Makassar
     */
    public function getVillagesInMakassar(): Collection
    {
        $districts = $this->getDistrictsInMakassar();

        if ($districts->isEmpty()) {
            return collect();
        }

        return Village::whereIn('district_id', $districts->pluck('id'))
            ->orderBy('name')
            ->get();
    }

    /**
     * Check if a district is in Makassar
     */
    public function isDistrictInMakassar(int $districtId): bool
    {
        $city = $this->getCityMakassar();

        if (! $city) {
            return false;
        }

        return District::where('id', $districtId)
            ->where('city_id', $city->id)
            ->exists();
    }

    /**
     * Check if a village is in Makassar
     */
    public function isVillageInMakassar(int $villageId): bool
    {
        $districts = $this->getDistrictsInMakassar();

        if ($districts->isEmpty()) {
            return false;
        }

        return Village::where('id', $villageId)
            ->whereIn('district_id', $districts->pluck('id'))
            ->exists();
    }

    /**
     * Get location IDs for Admin TPA restriction
     * Returns array with province_id, city_id
     */
    public function getAdminTpaLocationIds(): array
    {
        $province = $this->getProvinceSulsel();
        $city = $this->getCityMakassar();

        return [
            'province_id' => $province?->id,
            'city_id' => $city?->id,
        ];
    }

    /**
     * Get districts as options for form select
     */
    public function getDistrictOptions(): array
    {
        return $this->getDistrictsInMakassar()
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Get villages as options for form select by district
     */
    public function getVillageOptions(int $districtId): array
    {
        return $this->getVillagesByDistrict($districtId)
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Validate location for Admin TPA input
     * Admin TPA hanya boleh input di Sulsel, Makassar
     */
    public function validateAdminTpaLocation(int $villageId): bool
    {
        return $this->isVillageInMakassar($villageId);
    }
}
