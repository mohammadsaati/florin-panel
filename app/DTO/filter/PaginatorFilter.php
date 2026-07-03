<?php

namespace App\DTO\filter;

class PaginatorFilter
{
    /**
     * @var int[]
     */
    private const ALLOWED_PER_PAGE_ITEMS = [10, 15, 20, 25, 50, 100, 300, 500];

    /**
     * @example default is 1
     */
    public int $page;

    /**
     * @example default is 15
     */
    public int $per_page;

    /**
     * Column name for ordering (DB column). Empty means no sort.
     */
    public string $sort_column;

    /**
     * 'asc' or 'desc'
     */
    public string $sort_direction;

    /** null = no tenant scoping (super admin); int = scope to this owner */
    public ?int $ownerId;

    public function __construct(
        int|null $page = null,
        int|null $per_page = null,
        string|null $sort_column = null,
        string|null $sort_direction = null,
        int|null $ownerId = null,
    ) {
        if (is_null($page) || $page === 0) {
            $page = 1;
        }
        if (is_null($per_page) || $per_page === 0) {
            $per_page = 20;
        }

        if (!in_array($per_page, self::ALLOWED_PER_PAGE_ITEMS, true)) {
            $per_page = 10;
        }

        $this->page = $page;
        $this->per_page = $per_page;
        $this->sort_column    = $sort_column ?? '';
        $this->sort_direction = in_array($sort_direction ?? '', ['asc', 'desc'], true) ? $sort_direction : 'asc';
        $this->ownerId        = $ownerId;
    }
}
