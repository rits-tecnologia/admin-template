<?php

namespace Rits\AdminTemplate\Concerns;

use Illuminate\Http\Request;

trait HasForm
{
    /**
     * Returns the request that should be used to validate.
     *
     * @return Request
     */
    protected function formRequest()
    {
        return request();
    }

    /**
     * Attributes to fill on model.
     *
     * @return array
     */
    public function formParams()
    {
        return [];
    }
}
