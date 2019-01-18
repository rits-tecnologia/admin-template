<?php

namespace Rits\AdminTemplate\Support\Eloquent\Concerns;

use Illuminate\Routing\RouteCollection;
use Route;

trait HasRoutes
{
    /**
     * Default format for the resource routes. The
     * following replacements are made:
     *
     *  1. {action}: the current controller action;
     *  2. {table}: the resource table name
     *
     * @var string
     */
    protected $routeFormat = 'web.{table}.{action}';

    /**
     * Get route by action.
     *
     * @param string $action
     * @param array $parameters
     * @return string
     */
    public function route($action, $parameters = [])
    {
        $name = $this->routeName($action);

        /** @var RouteCollection $routes */
        $routes = app('router')->getRoutes();

        if ($route = $routes->getByName($name)) {
            if (array_search($this->getRouteKeyName(), $route->parameterNames()) !== false) {
                $parameters[$this->getRouteKeyName()] = $this->getRouteKey();
            }
        }

        return route($name, $parameters);
    }

    /**
     * Check for route existence.
     *
     * @param string $action
     * @return bool
     */
    public function hasRoute($action)
    {
        $name = $this->routeName($action);

        return Route::has($name);
    }

    /**
     * Get route name by action.
     *
     * @param string $action
     * @return mixed
     */
    protected function routeName($action)
    {
        $name = str_replace(
            ['{action}', '{table}'],
            [$action, $this->getTable()],
            $this->routeFormat
        );

        return $name;
    }
}
