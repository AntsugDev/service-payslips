<?php

namespace App\Http\Api\Core;

use App\Http\Api\Users\Resources\UserResource;
use App\Http\Api\Users\Resources\UserResourceNoToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\FlareClient\Http\Exceptions\NotFound;

trait UserTrait
{

    public function user_auth(){
        return request()->user();
    }

    public function checkUser(string $id, ?bool $isCount = true):bool|User
    {
        if($isCount)
            return User::where('_id',$id)->count() > 0;
        else
            return User::where('_id',$id)->first();

    }

    public function rolePassword():bool
    {
        if(request()->route('uuid'))
            $user = DB::connection('mongodb')->table('users')->where('uuid',request()->route('uuid'))->pluck('password')->toArray();
        else
            $user = DB::connection('mongodb')->table('users')->where('_id',request()->route('id'))->pluck('password')->toArray();

        if(is_array($user) && count($user)>0){
            dd(Hash::check(request()->input('password'), $user[0]));
            return Hash::check(request()->input('password'), $user[0]);
        }
        return false;
    }

    public function resources(string $id): UserResourceNoToken
    {
        $user = $this->checkUser($id,false);
        return new UserResourceNoToken($user);
    }

    /**
     * @throws NotFound
     */
    public function checkEmail(string $email): JsonResponse
    {
        $user = User::where('email',$email)->pluck('uuid')->toArray();
        if(is_array($user) && count($user) > 0)
            return $this->json("Email presente a sistema",$user[0]);
        else
            throw new NotFound("User not found");
    }




    public function json(string $msg,string|null $uuid = null):JsonResponse
    {
        return new JsonResponse(array(
            "data" => array(
                "data_request" => Carbon::now()->format('d/m/Y H:i:s'),
                "esito" => $msg,
                "uuid_request"=> is_null($uuid) ? Str::uuid()->toString() : $uuid
            )
        ),200);
    }
}
