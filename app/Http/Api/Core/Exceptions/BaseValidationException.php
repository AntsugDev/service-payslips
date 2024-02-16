<?php

namespace App\Http\Api\Core\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseValidationException extends ValidationException {

    protected $code = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * Render the exception into an HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function render($request)
    {
        $errors = [];
        $message_bag = $this->validator->getMessageBag();
        foreach ($message_bag->keys() as $field) {
            $field_errors = $message_bag->get($field);
            foreach ($field_errors as $field_error)
                array_push(
                    $errors,
                    [
                        "status" => 422,
                        "source"  => $field,
                        "detail" => $field_error,
                    ]
                );
        }
        return new JsonResponse(["errors"=> $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

}
