<?php

namespace App\Http\Api\PassSave\Request;

use App\Models\PassSave\PassCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PassCategoryRequest extends FormRequest
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
        return PassCategory::where('name','!=',request()->input('name'))->count() === 0;
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
        return ["name.required" => "campo onnligatorio"];
    }

}
