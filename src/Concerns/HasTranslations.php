<?php

namespace Rits\AdminTemplate\Concerns;

trait HasTranslations
{
    /**
     * Get translation by key.
     *
     * @param string $key
     * @return string
     */
    public function trans($key)
    {
        return __t(
            'admin-template::terms.actions.' . get_class($this) . '.' . $key,
            'admin-template::terms.actions.resource.' . $key
        );
    }
}
