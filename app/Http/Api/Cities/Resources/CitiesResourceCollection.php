<?php

namespace App\Http\Api\Cities\Resources;

use App\Http\Api\Compaines\Resource\CitiesResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CitiesResourceCollection extends ResourceCollection
{

    public $collects = CitiesResources::class;

    public $resource = "cities";
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return array('data' => CitiesResources::collection($this->collection));
    }

}
