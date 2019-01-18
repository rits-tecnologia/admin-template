<?php

namespace Rits\AdminTemplate\Support\Eloquent\Concerns;

use Illuminate\Database\Query\Builder;

trait Reorderable
{
    /**
     * List of headers for the admin reordering table.
     *
     * @return array
     */
    public function adminReorderColumns()
    {
        return array_filter($this->adminColumns(), function ($item) {
            return $item !== 'order';
        });
    }
}
