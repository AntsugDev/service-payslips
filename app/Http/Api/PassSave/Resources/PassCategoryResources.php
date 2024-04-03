<?php

namespace App\Http\Api\PassSave\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassCategoryResources extends JsonResource
{
    public function toArray(Request $request):array
    {
        return [
            "id"=>$this->resource->uuid,
            "name" => $this->resource->name,
            "fields" => $this->resource->fields
        ];
    }

}
