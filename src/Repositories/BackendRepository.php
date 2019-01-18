<?php

namespace Rits\AdminTemplate\Repositories;

use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rits\AdminTemplate\Concerns\HasModel;
use Rits\AdminTemplate\Support\Eloquent\Model;

class BackendRepository
{
    use HasModel;

    /**
     * BackendRepository constructor.
     *
     * @param string $resourceType
     */
    public function __construct($resourceType = null)
    {
        $this->resourceType = $resourceType;
    }

    /**
     * Display a listing of the resource.
     *
     * @param array $search
     * @param array $order
     * @return Collection|Model[]
     */
    public function index($search, $order)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->newQuery()
            ->select($this->indexColumns())
            ->filter([$this, 'indexFilter'])
            ->search($search)
            ->order($order)
            ->paginate()
            ->appends(['q' => $search, 'order' => $order]);
    }

    /**
     * Columns to optimize index query.
     *
     * @return string|array
     */
    public function indexColumns()
    {
        return '*';
    }

    /**
     * Filter to optimize index query.
     *
     * @param Builder $query
     * @return Builder
     */
    public function indexFilter($query)
    {
        return $query;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Model
     */
    public function find($id)
    {
        $query = $this->newQuery();

        /** @var Builder $query */
        /** @noinspection PhpUndefinedMethodInspection */
        $query = method_exists($this->getInstance(), 'getDeletedAtColumn')
            ? $query->withTrashed() : $query;

        /** @noinspection PhpUndefinedMethodInspection */
        return $query
            ->select($this->findColumns())
            ->filter([$this, 'findFilter'])
            ->findOrFail($id);
    }

    /**
     * Columns to optimize find query.
     *
     * @return string|array
     */
    public function findColumns()
    {
        return '*';
    }

    /**
     * Filter to optimize find query.
     *
     * @param Builder $query
     * @return Builder
     */
    public function findFilter($query)
    {
        return $query;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $attributes
     * @return Model
     */
    public function create($attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $attributes = $this->createAttributes($attributes);

            /** @var Model $resource */
            $resource = $this->build($attributes, true);
            $resource->save();

            return $this->storeHook($resource);
        });
    }

    /**
     * Handles create action attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function createAttributes($attributes)
    {
        return $attributes;
    }

    /**
     * Handles model after store.
     *
     * @param Model $resource
     * @return Model
     */
    public function storeHook($resource)
    {
        return $resource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Model $resource
     * @param array $attributes
     * @return Model
     */
    public function update($resource, $attributes)
    {
        return DB::transaction(function () use ($resource, $attributes) {
            $attributes = $this->updateAttributes($attributes);

            /** @var Model $resource */
            $resource = $this->fill($resource, $attributes, true);
            $resource->save();

            return $this->updateHook($resource);
        });
    }

    /**
     * Handles update action attributes.
     *
     * @param array $attributes
     * @return array
     */
    public function updateAttributes($attributes)
    {
        return $attributes;
    }

    /**
     * Handles model after update.
     *
     * @param Model $resource
     * @return Model
     */
    public function updateHook($resource)
    {
        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Model $resource
     * @return Model
     */
    public function delete($resource)
    {
        return DB::transaction(function () use ($resource) {
            $resource = $this->deleteBefore($resource);

            $resource->delete();

            return $this->deleteAfter($resource);
        });
    }

    /**
     * Handles model before delete.
     *
     * @param Model $resource
     * @return Model
     */
    public function deleteBefore($resource)
    {
        return $resource;
    }

    /**
     * Handles model after delete.
     *
     * @param Model $resource
     * @return Model
     */
    public function deleteAfter($resource)
    {
        return $resource;
    }
}
