<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    use ValuesTrait, LabelTrait;

    case USER = 'user';

    case ADMIN = 'admin';
}
