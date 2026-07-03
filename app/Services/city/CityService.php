<?php

namespace App\Services\city;

use App\Models\City;
use App\Models\Province;
use App\Services\Contracts\CityServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CityService implements CityServiceInterface
{
    // ── Province ──────────────────────────────────────────────────────────────

    public function getProvincesPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Province::listPaginated($perPage);
    }

    public function getProvincesForSelect(): Collection
    {
        return Province::listForSelect();
    }

    public function createProvince(array $data): Province
    {
        return Province::create($data);
    }

    public function updateProvince(Province $province, array $data): void
    {
        $province->update($data);
    }

    public function deleteProvince(Province $province): void
    {
        $province->delete();
    }

    // ── City ──────────────────────────────────────────────────────────────────

    public function getCitiesPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return City::listPaginated($perPage);
    }

    public function createCity(array $data): City
    {
        return City::create($data);
    }

    public function updateCity(City $city, array $data): void
    {
        $city->update($data);
    }

    public function deleteCity(City $city): void
    {
        $city->delete();
    }
}
