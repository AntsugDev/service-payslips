<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="401",
 *      description="Unauthorized: The request requires user authentication",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class UnauthorizedException extends BaseException {
    /**
     * 401 Unauthorized
     *
     * The request requires user authentication.
     * The response MUST include a WWW-Authenticate header field (section 14.47) containing a challenge applicable to the requested resource.
     * The client MAY repeat the request with a suitable Authorization header field (section 14.8).
     * If the request already included Authorization credentials, then the 401 response indicates that authorization
     * has been refused for those credentials.
     * If the 401 response contains the same challenge as the prior response, and the user agent has already attempted
     * authentication at least once, then the user SHOULD be presented the entity that was given in the response,
     * since that entity might include relevant diagnostic information.
     *
     * @param string $message
     * @param null $previous
     */

    public function __construct($message = null, $previous = null) {
        parent::__construct($message ?? __("exceptions.Core.UnauthorizedException"), 401, $previous);
    }
}
