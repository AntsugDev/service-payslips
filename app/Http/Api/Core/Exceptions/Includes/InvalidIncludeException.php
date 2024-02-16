<?php namespace App\Http\Api\Core\Exceptions\Includes;

use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class InvalidIncludeException extends BadRequestException {

    public function __construct($include, $allowed) {
        $allowed = implode(", ", array_map(function ($v) {
            return "'${v}'";
        }, $allowed));
        parent::__construct(__("exceptions.Core.InvalidIncludeException", ["include" => $include, "allowed" => $allowed]));
    }

}
