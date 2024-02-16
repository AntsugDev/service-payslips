<?php

namespace App\Http\Api\Core\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 *
 * @OA\Schema(
 *     schema = "Error",
 *     title = "Error",
 *     @OA\Property(
 *         property = "status",
 *         type = "string",
 *         example = "418"
 *     ),
 *     @OA\Property(
 *         property = "detail",
 *         type = "string",
 *         example = "I'm a Teapot!"
 *     ),
 *     @OA\Xml(
 *         name="Error"
 *     )
 * )
 *
 */
class BaseException extends Exception{

    /**
     * Render the exception into an HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function render($request)
    {
        return response()->json(
            array(
                "errors"=> array(
                    array(
                        "status" => $this->getCode(),
                        "detail" => $this->getMessage()
                    )
                ),
            ),
            $this->getCode()
        );
    }

}
