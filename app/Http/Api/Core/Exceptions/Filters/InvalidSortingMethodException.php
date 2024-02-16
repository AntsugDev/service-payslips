<?php namespace App\Http\Api\Core\Exceptions\Filters;


use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class InvalidSortingMethodException extends BadRequestException {

    public function __construct($sorting_value, $allowed, $code = 0) {
        $allowed = implode(", ", array_map(function ($v) {
            return "'${v}'";
        }, $allowed));
        parent::__construct(
            __("exceptions.Core.InvalidSortingMethodException", ["sorting_value" => $sorting_value, "allowed" => $allowed])
        );
    }

}
