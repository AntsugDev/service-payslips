<?php

namespace App\Http\Api\Compaines;

use App\Http\Api\Compaines\Resource\CompainesCollection;
use App\Http\Api\Users\Resources\UserResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\Compaineis;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class CompaineisController extends Controller
{
    public function listUser(Request $request) {
        $user = $request->user();
        $list = $user->company($user->uuid);
        return new JsonResponse((new UserResourceCollection($list))->toArray($request),Response::HTTP_OK);
    }


    public function list(Request $request){
        $list = Compaineis::all();
        return new JsonResponse((new CompainesCollection($list))->toArray($request),Response::HTTP_OK);

    }

}
