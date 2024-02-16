<?php

namespace App\Http\Api\Users\Resources;

use App\Http\Api\Compaines\Resource\CompainesResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class UserResource extends JsonResource
{

    private string|null $accessToken;

    private User $user;

    /**
     * @param string $accessToken
     */
    public function __construct(string|null $accessToken,User $user)
    {
        parent::__construct($user);
        $this->accessToken = $accessToken;
    }


    public function toArray(Request $request): array
    {
        $claims = $this->resource->getJWTCustomClaims();
        $claims['access_token'] = $this->accessToken;
        $companies = new CompainesResources($this->whenLoaded('company'));
        $response =  [
            "user" => [
                'id' => $this->resource->_id,
                "name" => $this->resource->name,
                "cf" => $this->resource->email,
                "email" => Crypt::decryptString( $this->resource->code_user),
                "isAuthenticated" => !is_null($this->accessToken),
                "role" => strcmp($this->resource->company_id,'') !== 0 ? 'user' : 'company',
                "jwt" => $claims,
            ]
        ];
        if(strcmp($this->resource->company_id,'') !== 0)
            $response["company"] =$companies instanceof CompainesResources  ? $companies->toArray($request)['company'] : null;
        return  $response;

    }
}
