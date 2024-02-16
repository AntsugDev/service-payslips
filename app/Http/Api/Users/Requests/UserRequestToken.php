<?php

namespace App\Http\Api\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserRequestToken extends FormRequest
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
            "password" => "Password "
        ];
    }

    public function rules(): array
    {
        return [
            "email" => ["required","email"],
            "password" => ["required","string"]
        ];
    }

    public function messages() :array
    {
        return [
            "email.required" => "campo obbligatorio",
            "password.required" => "campo obbligatorio"
        ];
    }
}
