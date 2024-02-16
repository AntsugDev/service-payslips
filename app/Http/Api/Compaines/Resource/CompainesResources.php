<?php

namespace App\Http\Api\Compaines\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompainesResources extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
          "company" => [
              "id" => $this->resource->_id,
              "name"=> $this->resource->name,
              "city"=> $this->resource->city,
              "address"=> $this->resource->address,
              'email'=> $this->resource->email,
              'phone'=> $this->resource->phone,
          ]
        ];
    }

}
