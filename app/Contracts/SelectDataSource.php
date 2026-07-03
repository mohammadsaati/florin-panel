<?php

namespace App\Contracts;

use App\DTO\SelectQuery;
use App\DTO\SelectResult;

interface SelectDataSource
{
    /**
     * Fetch a page of options for the select component.
     *
     * The implementation decides the data source — Eloquent, external API,
     * cache, static list, etc. The component never knows the difference.
     *
     * Example implementations:
     *   - extend EloquentSelectDataSource for DB-backed selects
     *   - implement directly for API-backed or computed selects
     */
    public function __invoke(SelectQuery $query): SelectResult;
}
