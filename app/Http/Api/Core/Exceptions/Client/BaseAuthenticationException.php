<?php

namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

class BaseAuthenticationException extends BaseException {

    /**
     * 401 Unauthenticated
     * @param string $message
     * @param null $previous
     */
    public function __construct($message = null, $previous = null) {
        parent::__construct($message ?? "Unauthenticated", 401, $previous);
    }
}
