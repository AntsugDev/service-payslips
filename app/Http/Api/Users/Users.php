<?php

namespace App\Http\Api\Users;

use App\Http\Api\Core\Exceptions\Includes\InvalidIncludeException;
use App\Http\Api\Users\Filter\UserFilter;
use App\Http\Api\Users\Requests\UserRequestToken;
use App\Http\Api\Users\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Users extends Controller
{
    /**
     * @throws \Exception
     */



    public function show(UserRequestToken $request, UserFilter $filter) {

        try {
            $user = User::where('email', $request->input('email'))->first();
            if ($user instanceof User) {
                $checkPassword = Hash::check($request->input('password'), $user->getAuthPassword());
                if (!$checkPassword)
                    return new JsonResponse(array("error" => "La password non è corretta"), Response::HTTP_FORBIDDEN);
                try {

                    if($token = JWTAuth::attempt([
                        "email" => $request->input('email'),
                        "password" => $request->input('password')
                    ])){
                        $user = Auth::user();
                        return new UserResource($token, $user);
                    }else
                        return new JsonResponse(array("error" =>'Invalid credentials'), Response::HTTP_NOT_ACCEPTABLE);

                } catch (JWTException $e) {
                    return new JsonResponse(array("error" =>'\JWTException: '.$e->getFile().':'.$e->getLine().' '.$e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);
                } catch (InvalidIncludeException $e) {
                    return new JsonResponse(array("error" => $e->getMessage()), Response::HTTP_NOT_FOUND);
                }
            } else {
                return new JsonResponse(array("error" => "User non presente"), Response::HTTP_NOT_FOUND);
            }
        }catch (\Exception $e){
            return new JsonResponse(array("error" =>$e->getFile().':'.$e->getLine().' '.$e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);

        }
    }

}
