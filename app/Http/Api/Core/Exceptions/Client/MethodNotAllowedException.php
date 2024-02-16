<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="405",
 *      description="Method Not Allowed: the method specified in the Request-Line is not allowed for the resource
 *      identified by the Request-URI",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class MethodNotAllowedException extends BaseException {

    /**
     * 405 Method Not Allowed
     *
     * The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.
     * The response MUST include an Allow header containing a list of valid methods for the requested resource.
     *
     * @param string $message
     * @param null $previous
     */
    public function __construct($message = null, $previous = null) {
        parent::__construct($message ?? __("exceptions.Core.MethodNotAllowedException"), 405, $previous);
    }

}
