<?php

namespace App\Http\Api\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class EditPasswordUser extends FormRequest
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
            "password" => "Vecchia Password ",
            "newPassword" => "Nuova Password "
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "password" => ['required','string'],
            "newPassword" => ['required','string','regex:/^[A-Za-z0-9_*@!$&.]\w+/','min:10', 'max:15']
        ];
    }



    public function messages()
    {
        return [
            "password.required" => "Campo Obbligatorio",
            "newPassword.required" => "Campo Obbligatorio",
            "newPassword.regex" => "La stringa non corrisponde a quella desiderata",
            "newPassword.max" => "La stringa deve essere inferiore a 15 caratteri",
            "newPassword.min" => "La stringa deve essere superiore a 10 caratteri"
        ];
    }
}
