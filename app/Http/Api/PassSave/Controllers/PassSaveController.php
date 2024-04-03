<?php

namespace App\Http\Api\PassSave\Controllers;

use App\Http\Api\Core\UserTrait;
use App\Http\Api\PassSave\Request\PassCategoryRequest;
use App\Http\Api\PassSave\Request\PassGroupsRequest;
use App\Http\Api\PassSave\Request\PassSaveRequest;
use App\Http\Api\PassSave\Resources\PassCategoryCollection;
use App\Http\Api\PassSave\Resources\PassCategoryResources;
use App\Http\Api\PassSave\Resources\PassGroupsResources;
use App\Http\Controllers\Controller;
use App\Models\PassSave\PassCategory;
use App\Models\PassSave\PassGroups;
use App\Models\PassSave\PassSave;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class PassSaveController extends Controller
{
    use UserTrait;

    public function index(Request $request):JsonResponse
    {

    }

    public function store(PassSaveRequest $request):JsonResponse
    {

        if($request->validationData() ){

            if($request->verify()){

                $data = $request->validationData();
                $data['uuid']    = Str::uuid()->toString();
                $data['user_id'] = $request->user()->uuid;

                $data['json_dati'] = Crypt::encryptString(json_encode($data['json_dati'],true));

                $save = PassSave::create($data);
                if($save instanceof  PassSave)
                    return $this->json("Password salvata",$save->uuid);
                else
                    return  new JsonResponse(array("errors"=>"Salvataggio della password non è anadato a buon fine"),406);

            }else{
                return  new JsonResponse(array("errors"=>"Groups e/o Category non presente/i a sistema"),422);
            }

        }
        return  new JsonResponse(array("errors"=>"Errore in fase di creazione"),422);

    }

    public function destroy(string $pass_group):JsonResponse
    {
        try{
            //todo
        }catch (\Exception $e){
            return  new JsonResponse(array("errors"=>$e->getMessage()),422);
        }
    }

}
