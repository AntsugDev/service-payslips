<?php

use App\Http\Api\Compaines\CompaineisController;
use App\Http\Api\Users\EditUser;
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
    Route::get('/reset/check_email/{email}',[Users::class,'check_email']);
    Route::post('/reset/update_password/{uuid}',[Users::class,'reset_password']);
    Route::get('/companies/all',[CompaineisController::class, 'list']);
    Route::put('/create',[EditUser::class, 'store']);
    Route::get('/random/{type}',[EditUser::class, 'random']);
    Route::put('/companies/create',[CompaineisController::class, 'store']);


    Route::middleware('jwt.auth')
        ->prefix('v1')
        ->group(function (){
                Route::get('companies', [CompaineisController::class, 'listUser']);
                Route::prefix('/user')->group(function (){
                    Route::post('/password/{id}',[EditUser::class,'edit_password']);
                    Route::put('/create',[EditUser::class,'create_user_child']);
                });

        });

});




