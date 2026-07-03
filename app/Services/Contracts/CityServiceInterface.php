<?php

namespace App\Services\Contracts;

use App\Models\City;
use App\Models\Province;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CityServiceInterface
{
    // ── Province ──────────────────────────────────────────────────────────────

    public function getProvincesPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getProvincesForSelect(): Collection;

    public function createProvince(array $data): Province;

    public function updateProvince(Province $province, array $data): void;

    public function deleteProvince(Province $province): void;

    // ── City ──────────────────────────────────────────────────────────────────

    public function getCitiesPaginated(int $perPage = 15): LengthAwarePaginator;

    public function createCity(array $data): City;

    public function updateCity(City $city, array $data): void;

    public function deleteCity(City $city): void;
}
