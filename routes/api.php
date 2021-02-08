<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypeServiceController;
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
            Route::get('list-all-mapped',[ClientController::class,'listAllMapped']);
            Route::post('create',[ClientController::class,'create']);
            Route::put('{id}/edit',[ClientController::class,'edit']);
            Route::delete('{id}/delete',[ClientController::class,'delete']);

        });

        Route::prefix('rooms')->group(function(){
            Route::get('list-types', [RoomController::class,'listTypes']);
            Route::get('list',[RoomController::class, 'listRooms']);
            Route::post('create',[RoomController::class,'create']);
            Route::post('{id}/edit',[RoomController::class,'edit']);
            Route::delete('{id}/delete',[RoomController::class,'delete']);
            Route::patch('{id}/change-state',[RoomController::class,'changeState']);
        });

        Route::prefix('reservations')->group(function(){

            Route::get('list',[ReservationController::class,'listReservations']);
            Route::get('{id}/list-by-client',[ReservationController::class,'listReservationsByClient']);
            Route::post('get-ranges',[ReservationController::class,'getRanges']);
            Route::post('create',[ReservationController::class,'create']);
            Route::put('{id}/edit',[ReservationController::class,'edit']);
            Route::delete('{id}/delete',[ReservationController::class,'delete']);

        });

        Route::prefix('offers')->group(function(){
            Route::get('list',[OfferController::class,'listEnables']);
            Route::post('create',[OfferController::class,'create']);
            Route::post('{id}/edit',[OfferController::class,'edit']);
            Route::delete('{id}/delete',[OfferController::class,'delete']);
        });


        Route::prefix('type-services')->group(function(){
            Route::get('list',[TypeServiceController::class,'list']);
            Route::post('create',[TypeServiceController::class,'create']);
            Route::put('{id}/edit',[TypeServiceController::class,'edit']);
        });

        Route::prefix('services')->group(function(){
            Route::get('list',[ServiceController::class,'list']);
            Route::post('create',[ServiceController::class,'create']);
            Route::put('{id}/edit',[ServiceController::class,'edit']);
            Route::delete('{id}/delete',[ServiceController::class,'delete']);
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
