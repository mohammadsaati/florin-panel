<?php

namespace App\DTO\filter;

class UserFilterData extends PaginatorFilter
{
    public function __construct(
        public string|null $search = '',
        public string|null $referralCode = '',
        public int $user_id = 0,
        public string|null $invited_by = '',
        int|null $page = null,
        int|null $per_page = null,
        string|null $sort_column = null,
        string|null $sort_direction = null,
        int|null $ownerId = null
    )
    {
        parent::__construct($page, $per_page, $sort_column, $sort_direction, $ownerId);
    }
}
