<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="409",
 *      description="Conflict: The request could not be completed due to a conflict with the current state of the resource.",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class ConflictException extends BaseException {

    /**
     * 409 Conflict
     *
     * The request could not be completed due to a conflict with the current state of the resource.
     *
     * This code is only allowed in situations where it is expected that the user might be able to resolve the conflict
     * and resubmit the request.
     * The response body SHOULD include enough information for the user to recognize the source of the conflict.
     *
     * Ideally, the response entity would include enough information for the user or user agent to fix the problem;
     * however, that might not be possible and is not required.
     *
     * Conflicts are most likely to occur in response to a PUT request.
     * For example, if versioning were being used and the entity being PUT included changes to a resource which conflict
     * with those made by an earlier (third-party) request, the server might use the 409 response to indicate that it
     * can't complete the request.
     * In this case, the response entity would likely contain a list of the differences between the two versions in a
     * format defined by the response Content-Type.
     *
     *  Whenever a resource conflict would be caused by fulfilling the request.
     * Duplicate entries and deleting root objects when cascade-delete is not supported are a couple of examples.
     *
     * @param string $message
     * @param null $previous
     */

    public function __construct($message = null, $previous = null) {
        parent::__construct($message ?? __("exceptions.Core.ConflictException"), 409, $previous);
    }
}
