<?php

namespace App\Http\Api\Core\Exceptions\Client;

use App\Http\Api\Core\Exceptions\BaseException;

/**
 * @OA\Response(
 *      response="418",
 *      description="I'm a teapot",
 *      @OA\JsonContent(
 *          @OA\Property(
 *              property = "errors",
 *              type = "array",
 *              @OA\Items(ref="#/components/schemas/Error")
 *          ),
 *      ),
 * )
 */
class RFC2324Exception extends BaseException {
    /**
     * 418 I'm a teapot (RFC 2324)
     *
     * This code was defined in 1998 as one of the traditional IETF April Fools' jokes, in RFC 2324,
     * Hyper Text Coffee Pot Control Protocol, and is not expected to be implemented by actual HTTP servers.
     * However, known implementations do exist.
     *
     * An Nginx HTTP server uses this code to simulate goto-like behaviour in its configuration.
     */

    protected $code = 418;

    protected $message = "I'm a Teapot!";

}
