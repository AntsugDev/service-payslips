<?php

namespace App\Http\Api\Users\Requests;

use App\Models\Compaineis;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserRequestCreateChild extends FormRequest
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
            "code_user" => "Codice utente ",
            "name" => "Anagrafica utente ",
        ];
    }

    public function uniqueCodeUser():bool
    {
        $codeUser = request()->input('code_user');
        return User::where('code_user',$codeUser)->count() === 0;
    }



    public function rules(): array
    {
        return [
            "email" => ['required','email'],
            "code_user" => ['required','string','min:10','max:17','regex:/[A-Za-z0-9]/'],
            "name" => ['required','string'],
        ];
    }

    public function messages() :array
    {
        return [
            "email.required" => "campo obbligatorio",
            "code_user.required" => "campo obbligatorio",
            "code_user.min" => "La stringa deve essere superiore a 10 caratteri",
            "code_user.max" => "La stringa deve essere inferiore o uguale a 17 caratteri",
            "code_user.regex" => "La stringa non corrisponde a quella desiderata",
            "name.required" => "campo obbligatorio",
            "email.email" => "Email non valida",
        ];
    }
}
