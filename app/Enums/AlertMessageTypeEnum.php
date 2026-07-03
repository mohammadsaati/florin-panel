<?php

namespace App\Enums;

enum AlertMessageTypeEnum: string
{
    use ValuesTrait, LabelTrait;

    case ERROR = 'error';
    case WARNING = 'warning';
    case SUCCESS = 'success';
    case INFO = 'info';
    case DANGER = 'danger';

}
