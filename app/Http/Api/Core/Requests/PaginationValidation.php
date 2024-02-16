<?php

namespace App\Http\Api\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginationValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "orderBy" => ["alpha_dash", "max:25"],
            "order" => ["required"],
            "size" => ["required", "numeric", "gt:0"],
            "page" => ["nullable", "numeric", "gt:0"]
        ];
    }
}
