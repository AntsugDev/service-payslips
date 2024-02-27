<?php

namespace App\Http\Api\PassSave\Controllers;

use App\Http\Api\Core\UserTrait;
use App\Http\Api\PassSave\Request\PassGroupsRequest;
use App\Http\Api\PassSave\Resources\PassGroupsCollection;
use App\Http\Api\PassSave\Resources\PassGroupsResources;
use App\Http\Controllers\Controller;
use App\Models\PassSave\PassGroups;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PassGroupsController extends Controller
{
    use UserTrait;

    public function index(Request $request):JsonResponse
    {
        $uuid = $request->user()->uuid;
        $list = PassGroups::where('user_id',$uuid)->get();
        return new JsonResponse(new PassGroupsCollection($list),200);

    }

    public function store(PassGroupsRequest $request):JsonResponse
    {

        if($request->validationData() ){

            $verify = $request->verify();

            if($verify) {
                $data = $request->validationData();
                $data['uuid'] = Str::uuid()->toString();
                $data['user_id'] = $request->user()->uuid;
                $groups = PassGroups::create($data);
                if ($groups instanceof PassGroups)
                    return new JsonResponse((new PassGroupsResources($groups))->toArray($request), 200);
            }else
                return new JsonResponse(array("errors"=>"Gruppo già presente"), 403);
        }
        return  new JsonResponse(array("errors"=>"Errore in fase di creazione"),422);

    }

    public function destroy(string $pass_group):JsonResponse
    {
        try{
            PassGroups::where('uuid',$pass_group)->delete();
            return $this->json("Gguppo cancellato");
        }catch (\Exception $e){
            return  new JsonResponse(array("errors"=>$e->getMessage()),422);
        }
    }

}
