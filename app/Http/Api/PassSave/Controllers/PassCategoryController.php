<?php

namespace App\Http\Api\PassSave\Controllers;

use App\Http\Api\PassSave\Request\PassCategoryRequest;
use App\Http\Api\PassSave\Resources\PassCategoryCollection;
use App\Http\Api\PassSave\Resources\PassCategoryResources;
use App\Http\Controllers\Controller;
use App\Models\PassSave\PassCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PassCategoryController extends Controller
{

    public function index():JsonResponse
    {
        $list = PassCategory::all();
        return new JsonResponse(new PassCategoryCollection($list),200);

    }

    public function store(PassCategoryRequest $request):JsonResponse
    {

        if($request->validationData() && $request->verify()){
            $data = $request->validationData();
            $data['uuid'] = Str::uuid()->toString();
            $category = PassCategory::create($data);
            if($category instanceof PassCategory)
                return new JsonResponse((new PassCategoryResources($category))->toArray($request),200);
        }
        return  new JsonResponse(array("errors"=>"List empty"),400);

    }

}
