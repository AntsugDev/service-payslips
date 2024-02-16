<?php

namespace App\Http\Api\Users;

use App\Http\Api\Core\Exceptions\Includes\InvalidIncludeException;
use App\Http\Api\Users\Filter\UserFilter;
use App\Http\Api\Users\Requests\UserRequestToken;
use App\Http\Api\Users\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Users extends Controller
{
    /**
     * @throws \Exception
     */
    public function show(UserRequestToken $request, UserFilter $filter) {

        $user = User::where('email',$request->input('email'))->first();
        if($user instanceof User){

            $checkPassword = Hash::check($request->input('password'),$user->getAuthPassword());
            if(!$checkPassword)
                return new JsonResponse(array("error" => "La password non è corretta"), Response::HTTP_FORBIDDEN);
            try {
                $token  = JWTAuth::fromUser($user);
                $user = $user->load($filter->get_includes());
                return new UserResource($token,$user);
            }catch (JWTException $exception) {
                throw new \Exception($exception->getFile().':'.$exception->getLine().' - '.$exception->getMessage());
            } catch (InvalidIncludeException $e) {
                return new JsonResponse(array("error" => $e->getMessage()), Response::HTTP_NOT_FOUND);
            }
        }else {
            return new JsonResponse(array("error" => "User non presente"), Response::HTTP_NOT_FOUND);
        }

    }
}
