<?php

namespace App\Http\Api\Compaines\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CompaniesCreateRequest extends FormRequest
{

    protected function failedValidation(Validator $validator): ValidationException
    {
        throw new ValidationException($validator);
    }

    public function authorize(): bool
    {
        return true;
    }


    public function attributes():array
    {
        return [
            "name" => "Nome company ",
            "city" => "Città ",
            "address" => "Indirizzo ",
            "email" => "Email ",
            "phone" => "Telefono ",
            "code_user" => "Codice Utente "
        ];
    }


    public function rule():array
    {
        return [
            "name" => ["required","string"],
            "city" => ["required","string"],
            "address" => ["required","string"],
            "email" => ["required","email"],
            "phone" => ["required"],
            "code_user" => ['required','string','min:10','max:17','regex:/[A-Za-z0-9]/'],
        ];
    }


    public function messages():array
    {
        return [
            "name.required" => "campo obbligatorio",
            "city.required" => "campo obbligatorio",
            "address.required" => "campo obbligatorio",
            "email.required" => "campo obbligatorio",
            "email.email" => "Email non valida",
            "phone.required" => "campo obbligatorio",
            "code_user.required" => "campo obbligatorio",
            "code_user.min" => "La stringa deve essere superiore a 10 caratteri",
            "code_user.max" => "La stringa deve essere inferiore o uguale a 17 caratteri",
            "code_user.regex" => "La stringa non corrisponde a quella desiderata",
        ];
    }
}
