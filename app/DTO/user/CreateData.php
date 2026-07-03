<?php

namespace App\DTO\user;

use App\Enums\UserGenderEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Http\Requests\User\CreateRequest;
use Carbon\Carbon;

class CreateData
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $mobile,
        public readonly Carbon|null $birth_date,
        public readonly UserGenderEnum $gender,
        public readonly int|null $age,
        public readonly string|null $referral_code,
        public readonly string|null $invited_by,
        public readonly UserTypeEnum $type,
        public readonly UserStatusEnum $status,
        public readonly string|null $password,
        public readonly CreateAddressData|null$address,
    ) {}

    public static function fromRequest(CreateRequest $request): self
    {
        $address = null;
        if ($request->filled('address.province_id')) {
            $address = new CreateAddressData(
                province_id: (int) $request->string('address.province_id')->value(),
                city_id:     (int) $request->string('address.city_id')->value(),
                address:     $request->string('address.address')->value(),
                postal_code: $request->string('address.postal_code')->value(),
            );
        }

        return new self(
            first_name:    $request->string('first_name')->value(),
            last_name:     $request->string('last_name')->value(),
            mobile:        $request->string('mobile')->value(),
            birth_date:    $request->jDateToCarbon('birth_date'),
            gender:        UserGenderEnum::from($request->input('gender')),
            age:           $request->integer('age') ?: null,
            referral_code: $request->string('referral_code')->value(),
            invited_by:    $request->string('invited_by')->value(),
            type:          $request->enum('type', UserTypeEnum::class),
            status:        $request->enum('status', UserStatusEnum::class, UserStatusEnum::ACTIVE),
            password:      $request->string('password')->value(),
            address:       $address,
        );
    }
}
