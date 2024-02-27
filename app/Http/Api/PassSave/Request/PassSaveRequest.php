<?php

namespace App\Http\Api\PassSave\Request;

use App\Models\PassSave\PassCategory;
use App\Models\PassSave\PassGroups;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PassSaveRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): ValidationException
    {
        throw new ValidationException($validator);
    }

    public function authorize(): bool
    {
        return true;
    }


    public function verify():bool
    {
        $idCategory = request()->input('id_category');
        $idGroups   = request()->input('id_groups');
        $category   = true;
        $groups   = true;


        if(!is_null($idCategory))
        $category = PassCategory::where('uuid',$idCategory)->count() > 0;

        if(!is_null($idGroups))
        $groups   = PassGroups::where('uuid',request()->input('id_groups'))->where('user_id',request()->user()->uuid)->count() > 0;


         if($category && $groups)
             return true;

         return false;
    }



    public function attributes(): array
    {
        return [
            "name" => "Nome",
            "id_category" => "Nome Category",
            "id_groups" => "Nome Groups",
            "json_dati" => "Dato",
            "json_dati.date_insert" => "Data inserimento",
            "json_dati.save" => "Dati da salvare"
        ];
    }

    public function rules(): array
    {
        return [
            "name" => ["required","string"],
            "id_category" => ["string","nullable"],
            "id_groups" => ["string","nullable"],
            "json_dati" => ["array"],
            "json_dati.date_insert" => ["required","string"],
            "json_dati.save" => ["required","array"],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "campo obbligatorio",
            "id_category.required" => "campo obbligatorio",
            "id_groups.required" => "campo obbligatorio",
            "json_dati.required" => "campo obbligatorio",
            "json_dati.date_insert" => "campo obbligatorio",
            "json_dati.save.required" => "campo obbligatorio",
            "json_dati.array" => "il tipo di dato non è corretto",
            "json_dati.save.array" => "il tipo di dato non è corretto"
        ];
    }

}
