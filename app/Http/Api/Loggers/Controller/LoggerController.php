<?php

namespace App\Http\Api\Loggers\Controller;

use App\Http\Api\Core\UserTrait;
use App\Http\Api\Loggers\Resources\LoggerCollection;
use App\Http\Controllers\Controller;
use App\Models\LoggerModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoggerController extends Controller
{
    use UserTrait;

    public function index(Request $request):JsonResponse|null {
        $user      = $request->user();
        $admin     = strcmp($user->name,'Admin') === 0;
        if($admin){
            if(strcmp($request->getMethod(),'GET') === 0){
                $logger = LoggerModel::all();
                return  new JsonResponse(new LoggerCollection($logger),200);
            }else{
                DB::connection('mongodb')->table('loggers')->delete();
                return $this->json("Log cancellati");
            }

        }
        return  new JsonResponse(array("errors" => "Utente non autorizzato alla richiesta"), 401);

    }
}
