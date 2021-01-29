<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//INICIO DE SESIÓN
Route::post('clients/login', [UserController::class,'login'])->name('login');
Route::post('employees/login', [UserController::class,'loginEmployees'])->name('login.employees');


Route::group(['middleware' => ['auth:api']], function () {

    //RUTAS CON PERMISO DE EMPLEADO
    Route::group(['middleware' => ['roles:EMPLEADO']], function () {

        //RUTAS CON PERMISO DE EMPLEADO ADMINISTRADOR
        Route::group(['middleware' => ['roles.employee:ADMINISTRADOR']], function () {

            Route::prefix('employees')->group(function(){

                Route::get('list',[EmployeeController::class,'listEmployees']);
                Route::post('create',[EmployeeController::class,'create']);
                Route::put('{id}/edit',[EmployeeController::class,'edit']);
                Route::delete('{id}/delete',[EmployeeController::class,'delete']);

            });

        });

        //RUTAS DE CUALQUIER EMPLEADO
        Route::prefix('clients')->group(function(){

            Route::get('list-normal',[ClientController::class,'listNormalClients']);
            Route::get('list-enterprise',[ClientController::class,'listEnterpriseClients']);
            Route::post('create',[ClientController::class,'create']);
            Route::put('{id}/edit',[ClientController::class,'edit']);
            Route::delete('{id}/delete',[ClientController::class,'delete']);

        });

    });

    //RUTAS CON PERMISO DE CLIENTES
    Route::group(['middleware' => ['roles:CLIENTE EMPRESARIAL,CLIENTE NORMAL']], function () {

        Route::prefix('clients')->group(function(){


        });

    });

    //RUTAS COMPARTIDAS
    Route::get('me',[UserController::class,'getMyData']);


});
