<?php

namespace Database\Seeders;

use App\Enums\UserGenderEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'first_name' => 'Fatemeh',
            'last_name' => 'khodami',
            'mobile' => env('ADMIN_PHONE'),
            'birth_date' => now(),
            'referral_code' => 'ad-' . Str::random(4),
            'gender' => UserGenderEnum::FEMALE->value,
            'password' => Hash::make(env('ADMIN_PASSWORD')),
        ]);
    }
}
