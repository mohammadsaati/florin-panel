<?php

namespace App\DTO;

final readonly class SelectOption
{
    public function __construct(
        public string $value,
        public string $label,
    ) {}

    public function toArray(): array
    {
        return ['value' => $this->value, 'label' => $this->label];
    }

    public static function fromArray(array $data): self
    {
        return new self((string) $data['value'], (string) $data['label']);
    }
}
