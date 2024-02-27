<?php

namespace App\Http\Api\Loggers\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoggerResources extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            "id" => $this->resource->uuid,
            "name" =>$this->resource->name,
            "type"=> $this->resource->type,
            "msg"=> $this->resource->msg,
            "date_insert"=> $this->resource->date_insert,
        ];
    }

}
