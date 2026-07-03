<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'province_id'])]
class City extends Model
{
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public static function listPaginated(int $perPage = 15, string $pageName = 'cities_page'): LengthAwarePaginator
    {
        return static::with('province')
            ->orderBy('name')
            ->paginate($perPage, pageName: $pageName);
    }
}
