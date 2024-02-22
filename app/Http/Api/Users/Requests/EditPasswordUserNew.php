<?php

namespace App\Http\Api\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class EditPasswordUserNew extends FormRequest
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
            "password" => "Nuova Password ",
            "update" => "Aggiornare campo change password"
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
            "password" => ['required','string','regex:/^[A-Za-z0-9_*@!$&.]\w+/','min:10', 'max:15'],
            "update" => ['bool']
        ];
    }



    public function messages()
    {
        return [
            "password.required" => "Campo Obbligatorio",
            "password.regex" => "La stringa non corrisponde a quella desiderata",
            "password.max" => "La stringa deve essere inferiore a 15 caratteri",
            "password.min" => "La stringa deve essere superiore a 10 caratteri"
        ];
    }
}
