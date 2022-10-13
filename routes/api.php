<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('personal/empleadosnotuser', [PersonalController::class, 'empleadosSinUser'])->name('personal.empleados.notuser');
Route::get('personal/notempleadosnotuser', [PersonalController::class, 'notEmpleadosSinUser'])->name('personal.not-empleados.notuser');
Route::get("ciudades/{estado_id}", [ApiController::class, 'getListCiudades'])->name("api.ciudades");