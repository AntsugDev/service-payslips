<?php namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *   response="422",
 *   description="Unprocessable Entity: The syntax of the request is correct but the server was unable to process the instructions.",
 *   @OA\JsonContent(
 *       @OA\Property(
 *           property = "errors",
 *           type = "array",
 *           @OA\Items(ref="#/components/schemas/Error")
 *      ),
 *   ),
 * )
 */
class UnprocessableEntityException extends BaseException {

    /**
     * 422 Unprocessable Entity
     *
     * The server understands the content type of the request entity (hence a 415 is not appropriate) and
     * the syntax of the request is correct (hence a 400 is not appropriate).
     * However the server was not able to process the contained instructions.
     * Eg. validation errors or semantically erroneous instructions.
     *
     * @param string $message
     * @param null $previous
     */

    public function __construct($message = null, $previous = null) {
        Parent::__construct($message ?? __("exceptions.Core.UnprocessableEntityException"), 422, $previous);
    }

}
