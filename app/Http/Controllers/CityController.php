<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Services\Contracts\CityServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    public function __construct(
        private readonly CityServiceInterface $cityService,
    ) {}

    public function index(): View
    {
        $cities    = $this->cityService->getCitiesPaginated(15);
        $provinces = $this->cityService->getProvincesPaginated(15);

        return view('admin.cities.index', compact('cities', 'provinces'));
    }

    public function create(): View
    {
        $provinces = $this->cityService->getProvincesForSelect();

        return view('admin.cities.create', compact('provinces'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'province_id' => ['required', 'exists:provinces,id'],
        ]);

        $this->cityService->createCity($data);

        return redirect()->route('cities.index')
            ->with('success', 'شهر با موفقیت ایجاد شد.');
    }

    public function edit(City $city): View
    {
        $provinces = $this->cityService->getProvincesForSelect();

        return view('admin.cities.edit', compact('city', 'provinces'));
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'province_id' => ['required', 'exists:provinces,id'],
        ]);

        $this->cityService->updateCity($city, $data);

        return redirect()->route('cities.index')
            ->with('success', 'شهر با موفقیت ویرایش شد.');
    }

    public function delete(City $city): RedirectResponse
    {
        $this->cityService->deleteCity($city);

        return redirect()->route('cities.index')
            ->with('success', 'شهر با موفقیت حذف شد.');
    }

    public function byProvince(Province $province): JsonResponse
    {
        return response()->json(
            $province->cities()->orderBy('name')->get(['id', 'name'])
        );
    }
}
