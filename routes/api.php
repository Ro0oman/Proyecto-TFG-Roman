<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\allcpuController;
use App\Http\Controllers\MotherboardController;
use App\Http\Controllers\GraficaController;
use App\Http\Controllers\RamController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\PsuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::middleware('auth:sanctum')->group(function(){
    // El usuario tiene que estar logueado para poder acceder al grupo
    Route::get('/user', function(Request $request){
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/userPCS/{id}', [ComputerController::class, 'getIdPc']);
Route::get('/getPCS', [ComputerController::class, 'getPCS']);
Route::get('/getGameID/{id}', [ComputerController::class, 'getGameID']);


/* Como funciona el resource 

GET|HEAD        api/user ................................ user.index › UserController@index  
POST            api/user ................................ user.store › UserController@store  
GET|HEAD        api/user/create ....................... user.create › UserController@create  
GET|HEAD        api/user/{user} ........................... user.show › UserController@show  
PUT|PATCH       api/user/{user} ....................... user.update › UserController@update  
DELETE          api/user/{user} ..................... user.destroy › UserController@destroy  
GET|HEAD        api/user/{user}/edit ...................... user.edit › UserController@edit  
*/

Route::resources([
    'user' => UserController::class,
]);
Route::resources([
    'computer' => ComputerController::class,
]);
Route::resources([
    'cpu' => allcpuController::class,
]);
Route::resources([
    'motherboard' => MotherboardController::class,
]);
Route::resources([
    'gpu' => GraficaController::class,
]);
Route::resources([
    'ram' => RamController::class,
]);
Route::resources([
    'storage' => StorageController::class,
]);
Route::resources([
    'psu' => PsuController::class,
]);