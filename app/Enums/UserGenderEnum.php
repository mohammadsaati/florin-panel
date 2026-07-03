<?php

namespace App\Enums;

enum UserGenderEnum: string
{
    use ValuesTrait, LabelTrait;

    case MALE = 'male';

    case FEMALE = 'female';
}
