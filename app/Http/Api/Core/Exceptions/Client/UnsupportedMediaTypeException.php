<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="415",
 *      description="Unsupported Media Type: The server is refusing to service the request because the entity of the request is in a format not supported by the requested resource for the requested method",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class UnsupportedMediaTypeException extends BaseException {
    /**
     * 415 Unsupported Media Type
     *
     * The server is refusing to service the request because the entity of the request is in a format not supported by
     * the requested resource for the requested method.
     *
     * The request entity has a media type which the server or resource does not support.
     * For example, the client uploads an image as image/svg+xml, but the server requires that images use a different
     * format.
     *
     * @param null $message
     * @param null $previous
     */

    public function __construct($message = null, $previous = null) {
        parent::__construct($message ?? __("exceptions.Core.UnsupportedMediaTypeException"), 415, $previous);
    }
}
