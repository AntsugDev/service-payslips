<?php

namespace App\Http\Api\Compaines;

use App\Http\Api\Users\Resources\UserResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class CompaineisController extends Controller
{
    public function listUser(User $user,Request $request) {
        dd($user->get());
        $list = $user->company($user->first()->code_user)->get();
        return new JsonResponse((new UserResourceCollection($list))->toArray($request),Response::HTTP_OK);
    }

}
