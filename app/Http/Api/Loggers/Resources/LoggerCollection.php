<?php

namespace App\Http\Api\Loggers\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LoggerCollection extends ResourceCollection
{
    public $collects = LoggerResources::class;

    public $resource = "companies";
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return array('data' => LoggerResources::collection($this->collection));
    }
}
