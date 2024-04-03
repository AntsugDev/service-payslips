<?php

namespace App\Http\Api\Users\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Api\Users\Resources\UserResourceNoToken;

class UserResourceCollection extends ResourceCollection
{
    public $collects = UserResourceNoToken::class;

    public $resource = "users";
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array('data' => UserResourceNoToken::collection($this->collection));
    }
}
