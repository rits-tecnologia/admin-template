<?php

use Illuminate\Translation\Translator;

if (! function_exists(__NAMESPACE__.'\\__t')) {
    /**
     * A different approach to the `trans` method.
     *
     * @param string $key
     * @param string $fallback
     * @param array $replace
     * @return mixed
     */
    function __t($key, $fallback, $replace = [])
    {
        /** @var Translator $translator */
        $translator = trans();

        if ($translator->has($key, null)) {
            return $translator->trans($key, $replace);
        }

        return $translator->trans($fallback, $replace);
    }
}

if (! function_exists(__NAMESPACE__.'\\crudAction')) {
    /**
     * Get some crud action by type.
     *
     * @param string $type
     * @param string $action
     * @return string
     */
    function crudAction($type, $action)
    {
        return __t(
            'admin-template::terms.actions.' . $type . '.' . $action,
            'admin-template::terms.actions.resource.' . $action
        );
    }
}

if (! function_exists(__NAMESPACE__.'\\crudColumn')) {
    /**
     * Get some crud column by type.
     *
     * @param string $type
     * @param string $field
     * @return string
     */
    function crudColumn($type, $field)
    {
        return __t(
            'validation.attributes.' . $type . '.' . $field,
            'validation.attributes.' . $field
        );
    }
}

if (! function_exists(__NAMESPACE__.'\\globals')) {
    /**
     * Alias to the registry function.
     *
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    function globals($key = null, $default = null)
    {
        return registry($key, $default);
    }
}

if (! function_exists(__NAMESPACE__.'\\registry')) {
    /**
     * Handles global variables in a controlled namespace.
     *
     * @param string|null $key
     * @param mixed|null  $default
     * @return mixed
     */
    function registry($key = null, $default = null)
    {
        if (is_string($key)) {
            $key = 'registry.'.$key;
        } elseif (is_array($key)) {
            foreach ($key as $index => $value) {
                $key['registry.'.$index] = $value;
                unset($key[$index]);
            }
        } elseif (is_null($key)) {
            $key = 'registry';
        }
        return config($key, $default);
    }
}

if (! function_exists(__NAMESPACE__.'\\title')) {
    /**
     * Builds page name.
     *
     * @param string $page
     * @param bool $reverse
     * @param string $divider
     * @return string
     */
    function title($page, $reverse = true, $divider = '|')
    {
        $page = [$page];

        if ($reverse) {
            array_push($page, config('app.name'));
        } else {
            array_unshift($page, config('app.name'));
        }

        return implode(' ' . $divider . ' ', $page);
    }
}
