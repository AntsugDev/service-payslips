<?php

namespace App\Http\Api\PassSave\Request;

use App\Models\PassSave\PassCategory;
use App\Models\PassSave\PassGroups;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PassGroupsRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): ValidationException
    {
        throw new ValidationException($validator);
    }

    public function authorize(): bool
    {
        return true;
    }


    public function verify():bool{
        return PassGroups::where('name',request()->input('name'))->where('user_id',request()->user()->uuid)->count() === 0;
    }


    public function attributes(): array
    {
        return ["name" => "Nome categoria"];
    }

    public function rules(): array
    {
        return ["name" => ["required","string"]];
    }

    public function messages(): array
    {
        return ["name.required" => "campo obbligatorio"];
    }

}
