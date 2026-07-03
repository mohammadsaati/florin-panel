<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    use ValuesTrait, LabelTrait;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
