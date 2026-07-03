<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Services\Contracts\CityServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProvinceController extends Controller
{
    public function __construct(
        private readonly CityServiceInterface $cityService,
    ) {}

    public function create(): View
    {
        return view('admin.provinces.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:provinces,name'],
        ]);

        $this->cityService->createProvince($data);

        return redirect()->route('cities.index')
            ->with('success', 'استان با موفقیت ایجاد شد.');
    }

    public function edit(Province $province): View
    {
        return view('admin.provinces.edit', compact('province'));
    }

    public function update(Request $request, Province $province): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:provinces,name,' . $province->id],
        ]);

        $this->cityService->updateProvince($province, $data);

        return redirect()->route('cities.index')
            ->with('success', 'استان با موفقیت ویرایش شد.');
    }

    public function delete(Province $province): RedirectResponse
    {
        $this->cityService->deleteProvince($province);

        return redirect()->route('cities.index')
            ->with('success', 'استان با موفقیت حذف شد.');
    }
}
