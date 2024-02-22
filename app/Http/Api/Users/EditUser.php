<?php

namespace App\Http\Api\Users;

use App\Http\Api\Core\Random;
use App\Http\Api\Core\UserTrait;
use App\Http\Api\Users\Requests\EditPasswordUser;
use App\Http\Api\Users\Requests\UserRequestCreate;
use App\Http\Api\Users\Requests\UserRequestCreateChild;
use App\Http\Api\Users\Resources\UserResource;
use App\Http\Api\Users\Resources\UserResourceNoToken;
use App\Http\Controllers\Controller;
use App\Mail\InvioPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Psy\Util\Json;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class EditUser extends Controller
{
    use UserTrait,Random;

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
            $user = User::where('_id',$id)->update(['pw'=> $request->input('newPassword'),'password' => Hash::make($request->input('newPassword')),'password_at' => \Illuminate\Support\Carbon::now()->format('d/m/Y H:i:s')]);
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
                $data['change_password'] = false;
                $data['password_at'] = Carbon::now()->format('d/m/Y H:i:s');
                $data['uuid'] = Str::uuid()->toString();
                $data['code_user'] = Crypt::encryptString($data['code_user']);
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

    public function create_user_child(UserRequestCreateChild $request):JsonResponse|null
    {

        if($request->validationData()) {
            if ($request->uniqueCodeUser()) {
                $user = $request->user();
                $uuid = $request->user()->uuid;
                $companyId = $request->user()->company_id;
                $data = $request->validationData();
                $password                = trim(strtolower(str_replace('', '_', explode('@', $data['email'])[0]))) . '.007';
                $data['password']        = Hash::make($password);
                $data['password_at']     = Carbon::now()->format('d/m/Y H:i:s');
                $data['code_user']       = Crypt::encryptString($data['code_user']);
                $data['uuid']            = Str::uuid()->toString();
                $data['change_password'] = true;
                $data['user_id']         = $uuid;
                $data['company_id']      = $companyId;

                $user = User::create($data);
                if($user instanceof User){
                    $resources = new UserResourceNoToken($user,$password);
                    //Mail::to($data['email'])->send(new InvioPassword( $data['name'],$password));
                    return new JsonResponse($resources->toArray($request),201);
                }

                else
                    return  new JsonResponse(array("error" => "Impossibile creare l'utenza"), 403);

            }else{
                return  new JsonResponse(array("error" => "Codice utente già presente"), 403);
            }
        }else
            return  new JsonResponse(array("error" => "La richiesta non è valida"), 400);
    }

    public function random(int $type): JsonResponse
    {
        if($type === 1)
            return new JsonResponse(array("data" => $this->generateFiscalCode()),201);
        else
            return new JsonResponse(array("data" => $this->generatePIVA()),201);
    }
}
