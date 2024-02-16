<?php

namespace App\Http\Api\Core\Exceptions\Server;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="500",
 *      description="Internal Server Error: The server encountered an unexpected condition which prevented it from fulfilling the request.",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class InternalServerErrorException extends BaseException {

    /**
     * The server encountered an unexpected condition which prevented it from fulfilling the request.
     * A generic error message, given when no more specific message is suitable.
     */

    protected $code = 500;


    public function __construct()
    {
        Parent::__construct(
            __("exceptions.Core.InternalServerErrorException"),
            $this->code,
            $previous =null
        );
    }

}
