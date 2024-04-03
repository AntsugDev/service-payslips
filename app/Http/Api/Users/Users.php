<?php

namespace App\Http\Api\Users;

use App\Http\Api\Core\Exceptions\Client\UnauthorizedException;
use App\Http\Api\Core\Exceptions\Includes\InvalidIncludeException;
use App\Http\Api\Core\UserTrait;
use App\Http\Api\Users\Filter\UserFilter;
use App\Http\Api\Users\Requests\EditPasswordUser;
use App\Http\Api\Users\Requests\EditPasswordUserNew;
use App\Http\Api\Users\Requests\UserRequestStepperOne;
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
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Users extends Controller
{
    /**
     * @throws \Exception
     */
    use UserTrait;


    public function show(UserRequestToken $request, UserFilter $filter) {

        try {
            $user = User::where('email', $request->input('email'))->first();
            if ($user instanceof User) {

                $checkPassword = Hash::check($request->input('password'), $user->password);
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
                        return new JsonResponse(array("errors" =>'Invalid credentials'), Response::HTTP_NOT_ACCEPTABLE);

                } catch (JWTException $e) {
                    return new JsonResponse(array("errors" =>'\JWTException: '.$e->getFile().':'.$e->getLine().' '.$e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);
                } catch (InvalidIncludeException $e) {
                    return new JsonResponse(array("errors" => $e->getMessage()), Response::HTTP_NOT_FOUND);
                }
            } else {
                return new JsonResponse(array("errors" => "User non presente"), Response::HTTP_NOT_FOUND);
            }
        }catch (\Exception $e){
            return new JsonResponse(array("errors" =>$e->getFile().':'.$e->getLine().' '.$e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);

        }
    }

    /**
     * @throws NotFound
     * @throws UnauthorizedException
     */
    public function check_email(string $email): JsonResponse|null
    {
        return  $this->checkEmail($email);
    }

    /**
     * @throws UnauthorizedException
     */
    public function reset_password(EditPasswordUserNew $request, string $uuid): JsonResponse|null
    {
        if(strcmp($uuid,'') === 0 )
            throw new UnauthorizedException("Procedura non autorizzata");
        if($request->validationData()){
            $actualPassword = User::where('uuid',$uuid)->pluck('password')->toArray();
            if(count($actualPassword) > 0){
                $checkPassword  = Hash::check($request->input('password'),$actualPassword[0]);
                if($checkPassword)
                    return  new JsonResponse(array("errors" => "La password che si sta cambiando è uguale a quella presente a sistema"), 406);
            }

            if($request->input('update'))
                $user = User::where('uuid',$uuid)->update([
                    'change_password' => false,
                    'password' => Hash::make($request->input('password')),
                    'password_at' => Carbon::now()->format('d/m/Y H:i:s')]);
                else
                $user = User::where('uuid',$uuid)->update([
                    'password' => Hash::make($request->input('password')),
                    'password_at' => Carbon::now()->format('d/m/Y H:i:s')]);
                if($user){
                    return  $this->json("Password aggiornata con successo",$uuid);
                }
                else
                    return  new JsonResponse(array("errors" => "La modifica non è andata a buon fine"), 403);
        }
        throw new UnauthorizedException("Password errata o non si hanno le autorizzazioni necessarie");
    }



}
