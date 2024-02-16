<?php namespace App\Http\Api\Core\Exceptions\Filters;


use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class InvalidArrayValueForFilterException extends BadRequestException {

    public function __construct($filter, $value) {
        parent::__construct(__("exceptions.Core.InvalidArrayValueForFilterException", ["value" => $value, "filter" => $filter]));
    }

}
