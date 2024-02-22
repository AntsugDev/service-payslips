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

    /**
     * @param string|null $firstPassword
     */
    public function __construct(User $user,?string $firstPassword = null)
    {
        parent::__construct($user);
        $this->firstPassword = $firstPassword;
    }


    public function toArray(Request $request): array
    {
            $return = [
                "user" => [
                    'id' => $this->resource->uuid,
                    "name" => $this->resource->name,
                    "code_user" => Crypt::decryptString($this->resource->code_user),
                    "email" => $this->resource->email,
                    "role" => is_null($this->resource->user_id) ? 'company' : 'user',
                    'password_at' => $this->resource->password_at,
                    'created_at' => $this->resource->created_at,
                    'updated_at' => $this->resource->updated_at,
                    'change_password' =>  $this->resource->change_password,
                ]
            ];
            if(!is_null($this->firstPassword))
                $return['user']['first_access'] = $this->firstPassword;

            return  $return;


    }
}
