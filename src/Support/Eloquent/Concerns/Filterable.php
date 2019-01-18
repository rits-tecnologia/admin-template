<?php

namespace Rits\AdminTemplate\Support\Eloquent\Concerns;

use Illuminate\Database\Query\Builder;

trait Filterable
{
    /**
     * Executes filter on query.
     *
     * @param Builder $query
     * @param callable $filter
     * @return Builder
     */
    public function scopeFilter($query, $filter)
    {
        return call_user_func($filter, $query);
    }
}
