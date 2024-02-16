<?php namespace App\Http\Api\Core\Exceptions\Fields;

use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class InvalidFieldException extends BadRequestException {

    public function __construct($field, $allowed) {
        $allowed = implode(", ", array_map(function ($v) {
            return "'${v}'";
        }, $allowed));
        parent::__construct(__("exceptions.Core.InvalidFieldException", ["field" => $field, "allowed" => $allowed]));
    }
}
