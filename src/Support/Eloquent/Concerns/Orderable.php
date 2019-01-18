<?php

namespace Rits\AdminTemplate\Support\Eloquent\Concerns;

use Illuminate\Database\Query\Builder;

trait Orderable
{
    /**
     * Executes query ordering.
     *
     * @param Builder $query
     * @param array $order
     * @return Builder
     */
    public function scopeOrder($query, $order)
    {
        $orderBy = data_get($order, 'by');
        $orderDir = data_get($order, 'dir');

        if (! in_array($orderBy, $this->getOrderFields())) {
            $orderBy = $this->getOrderKey();
        }

        if (! in_array($orderDir, ['asc', 'desc'])) {
            $orderDir = $this->getOrderDir();
        }

        $query->orderBy($this->getTable().'.'.$orderBy, $orderDir);

        return $query;
    }

    /**
     * Get default order direction.
     *
     * @return string
     */
    public function getOrderDir()
    {
        return 'desc';
    }

    /**
     * Get default order key.
     *
     * @return string
     */
    public function getOrderKey()
    {
        return $this->getKeyName();
    }

    /**
     * Get available ordering fields.
     *
     * @return array
     */
    public function getOrderFields()
    {
        return [
            $this->getOrderKey() =>
                trans('validation.attributes.'.$this->getOrderKey())
        ];
    }
}
