<?php

namespace Rits\AdminTemplate\Support\Eloquent\Concerns;

trait HasColumns
{
    /**
     * Convert date to localized format.
     *
     * @param string $attribute
     * @param bool $export
     * @return string
     */
    public function getDateAdminColumn($attribute, $export = false)
    {
        $value = $this->{$attribute};

        if (is_null($value)) {
            return '';
        }

        if (is_string($value)) {
            $value = $this->asDateTime($value);
        }

        return $value->formatLocalized(config('admin-template.app.date_format'));
    }

    /**
     * Value for an admin column.
     *
     * @param string $attribute
     * @param bool $export
     * @return string
     */
    public function getAdminColumn($attribute, $export = false)
    {
        $attribute = str_replace('.', '-', $attribute);

        $method = camel_case('get-' . $attribute . '-admin-column');

        if (method_exists($this, $method)) {
            return $this->{$method}($export);
        } elseif ($this->isDateAttribute($attribute)) {
            return $this->getDateAdminColumn($attribute, $export);
        }

        return $this->$attribute;
    }

    /**
     * If this column should expand.
     *
     * @param int $index
     * @param string $attribute
     * @return bool
     */
    public function getColumnExpand($index, $attribute)
    {
        return $index === (count($this->adminColumns()) - 1);
    }

    /**
     * If this column should expand in reorder.
     *
     * @param int $index
     * @param string $attribute
     * @return bool
     */
    public function getReorderColumnExpand($index, $attribute)
    {
        return $index === (count($this->adminColumns()) - 1);
    }
}
