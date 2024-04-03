<?php

namespace App\Http\Api\PassSave\Controllers;

use App\Http\Api\Core\UserTrait;
use App\Http\Api\PassSave\Request\PassCategoryRequest;
use App\Http\Api\PassSave\Resources\PassCategoryCollection;
use App\Http\Api\PassSave\Resources\PassCategoryResources;
use App\Http\Controllers\Controller;
use App\Models\PassSave\PassCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PassCategoryController extends Controller
{
    use UserTrait;

    public function index():JsonResponse
    {
        $list = PassCategory::all();
        return new JsonResponse(new PassCategoryCollection($list),200);

    }

    public function store(PassCategoryRequest $request):JsonResponse
    {
        if($request->validationData() ){
            if($request->verify()) {
                $data = $request->validationData();
                $data['uuid'] = Str::uuid()->toString();
                $category = PassCategory::create($data);
                if ($category instanceof PassCategory)
                    return new JsonResponse((new PassCategoryResources($category))->toArray($request), 200);
            }else
                return new JsonResponse(array("errors"=>"Category già presente"), 403);

        }
        return  new JsonResponse(array("errors"=>"Errore in fase di creazione"),422);

    }

    public function destroy(string $pass_category):JsonResponse
    {
        try{
            PassCategory::where('uuid',$pass_category)->delete();
            return $this->json("Categoria cancellata");
        }catch (\Exception $e){
            return  new JsonResponse(array("errors"=>$e->getMessage()),422);
        }
    }

}
