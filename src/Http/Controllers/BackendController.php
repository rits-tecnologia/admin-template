<?php

namespace Rits\AdminTemplate\Http\Controllers;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Rits\AdminTemplate\Concerns\HasBreadcrumbs;
use Rits\AdminTemplate\Concerns\HasForm;
use Rits\AdminTemplate\Concerns\HasModel;
use Rits\AdminTemplate\Concerns\HasViews;
use Rits\AdminTemplate\Support\Eloquent\Model;

class BackendController extends Controller
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        HasBreadcrumbs,
        HasForm,
        HasModel,
        HasViews;

    /**
     * Clean instance of the resource.
     *
     * @var Model
     */
    protected $instance;

    /**
     * BackendController constructor.
     */
    public function __construct()
    {
        $this->instance = $this->getRepository()->getInstance();

        $this->addBreadcrumb($this->instance, 'index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('list', $this->resourceType);

        $search = $request->get('q');
        $order = $request->get('order');

        $resources = $this->getRepository()->index($search, $order);

        return $this->view('index')
            ->with('type', $this->resourceType)
            ->with('instance', $this->instance)
            ->with('resources', $resources);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $instance = $this->getRepository()->find($id);

        $this->addBreadcrumb($instance, 'show');
        $this->authorize('view', $instance);

        return $this->view('show')
            ->with('type', $this->resourceType)
            ->with('instance', $instance);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function new()
    {
        $this->addBreadcrumb($this->instance, 'new');
        $this->authorize('create', $this->resourceType);

        return $this->view('new')
            ->with('type', $this->resourceType)
            ->with('instance', $this->instance)
            ->with('isUpdate', false);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function create()
    {
        $this->authorize('create', $this->resourceType);

        if ($resource = $this->getRepository()->create($this->formParams())) {
            return $this->afterCreate($resource);
        }

        return $this->afterFailed('created');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $instance = $this->getRepository()->find($id);

        $this->addBreadcrumb($instance, 'edit');
        $this->authorize('update', $instance);

        return $this->view('edit')
            ->with('type', $this->resourceType)
            ->with('instance', $instance)
            ->with('isUpdate', true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function update($id)
    {
        $instance = $this->getRepository()->find($id);

        $this->authorize('update', $instance);

        if ($resource = $this->getRepository()->update($instance, $this->formParams())) {
            return $this->afterUpdate($resource);
        }

        return $this->afterFailed('updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $instance = $this->getRepository()->find($id);

        $this->authorize('delete', $instance);

        if ($success = $this->getRepository()->delete($instance)) {
            return $this->afterDelete($instance);
        }

        return $this->afterFailed('deleted');
    }

    /**
     * Validate form request for javascript.
     *
     * @return Request
     */
    public function validation()
    {
        return $this->formRequest()
            ? response()->json(['status' => 'valid'])
            : response()->json(['status' => 'invalid'], 422);
    }

    /**
     * Where to redirect after creating the resource.
     *
     * @param Model $resource
     * @return RedirectResponse
     */
    protected function afterCreate($resource)
    {
        /** @var Authorizable $user */
        $user = auth()->user();
        $route = null;

        if ($user->can('view', $resource)) {
            $route = $resource->route('show');
        } elseif ($user->can('update', $resource)) {
            $route = $resource->route('edit');
        } elseif ($user->can('list', $this->resourceType)) {
            $route = $resource->route('index');
        }

        $route = $route ? redirect()->to($route) : back();

        return $route->with(
            'success',
            crudAction($this->resourceType, 'success.created')
        );
    }

    /**
     * Where to redirect after updating resource.
     *
     * @param Model $resource
     * @return RedirectResponse
     */
    protected function afterUpdate($resource)
    {
        return back()->with(
            'success',
            crudAction($this->resourceType, 'success.updated')
        );
    }

    /**
     * Where to redirect after deleting resource.
     *
     * @param Model $resource
     * @return RedirectResponse
     */
    protected function afterDelete($resource)
    {
        return back()->with(
            'success',
            crudAction($this->resourceType, 'success.deleted')
        );
    }

    /**
     * Return with errors and message.
     *
     * @param string $action
     * @return RedirectResponse
     */
    protected function afterFailed($action)
    {
        return back()->withInput()
            ->with('warning', crudAction($this->resourceType, 'failed.' . $action));
    }
}
