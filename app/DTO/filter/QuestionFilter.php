<?php

namespace App\DTO\filter;

class QuestionFilter extends PaginatorFilter
{
    public function __construct(
        int|null $page = null,
        int|null $per_page = null,
        string|null $sort_column = null,
        string|null $sort_direction = null,
        int|null $ownerId = null,
    )
    {
        parent::__construct($page, $per_page, $sort_column, $sort_direction, $ownerId);
    }
}
