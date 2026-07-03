<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[Fillable(['name'])]
class Province extends Model
{
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public static function listPaginated(int $perPage = 15, string $pageName = 'provinces_page'): LengthAwarePaginator
    {
        return static::withCount('cities')
            ->orderBy('name')
            ->paginate($perPage, pageName: $pageName);
    }

    public static function listForSelect(): Collection
    {
        return static::orderBy('name')->pluck('name', 'id');
    }
}
