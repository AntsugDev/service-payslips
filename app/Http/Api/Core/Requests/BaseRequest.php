<?php

namespace App\Http\Api\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Api\Core\Exceptions\BaseValidationException;
use App\Http\Api\Core\Exceptions\Client\BadRequestException;

class BaseRequest extends FormRequest {

    public function get_allowed_fields(){
        return array_keys($this->attributes());
    }

    public function failedValidation(Validator $validator){
        throw (new BaseValidationException($validator))->errorBag($this->errorBag);
    }

    public function validateResolved() {
        $validation_data = $this->validationData();
        $allowed = $this->get_allowed_fields();
        foreach ($validation_data as $attribute => $value){
            if(!in_array($attribute, $allowed)){
                $allowed = implode(', ', array_map(function ($v) {return "'${v}'";}, $allowed));
                throw new BadRequestException("Invalid field '${attribute}' specified. Allowed field(s) are: ${allowed}");
            }
        }
        parent::validateResolved();
    }

    /**
     * Return the data to validate.
     * Each request has a structure containing the top-keyword "data", therefore the inputs under that keywords are
     * returned for validation.
     *
     * @return array
     * @throws BadRequestException
     */
    public function validationData() {
        $data = request('data');
        if(is_null($data))
            throw new BadRequestException("Request is not properly structured: the top-level keyword'data' is missing!");
        return $data;
    }

}
