<?php

namespace App\DTO;

/**
 * What the data source must return.
 *
 * @property SelectOption[] $items
 */
final readonly class SelectResult
{
    /**
     * @param SelectOption[] $items
     */
    public function __construct(
        public array $items,
        public bool  $hasMore,
    ) {}

    /** @return array<int, array{value: string, label: string}> */
    public function toArray(): array
    {
        return array_map(fn (SelectOption $o) => $o->toArray(), $this->items);
    }
}
