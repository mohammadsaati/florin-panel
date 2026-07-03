<?php

namespace App\Livewire\Admin;

use App\Models\City;
use App\Models\Province;
use Livewire\Attributes\On;
use Livewire\Component;

class UserAddressForm extends Component
{
    public ?string $provinceId = null;

    public function mount(): void
    {
        $this->provinceId = old('address.province_id');
    }

    #[On('selectChanged')]
    public function onSelectChanged(string $name, array $selected): void
    {
        if ($name === 'address[province_id]') {
            $this->provinceId = $selected[0] ?? null;
        }
    }

    public function render()
    {
        $provinces = Province::orderBy('name')
            ->get()
            ->map(fn ($p) => ['value' => (string) $p->id, 'label' => $p->name])
            ->toArray();

        $cities = $this->provinceId
            ? City::where('province_id', $this->provinceId)
                ->orderBy('name')
                ->get()
                ->map(fn ($c) => ['value' => (string) $c->id, 'label' => $c->name])
                ->toArray()
            : [];

        return view('livewire.admin.user-address-form', compact('provinces', 'cities'));
    }
}
