<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="404",
 *      description="Not Found: the server has not found anything matching the Request-URI",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class ResourceNotFoundException extends BaseException {

    /**
     * 404 Not Found
     *
     * The server has not found anything matching the Request-URI.
     * No indication is given of whether the condition is temporary or permanent.
     * The 410 (Gone) status code SHOULD be used if the server knows, through some internally configurable mechanism,
     * that an old resource is permanently unavailable and has no forwarding address.
     *
     * This status code is commonly used when the server does not wish to reveal exactly why the request has been refused,
     * or when no other response is applicable.
     * Used when the requested resource is not found, whether it doesn't exist or if there was a 401 or 403 that,
     * for security reasons, the service wants to mask.
     *
     * @param string $resource
     * @param null $previous
     */
    public function __construct($resource = "resource", $previous = null) {
        parent::__construct(
            __("exceptions.Core.ResourceNotFoundException", ["resource" => __("exceptions." . $resource)]),
            404,
            $previous
        );
    }
}
