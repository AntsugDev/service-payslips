<?php namespace App\Http\Api\Core\Exceptions\Filters;


use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class InvalidOperatorException extends BadRequestException {

    public function __construct($operator, $allowed) {
        $allowed = implode(", ", array_map(function ($v) {
            return "'${v}'";
        }, $allowed));
        parent::__construct(__("exceptions.Core.InvalidOperatorException", ["operator" => $operator, "allowed" => $allowed]));
    }

}
