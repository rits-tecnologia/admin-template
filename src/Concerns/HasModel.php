<?php

namespace Rits\AdminTemplate\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Rits\AdminTemplate\Repositories\BackendRepository;
use Rits\AdminTemplate\Support\Eloquent\Model;

trait HasModel
{
    /**
     * Type of the resource to manage.
     *
     * @var string
     */
    protected $resourceType;

    /**
     * Eloquent instance for helper methods.
     *
     * @var Model
     */
    protected $resourceInstance;

    /**
     * Type of the managing repository.
     *
     * @var string
     */
    protected $repositoryType = 'Rits\\AdminTemplate\\Repositories\\BackendRepository';

    /**
     * Get resource instance.
     *
     * @return Model
     */
    public function getInstance()
    {
        if (is_null($this->resourceInstance)) {
            $this->resourceInstance = new $this->resourceType;
        }

        return $this->resourceInstance;
    }

    /**
     * Get table name for resource type.
     *
     * @return string
     */
    protected function getTable()
    {
        return $this->getInstance()->getTable();
    }

    /**
     * Get repository instance for resource.
     *
     * @return BackendRepository
     */
    protected function getRepository()
    {
        return new $this->repositoryType($this->resourceType);
    }

    /**
     * Create a new query for the resource.
     *
     * @return Builder
     */
    protected function newQuery()
    {
        return $this->getInstance()->newQuery();
    }

    /**
     * Fills data to the resource.
     *
     * @param Model $resource
     * @param array $attributes
     * @param bool $force
     * @return Model
     */
    public function fill($resource, $attributes, $force = false)
    {
        $resource->fillable($force ? array_keys($attributes) : $resource->getFillable());
        $resource->fill($attributes);

        return $resource;
    }

    /**
     * Build a new object without saving.
     *
     * @param array $attributes
     * @param bool $force
     * @return Model
     */
    public function build($attributes, $force = false)
    {
        return $this->fill(
            $this->getInstance(),
            $attributes,
            $force
        );
    }
}
