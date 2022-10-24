<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\GraduacionController;
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
Route::get("grados-militares/{tipo_emp}", [ApiController::class, 'getGradosMilitares'])->name("api.gradops_militares");
Route::get('sireh/empleadosinactivos', [PersonalController::class, 'empleadosInactivos'])->name('sireh.empleados.inactivos');
Route::get('sireh/personalmilitar', [PersonalController::class, 'personalMilitar'])->name('sireh.personal.militar.data');
Route::get('sireh/personalcivil', [PersonalController::class, 'personalCivil'])->name('sireh.personal.civil.data');
Route::get('sireh/personalmilitarnoprof', [PersonalController::class, 'personalMilitarNoProf'])->name('sireh.personal.militar-noprof.data');

Route::get('sireh/cargos/data', [PersonalController::class, 'cargosData'])->name('sireh.cargos.data');

Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_comando', [GraduacionController::class, 'getOficialesComando'])->name('sireh.militar-noprof.graduacion.dataOficialesComando');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tecnicos_medicina', [GraduacionController::class, 'getOficialesTecnicosMedicina'])->name('sireh.militar-noprof.graduacion.dataOficialesTecnicosMedicina');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tecnicos_salud', [GraduacionController::class, 'getOficialesTecnicosSalud'])->name('sireh.militar-noprof.graduacion.dataOficialesTecnicosSalud');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tecnicos', [GraduacionController::class, 'getOficialesTecnicos'])->name('sireh.militar-noprof.graduacion.dataOficialesTecnicos');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tropa', [GraduacionController::class, 'getOficialesTropa'])->name('sireh.militar-noprof.graduacion.dataOficialesTropa');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_asimilados', [GraduacionController::class, 'getOficialesAsimilados'])->name('sireh.militar-noprof.graduacion.dataOficialesAsimilados');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tropa_profesional', [GraduacionController::class, 'getOficialesTropaProfesional'])->name('sireh.militar-noprof.graduacion.dataOficialesTropaProfesional');