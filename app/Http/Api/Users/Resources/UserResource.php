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

class UserResource extends JsonResource
{

    private string|null $accessToken;

    private array|null $queryString = array();
    private User $user;

    /**
     * @param string|null $accessToken
     * @param User $user
     */
    public function __construct(string|null $accessToken,User $user)
    {
        parent::__construct($user);
        $this->accessToken = $accessToken;

        if(stristr(request()->getQueryString(),'includes') !== false){
            parse_str(request()->getQueryString(),$this->queryString);
        }
        $this->queryString = array_values($this->queryString);

    }


    public function toArray(Request $request): array
    {
        $claims = $this->resource->getJWTCustomClaims();
        $claims['access_token'] = $this->accessToken;

        return  [
            "user" => [
                'id' => $this->resource->uuid,
                "name" => $this->resource->name,
                "cf" => $this->resource->email,
                "email" => Crypt::decryptString( $this->resource->code_user),
                "isAuthenticated" => !is_null($this->accessToken),
                "role" => strcmp($this->resource->company_id,'') !== 0 ? 'user' : 'company',
                "jwt" => $claims,
                "company"=> $this->when(in_array('company',$this->queryString), function () use($request){
                    try {
                        $companies = Compaineis::where('uuid', $this->resource->company_id)->first();
                        if ($companies instanceof Compaineis)
                            return (new CompainesResources($companies))->toArray($request)['company'];
                        return null;
                    }catch (ModelNotFoundException|\Exception $e){
                        return new JsonResponse(array("errors" => "Exception Resource: ".$e->getFile().':'.$e->getLine().' '.$e->getMessage()),Response::HTTP_UNPROCESSABLE_ENTITY);
                    }

                }),
                'created_at' => $this->resource->created_at,
                'updated_at'=> $this->resource->updated_at,
            ]
        ];

    }
}
