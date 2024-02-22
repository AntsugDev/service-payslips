<?php

namespace App\Http\Api\Compaines\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitiesResources extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
            "id" => $this->resource->uuid,
            "name" => $this->resource->name,
            "provincie" => $this->resource->provincie,
            "region" => $this->resource->region,
            "cadastral_code" => $this->resource->cadastral_code,
            "pr" => $this->resource->pr,
        ];
    }
}
