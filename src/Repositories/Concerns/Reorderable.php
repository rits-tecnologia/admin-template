<?php

namespace Rits\AdminTemplate\Repositories\Concerns;

use DB;
use Illuminate\Support\Collection;
use Rits\AdminTemplate\Support\Eloquent\Model;

trait Reorderable
{
    /**
     * Display a listing of all resources published.
     *
     * @return Collection|Model[]
     */
    public function reorder()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->newQuery()
            ->orderBy('order')
            ->get();
    }

    /**
     * Reorder items.
     *
     * @return Collection|Model[]
     */
    public function doReorder($id, $order)
    {
        $order++; // order starts at 1

        try {
            DB::beginTransaction();

            $item = $this->newQuery()->find($id);
            $items = [];

            if ($order > $item->order) {
                $operation = -1;
                $items = $this->newQuery()
                    ->where('order', '>', $item->order)
                    ->where('order', '<=', $order)
                    ->get();
            } elseif ($order < $item->order) {
                $operation = 1;
                $items = $this->newQuery()
                    ->where('order', '<', $item->order)
                    ->where('order', '>=', $order)
                    ->get();
            }

            $item->order = $order;
            $item->save();

            foreach ($items as $item) {
                $item->order = $item->order + $operation;
                $item->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return false;
        }

        return true;
    }
}
