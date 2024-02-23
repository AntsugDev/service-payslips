<?php

namespace App\Http\Api\Compaines\Resource;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompainesResources extends JsonResource
{

    private array $queryString = [];

    public function __construct($resource)
    {
        parent::__construct($resource);
        if(!is_null(request()->getQueryString())) {
            parse_str(request()->getQueryString(), $this->queryString);
            $this->queryString = array_values($this->queryString);
        }
    }


    public function toArray(Request $request): array
    {
        return [
          "company" => [
              "id" => $this->resource->uuid,
              "name"=> $this->resource->name,
              "address"=> $this->resource->address,
              'email'=> $this->resource->email,
              'phone'=> $this->resource->phone,
              "city" => $this->when(in_array('city', $this->queryString),function ()use($request){
                  $list = $this->resource->cities($this->resource->city);
                  if($list instanceof  City)
                      return (new CitiesResources($list))->toArray($request);

                  return null;
              })
          ]
        ];
    }

}
