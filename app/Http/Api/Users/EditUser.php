<?php

namespace App\Http\Api\Users;

use App\Http\Api\Core\UserTrait;
use App\Http\Api\Users\Requests\EditPasswordUser;
use App\Http\Api\Users\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Js;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class EditUser extends Controller
{
    use UserTrait;

    /**
     * @throws NotFound
     * @throws \Exception
     */
    public function edit_password(EditPasswordUser $request, string $id){

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

    }
}
