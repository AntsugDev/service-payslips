<?php

namespace App\Http\Api\Users\Filter;

use App\Http\Api\Core\Filters\QueryFilters;

class UserFilter extends QueryFilters
{

    /**
     * @inheritDoc
     */
    public function allowed_filters(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function allowed_sorts(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function allowed_includes(): array
    {
        return ['company'];
    }
}
