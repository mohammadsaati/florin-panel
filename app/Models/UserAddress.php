<?php

namespace App\Models;

use App\DTO\user\CreateAddressData;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $guarded = ['id'];

    public static function createForUser(int $userId, CreateAddressData $data): self
    {
        return self::create([
            'user_id'     => $userId,
            'province_id' => $data->province_id,
            'city_id'     => $data->city_id,
            'address'     => $data->address,
            'postal_code' => $data->postal_code,
        ]);
    }
}
