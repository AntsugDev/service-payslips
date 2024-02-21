<?php

namespace App\Http\Api\Users;

use App\Http\Api\Core\UserTrait;
use App\Http\Api\Users\Requests\EditPasswordUser;
use App\Http\Api\Users\Requests\UserRequestCreate;
use App\Http\Api\Users\Resources\UserResource;
use App\Http\Api\Users\Resources\UserResourceNoToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class EditUser extends Controller
{
    use UserTrait;

    /**
     * @throws NotFound
     * @throws \Exception
     */
    public function edit_password(EditPasswordUser $request, string $id):JsonResponse|null
    {

        if(!$this->checkUser($id))
            throw  new NotFound("User not found");

        if(!$this->rolePassword())
            throw  new \Exception("La password non corrisponde a quella attuale");

        if($request->validationData()){
            $user = User::where('_id',$id)->update(['password' => Hash::make($request->input('newPassword'))]);
            if($user){
                return  $this->json("Password aggiornata con successo");
            }
            else
                return  new JsonResponse(array("error" => "La modifica non è andata a buon fine"), 403);
        }
        return null;
    }

    public function store(UserRequestCreate $request):JsonResponse|null
    {

        if($request->validationData()) {
            if($request->uniqueCodeUser() && $request->existCompanies()){
                $data = $request->validationData();
                $data['password'] = Hash::make($data['password']);
                $data['uuid'] = Str::uuid()->toString();
                $user = User::create($data);
                if($user instanceof User){
                    $resources = new UserResourceNoToken($user);
                    return new JsonResponse($resources->toArray($request),201);
                }

                else
                    return  new JsonResponse(array("error" => "Impossibile creare l'utenza"), 403);
            } else{
                if(!$request->uniqueCodeUser())
                    return  new JsonResponse(array("error" => "Codice utente già presente"), 403);

                if(!$request->existCompanies())
                    return  new JsonResponse(array("error" => "Azienda non censita a sistema"), 404);

            }


        }else
            return  new JsonResponse(array("error" => "La richiesta non è valida"), 400);

        return null;
    }
}
