<?php namespace App\Http\Api\Core\Exceptions\Filters;


use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class InvalidOperatorForFilterException extends BadRequestException {

    public function __construct($operator, $filter, $allowed) {
        $allowed = implode(", ", array_map(function ($v) {
            return "'${v}'";
        }, $allowed));
        parent::__construct(
            __(
                "exceptions.Core.InvalidOperatorForFilterException",
                ["operator" => $operator, "filter" => $filter, "allowed" => $allowed]
            )
        );
    }

}
