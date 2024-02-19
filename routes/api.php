<?php

use App\Http\Api\Compaines\CompaineisController;
use App\Http\Api\Users\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('data-request')->group(function (){
    Route::post('/oauth',[Users::class,'show']);

    Route::middleware('jwt.auth')
        ->prefix('v1')
        ->group(function (){
                Route::get('companies', [CompaineisController::class, 'listUser']);
        });

});




