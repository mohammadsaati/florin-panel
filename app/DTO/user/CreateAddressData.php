<?php

namespace App\DTO\user;

class CreateAddressData
{
    public function __construct(
        public readonly int $province_id,
        public readonly int $city_id,
        public readonly string $address,
        public readonly ?string $postal_code,
    ) {}
}
