<?php

use App\Http\Api\Cities\CitiesController;
use App\Http\Api\Compaines\CompaineisController;
use App\Http\Api\Loggers\Controller\LoggerController;
use App\Http\Api\PassSave\Controllers\PassCategoryController;
use App\Http\Api\Users\EditUser;
use App\Http\Api\Users\Users;
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
    Route::get('/cities', [CitiesController::class, 'index']);

    Route::middleware('jwt.auth')
        ->prefix('v1')
        ->group(function (){
            Route::get('companies', [CompaineisController::class, 'listUser']);
            Route::prefix('/user')->group(function (){
                Route::post('/password/{id}',[EditUser::class,'edit_password']);
                Route::put('/create',[EditUser::class,'create_user_child']);
                Route::get('/admin',[EditUser::class,'admin']);
                Route::get('/admin/{user_id}',[EditUser::class,'user_details']);
                Route::delete('/admin/delete/{user_id}',[EditUser::class,'destroy']);
                Route::patch('/admin/change/{user_id}/{company_id}',[CompaineisController::class,'update_company_user']);
                Route::match(['GET','DELETE'],'/log',[LoggerController::class,'index']);
            });

            Route::prefix('pass')->group(function (){

                Route::resource('pass_category',PassCategoryController::class)->only(['index','store']);

            });

        });

});




