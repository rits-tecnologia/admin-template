<?php

namespace Rits\AdminTemplate\Http\Controllers\Concerns;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\View\View;

trait Reorderable
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     * @throws AuthorizationException
     */
    public function reorder(Request $request)
    {
        $this->authorize('list', $this->resourceType);

        $this->addBreadcrumb($this->instance, 'reorder');

        if ($request->isMethod('post')) {
            $saved = $this->getRepository()->doReorder(
                $request->input('id'),
                $request->input('order')
            );

            return $saved
                ? ['message' => crudAction($this->resourceType, 'success.reordered'), 'type' => 'success']
                : ['message' => crudAction($this->resourceType, 'failed.reordered'), 'type' => 'error'];
        }

        $resources = $this->getRepository()->reorder();

        return $this->view('reorder')
            ->with('type', $this->resourceType)
            ->with('instance', $this->instance)
            ->with('resources', $resources);
    }
}
