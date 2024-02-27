<?php

namespace App\Http\Api\Users;

use App\Http\Api\Core\Random;
use App\Http\Api\Core\UserTrait;
use App\Http\Api\Users\Requests\EditPasswordUser;
use App\Http\Api\Users\Requests\UserRequestCreate;
use App\Http\Api\Users\Requests\UserRequestCreateChild;
use App\Http\Api\Users\Resources\UserResource;
use App\Http\Api\Users\Resources\UserResourceCollection;
use App\Http\Api\Users\Resources\UserResourceNoToken;
use App\Http\Controllers\Controller;
use App\Mail\InvioPassword;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Psy\Util\Json;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class EditUser extends Controller
{
    use UserTrait, Random;

    /**
     * @throws NotFound
     * @throws \Exception
     */
    public function edit_password(EditPasswordUser $request, string $id): JsonResponse|null
    {

        if (!$this->checkUser($id))
            throw  new NotFound("User not found");

        if (!$this->rolePassword())
            throw  new \Exception("La password non corrisponde a quella attuale");

        if ($request->validationData()) {
            $user = User::where('_id', $id)->update(['password' => Hash::make($request->input('newPassword')), 'password_at' => \Illuminate\Support\Carbon::now()->format('d/m/Y H:i:s')]);
            if ($user) {
                return $this->json("Password aggiornata con successo");
            } else
                return new JsonResponse(array("error" => "La modifica non è andata a buon fine"), 403);
        }
        return null;
    }

    public function store(UserRequestCreate $request): JsonResponse|null
    {


        if ($request->validationData()) {
            if ($request->uniqueCodeUser() && $request->existCompanies()) {
                $data = $request->validationData();
                $role = Role::where('name', 'User')->pluck('uuid');
                $data['password'] = Hash::make($data['password']);
                $data['change_password'] = false;
                $data['password_at'] = Carbon::now()->format('d/m/Y H:i:s');
                $data['uuid'] = Str::uuid()->toString();
                $data['code_user'] = Crypt::encryptString($data['code_user']);
                $data['role_id'] = count($role) > 0 ? $role[0] : null;
                $user = User::create($data);
                if ($user instanceof User) {
                    $resources = new UserResourceNoToken($user);
                    return new JsonResponse($resources->toArray($request), 201);
                } else
                    return new JsonResponse(array("error" => "Impossibile creare l'utenza"), 403);
            } else {
                if (!$request->uniqueCodeUser())
                    return new JsonResponse(array("error" => "Codice utente già presente"), 403);

                if (!$request->existCompanies())
                    return new JsonResponse(array("error" => "Azienda non censita a sistema"), 404);

            }


        } else
            return new JsonResponse(array("error" => "La richiesta non è valida"), 400);

        return null;
    }

    public function create_user_child(UserRequestCreateChild $request): JsonResponse|null
    {

        if ($request->validationData()) {
            if ($request->uniqueCodeUser()) {
                $uuid = $request->user()->uuid;
                $companyId = $request->user()->company_id;
                $data = $request->validationData();
                $password = trim(strtolower(str_replace('', '_', explode('@', $data['email'])[0]))) . '.007';
                $data['password'] = Hash::make($password);
                $data['password_at'] = Carbon::now()->format('d/m/Y H:i:s');
                $data['code_user'] = Crypt::encryptString($data['code_user']);
                $data['uuid'] = Str::uuid()->toString();
                $data['change_password'] = true;
                $data['user_id'] = strcmp($request->input('type'), 'others') === 0 ? $uuid : null;
                $data['company_id'] = strcmp($request->input('type'), 'others') === 0 ? $companyId : null;
                $role = Role::where('name', (strcmp($request->input('type'), 'others') === 0 ? 'User-child' : 'User'))->pluck('uuid');
                $data['role_id'] = count($role) > 0 ? $role[0] : null;

                $user = User::create($data);
                if ($user instanceof User) {
                    $resources = new UserResourceNoToken($user, $password);
                    //Mail::to($data['email'])->send(new InvioPassword( $data['name'],$password));
                    return new JsonResponse($resources->toArray($request), 201);
                } else
                    return new JsonResponse(array("errors" => "Impossibile creare l'utenza"), 403);

            } else {
                return new JsonResponse(array("errors" => "Codice utente già presente"), 403);
            }
        } else
            return new JsonResponse(array("errors" => "La richiesta non è valida"), 400);
    }

    public function random(int $type): JsonResponse
    {
        if ($type === 1)
            return new JsonResponse(array("data" => $this->generateFiscalCode()), 201);
        else
            return new JsonResponse(array("data" => $this->generatePIVA()), 201);
    }

    public function admin(Request $request): JsonResponse|null
    {
        $user = $request->user();
        $admin = strcmp($user->name, 'Admin') === 0;
        if ($admin) {
            $listUser = User::where('name', '!=', 'Admin')->get();
            return new JsonResponse(new UserResourceCollection($listUser), 200);
        }
        return new JsonResponse(array("errors" => "Utente non autorizzato alla richiesta"), 401);
    }

    public function user_details(Request $request, string $user_id): JsonResponse
    {
        $user      = $request->user();
        $admin     = strcmp($user->name,'Admin') === 0;
        if($admin){
            $user = User::where('uuid',$user_id)->first();
            if($user instanceof User)
                return new JsonResponse(new UserResourceNoToken($user),200);
            else
                return new JsonResponse(array("errors"=>"User not found"),404);
        }
        return  new JsonResponse(array("errors" => "Utente non autorizzato alla richiesta"), 401);
    }

    public function destroy (Request $request, string $user_id) : JsonResponse|null
    {
        $user      = $request->user();
        $admin     = strcmp($user->name,'Admin') === 0;
        if($admin){
            try {
                User::where('uuid',$user_id)->delete();
                return $this->json("Utenza cancellata con successo");
            }
            catch (\Exception $e) {
                return new JsonResponse(array("errors" => "Non è stato possibile cancellare l'utenza(".$e->getMessage().")"), 406);
            }

        }
        return  new JsonResponse(array("errors" => "Utente non autorizzato alla richiesta"), 401);

    }

}
