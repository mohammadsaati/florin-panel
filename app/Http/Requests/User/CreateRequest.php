<?php

namespace App\Http\Requests\User;

use App\Enums\UserGenderEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'mobile'        => 'required|string|unique:users,mobile',
            'birth_date'    => 'required|string',
            'gender'        => 'required|in:' . UserGenderEnum::valuesAsString(),
            'age'           => 'nullable|integer|min:0',
            'invited_by'    => 'nullable|string|exists:users,referral_code',
            'referral_code' => 'nullable|string|max:255',
            'type'          => 'nullable|in:' . UserTypeEnum::valuesAsString(),
            'status'        => 'nullable|in:' . UserStatusEnum::valuesAsString(),
            'password'               => 'nullable|string|min:8',

            'address'                => 'nullable|array',
            'address.province_id'    => 'nullable|required_with:address.city_id|exists:provinces,id',
            'address.city_id'        => 'nullable|required_with:address.province_id|exists:cities,id',
            'address.address'        => 'nullable|required_with:address.province_id|string|max:500',
            'address.postal_code'    => 'nullable|digits:10',
        ];
    }
}
