<?php

namespace App\Http\Api\Compaines\Resource;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;
class CompainesCollection extends ResourceCollection
{

    public $collects = CompainesResources::class;

    public $resource = "companies";
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array('data' => CompainesResources::collection($this->collection));
    }

}
