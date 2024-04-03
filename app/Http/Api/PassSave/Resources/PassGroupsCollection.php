<?php

namespace App\Http\Api\PassSave\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PassGroupsCollection extends ResourceCollection
{
    public $collects = PassGroupsResources::class;

    public $resource = "users";
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return array('data' => PassGroupsResources::collection($this->collection));
    }
}
