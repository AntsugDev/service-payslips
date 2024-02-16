<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *    response="403",
 *    description="Forbidden: The server understood the request but is refusing to fulfill it.",
 *    @OA\JsonContent(
 *        @OA\Property(
 *            property = "errors",
 *            type = "array",
 *            @OA\Items(ref="#/components/schemas/Error")
 *        ),
 *    ),
 * )
 */
class ForbiddenException extends BaseException
{
    /**
     * 403 Forbidden
     *
     * The server understood the request, but is refusing to fulfill it.
     * Authorization will not help and the request SHOULD NOT be repeated.
     *
     * If the request method was not HEAD and the server wishes to make public why the request has not been fulfilled,
     * it SHOULD describe the reason for the refusal in the entity.
     * If the server does not wish to make this information available to the client,
     * the status code 404 (Not Found) can be used instead.
     *
     * @param string $message
     * @param null $previous
     */

    public function __construct($message = null, $previous = null) {
        parent::__construct($message ?? __("exceptions.Core.ForbiddenException"), 403, $previous);
    }
}
