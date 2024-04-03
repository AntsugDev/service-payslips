<?php

namespace App\Http\Api\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserRequestStepperOne extends FormRequest
{
    protected function failedValidation(Validator $validator): ValidationException
    {
        throw new ValidationException($validator);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes() :array
    {
        return [
            "email" => "Email ",
        ];
    }

    public function rules(): array
    {
        return [
            "email" => ["required","email"],
        ];
    }

    public function messages() :array
    {
        return [
            "email.required" => "campo obbligatorio",
            "email.email" => "Email non valida",
        ];
    }
}
