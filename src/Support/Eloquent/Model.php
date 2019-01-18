<?php

namespace Rits\AdminTemplate\Support\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Rits\AdminTemplate\Concerns\HasTranslations;
use Rits\AdminTemplate\Support\Eloquent\Concerns\Filterable;
use Rits\AdminTemplate\Support\Eloquent\Concerns\HasColumns;
use Rits\AdminTemplate\Support\Eloquent\Concerns\HasRoutes;
use Rits\AdminTemplate\Support\Eloquent\Concerns\Orderable;
use Rits\AdminTemplate\Support\Eloquent\Concerns\Searchable;
use Rits\AdminTemplate\Support\Eloquent\Contracts\TableContract;

abstract class Model extends Eloquent implements TableContract
{
    use Filterable,
        HasColumns,
        HasRoutes,
        HasTranslations,
        Orderable,
        Searchable;
}
