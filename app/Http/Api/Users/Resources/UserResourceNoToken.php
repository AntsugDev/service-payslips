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


    private string|null $firstPassword;

    private array|null $queryString = array();

    /**
     * @param string|null $firstPassword
     */
    public function __construct(User $user,?string $firstPassword = null)
    {
        parent::__construct($user);
        $this->firstPassword = $firstPassword;

        if(stristr(request()->getQueryString(),'includes') !== false){
            parse_str(request()->getQueryString(),$this->queryString);
            $this->queryString = explode(',',$this->queryString['includes']);
        }
    }


    public function toArray(Request $request): array
    {
        $role = $this->resource->get_role();

        $return = [
            "user" => [
                'id' => $this->resource->uuid,
                "name" => $this->resource->name,
                "code_user" => Crypt::decryptString($this->resource->code_user),
                "email" => $this->resource->email,
                "role" =>  count($role) > 0 ? $role[0] : null,
                'password_at' => $this->resource->password_at,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
                'change_password' =>  $this->resource->change_password,
                "company_id" => $this->resource->company_id,
                "company"=> $this->when(in_array('company',$this->queryString), function () use($request)
                {
                    try {
                        if(!is_null($this->resource->company_id)) {
                            $companies = Compaineis::where('uuid', $this->resource->company_id)->first();
                            if ($companies instanceof Compaineis)
                                return (new CompainesResources($companies))->toArray($request)['company'];
                        }
                        return null;
                    } catch (ModelNotFoundException|\Exception $e) {
                        return new JsonResponse(array("errors" => "Exception Resource: " . $e->getFile() . ':' . $e->getLine() . ' ' . $e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                })
            ]
        ];
        if(!is_null($this->firstPassword))
            $return['user']['first_access'] = $this->firstPassword;

        return  $return;


    }
}
