<?php

namespace App\Http\Api\Core\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Api\Core\Filters\QueryFilters;
use App\Http\Api\Core\Exceptions\Client\BadRequestException;

/**
 * Trait Filterable
 * @package App\Http\Api\Core\Filters
 *
 * @method Builder filter(QueryFilters $query_filter);
 */
trait Filterable {

    /**
     * @param Builder      $query
     * @param QueryFilters $query_filter
     *
     * @return Builder
     * @throws BadRequestException
     */
    public function scopeFilter(Builder $query, QueryFilters $query_filter){
        return $query_filter->apply($query);
    }

}
