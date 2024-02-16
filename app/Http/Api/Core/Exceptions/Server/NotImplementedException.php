<?php

namespace App\Http\Api\Core\Exceptions\Server;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="501",
 *      description="Not Implemented: the server does not support the functionality required to fulfill the request.",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class NotImplementedException extends BaseException {

    /**
     * The server does not support the functionality required to fulfill the request.
     * This is the appropriate response when the server does not recognize the request method and is not capable of
     * supporting it for any resource.
     *
     */
    protected $code = 501;

    public function __construct()
    {
        Parent::__construct(
            __("exceptions.Core.NotImplementedException"),
            $this->code,
            $previous =null
        );
    }

}
