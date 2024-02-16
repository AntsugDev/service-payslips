<?php namespace App\Http\Api\Core\Exceptions\Filters;

use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class InvalidFilterException extends BadRequestException {

    public function __construct($filter, $allowed) {
        $allowed = implode(", ", array_map(function ($v) {
            return "'${v}'";
        }, $allowed));
        parent::__construct(__("exceptions.Core.InvalidFilterException", ["filter" => $filter, "allowed" => $allowed]));
    }

}
