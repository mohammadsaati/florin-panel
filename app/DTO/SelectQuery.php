<?php

namespace App\DTO;

/**
 * What the component sends to the data source on every fetch.
 *
 * @property SelectFilter[] $filters
 */
final readonly class SelectQuery
{
    /**
     * @param SelectFilter[] $filters
     */
    public function __construct(
        public string $search,
        public int    $page,
        public int    $perPage,
        public array  $filters,
    ) {}
}
