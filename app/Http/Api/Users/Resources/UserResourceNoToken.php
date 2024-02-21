<?php

namespace App\Http\Api\Users\Resources;

use App\Http\Api\Compaines\Resource\CompainesResources;
use App\Http\Api\Users\Requests\UserRequestToken;
use App\Models\Compaineis;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class UserResourceNoToken extends JsonResource
{




    public function toArray(Request $request): array
    {
            return [
                "user" => [
                    'id' => $this->resource->id,
                    "name" => $this->resource->name,
//                    "cf" => Crypt::decryptString($this->resource->code_user),
                    "cf" => $this->resource->code_user,
                    "email" => $this->resource->email,
                    "role" => strcmp($this->resource->company_id, '') === 0 ? 'user' : 'company',
                    'created_at' => $this->resource->created_at,
                    'updated_at' => $this->resource->updated_at,
                ]
            ];


    }
}
