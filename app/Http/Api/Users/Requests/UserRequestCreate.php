<?php

namespace App\Http\Api\Users\Requests;

use App\Models\Compaineis;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserRequestCreate extends FormRequest
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
            "password" => "Password ",
            "company_id" => "Azienda ",
        ];
    }

    public function uniqueCodeUser():bool
    {
        $codeUser = request()->input('code_user');
        return User::where('code_user',$codeUser)->count() === 0;
    }

    public function existCompanies():bool
    {
        $companyId = request()->input('company_id');
        return Compaineis::where('uuid',$companyId)->count() ===1;
    }


    public function rules(): array
    {
        return [
            "email" => ['required','email'],
            "code_user" => ['required','string','min:10','max:17','regex:/[A-Za-z0-9]/'],
            "name" => ['required','string'],
            "password" => ['required','string','regex:/[A-Za-z0-9][_*@!$&.]{1}/','min:10', 'max:15'],
            "company_id" => ['required','string'],
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
            "password.required" => "campo obbligatorio",
            "password.regex" => "La stringa non corrisponde a quella desiderata(può contenere caratteri conpmresi tra A e Z o a e z e numeri tra 0 e 9; inoltre deve contenere un carattere speciale tra i seguenti, come ultimo carattere:_*@!$&. )",
            "password.max" => "La stringa deve essere inferiore a 15 caratteri",
            "password.min" => "La stringa deve essere superiore a 10 caratteri",
            "company_id.required" => "campo obbligatorio",
            "email.email" => "Email non valida",
        ];
    }
}
