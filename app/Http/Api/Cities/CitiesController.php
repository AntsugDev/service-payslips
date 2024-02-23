<?php

namespace App\Http\Api\Cities;

use App\Http\Api\Cities\Resources\CitiesResourceCollection;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;

class CitiesController extends Controller
{

    public function index():JsonResponse|null
    {
        return new JsonResponse(new CitiesResourceCollection(City::all()),200);
    }

}
