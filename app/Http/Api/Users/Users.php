<?php

namespace App\Http\Api\Users;

use App\Http\Api\Users\Requests\UserRequestToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Users extends Controller
{
    public function show(UserRequestToken $request) {

        $user = User::where('email',$request->input('email'))
            ->where('pv',$request->input('password'))
            ->first();
        if($user instanceof User){
            try {
                $claims = $user->getJWTCustomClaims();
                $token  = JWTAuth::fromUser($user);
                $claims['access_token'] = $token;
                $claims['users'] = $user->toArray();
                return response()->json($claims);
            }catch (JWTException $exception) {
                throw new \Exception($exception->getFile().':'.$exception->getLine().' - '.$exception->getMessage());
            }
        }else {
            return new JsonResponse(array("error" => "User non presente"), Response::HTTP_NOT_FOUND);
        }

    }
}
