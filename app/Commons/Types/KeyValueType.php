<?php

namespace App\Commons\Types;


use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @implements Arrayable<string, mixed>
 */
class KeyValueType implements Arrayable
{
    public function __construct(
        public mixed $title,
        public mixed $value,
        public mixed $other = null,
    ) {
    }

    #[ArrayShape(['title' => 'mixed', 'value' => 'mixed', 'other' => 'mixed'])]
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'value' => $this->value,
            'other' => $this->other,
        ];
    }
}
