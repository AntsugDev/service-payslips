<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="400",
 *      description="Bad Request: The request could not be understood by the server due to malformed syntax. The client SHOULD NOT repeat the request without modifications",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class BadRequestException extends BaseException {

    /**
     * 400 Bad Request
     *
     * The request could not be understood by the server due to malformed syntax.
     * The client SHOULD NOT repeat the request without modifications.
     * @param string $message
     * @param null $previous
     */

    public function __construct($message = null, $previous = null) {
        parent::__construct($message ?? __("exceptions.Core.BadRequestException"), 400, $previous);
    }

}
