<?php

namespace App\Http\Api\Compaines;

use App\Http\Api\Compaines\Request\CompaniesCreateRequest;
use App\Http\Api\Compaines\Resource\CompainesCollection;
use App\Http\Api\Core\UserTrait;
use App\Http\Api\Users\Resources\UserResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Compaineis;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class CompaineisController extends Controller
{
    use UserTrait;
    public function listUser(Request $request) {
        $user = $request->user();
        $list = $user->company($user->uuid);
        return new JsonResponse((new UserResourceCollection($list))->toArray($request),Response::HTTP_OK);
    }


    public function list(Request $request){
        $list = Compaineis::all();
        return new JsonResponse((new CompainesCollection($list))->toArray($request),Response::HTTP_OK);

    }


    public function store(CompaniesCreateRequest $request){

        if($request->validationData()){

            $data = $request->validationData();
            $email = $data['email'];
            $name = $data['name'];
            $company = Compaineis::create(
                [
                    'uuid' => Str::uuid()->toString(),
                    "name" => $name,
                    "city" => $data['city'],
                    "address" => $data['address'],
                    'email'=> $email,
                    'phone' => $data['phone'],
                ]
            );
            if($company instanceof  Compaineis){
                $role                    = Role::where('name','Company')->pluck('uuid');
                $user = User::create([
                    'uuid' =>Str::uuid()->toString() ,
                    'email' => $email,
                    'name' => $name,
                    'code_user' => Crypt::encryptString($data['code_user']),
                    'password' => Hash::make(trim(strtolower(str_replace('', '_', explode('@', $email)[0]))) . '.007'),
                    'password_at' => Carbon::now()->format('d/m/Y H:i:s'),
                    'change_password' => false,
                    'user_id' => null,
                    'company_id' => $company->uuid,
                    'role_id' => count($role) > 0 ? $role[0] : null
                ]);

                if($user instanceof  User)
                    return $this->json("Company ed utenza creata");
                else
                    return  new JsonResponse(array("errors" => "Creazione company andata a buon fine, ma è fallita la creazione della relativa utenza"), 403);

            }else
                return  new JsonResponse(array("errors" => "Creazione company fallita"), 403);

        }else{
            return  new JsonResponse(array("errors" => "La richiesta non è valida"), 400);
        }

    }

    public function update_company_user(Request $request, string $user_id, string $company_id):JsonResponse|null
    {
        $user      = $request->user();
        $admin     = strcmp($user->name,'Admin') === 0;
        if($admin){
            User::where('uuid',$user_id)->update(['company_id' => $company_id, 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
            return  $this->json("Aggiornamento avvenuto con successo");
        }else
            return  new JsonResponse(array("errors" => "Utente non autorizzato alla richiesta"), 401);

        return  new JsonResponse(array("errors" => "Errore generico"), 500);

    }

}
