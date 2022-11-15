<?php

namespace App\Traits;

use App\Filters\FilterBuilder;

trait Filterable
{
    public function scopeFilterBy($query, $filters)
    {
        $path = explode('\\', get_class($this));
        $namespace = 'App\Filters\\'.array_pop($path);
        $filter = new FilterBuilder($query, $filters, $namespace);

        return $filter->apply();
    }
}