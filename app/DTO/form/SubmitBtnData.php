<?php

namespace App\DTO\form;

class SubmitBtnData
{
    public function __construct(
        public string $title,
        public string $type = 'primary',
        public bool $disabled = false,
        public string $to = '',
    ) {
    }

    public static function create(
        string $title,
        string $type = 'primary',
        bool $disabled = false,
        string $to = '',
    ): SubmitBtnData {
        return new self($title, $type, $disabled, $to);
    }
}
