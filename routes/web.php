<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FormaFAMController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\MilitarNoProf\GraduacionController;
use App\Http\Controllers\MilitarNoProf\AscensosController;
use App\Http\Controllers\MilitarNoProf\EgresosController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()) {
        return redirect('/home');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [LoginController::class, 'logout']);
Route::group(['middleware' => ['auth','access']], function() {

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::delete('permissions', [PermissionController::class, 'clean'])->name('permissions.clean'); 
    
    Route::get('/sireh/ingreso_personal/index', [PersonalController::class, 'index'])->name('sireh.ingreso-personal.index');
    Route::get('/sireh/ingreso_personal/new', [PersonalController::class, 'ingresoPersonal'])->name('sireh.ingreso-personal.new');
    Route::post('/sireh/ingreso_personal/store', [PersonalController::class, 'registraPersonal'])->name('sireh.ingreso-personal.store');
    Route::get('/sireh/ingreso_personal/edit/{id}', [PersonalController::class, 'editIngresoPersonal'])->name('sireh.ingreso-personal.edit');
    Route::post('/sireh/ingreso_personal/update/{empleado}', [PersonalController::class, 'updatePersonal'])->name('sireh.ingreso-personal.update');
    Route::delete('/sireh/ingreso_personal/delete/{empleado}', [PersonalController::class, 'destroy'])->name('sireh.ingreso-personal.destroy');
    Route::post('/sireh/ingreso_personal/activar/{empleado}', [PersonalController::class, 'activarIngreso'])->name('sireh.ingreso-personal.activar');

    Route::get('/sireh/personal-militar/index', [PersonalController::class, 'indexPersonalMilitar'])->name('sireh.personal-militar.index');
    Route::get('/sireh/personal-civil/index', [PersonalController::class, 'indexPersonalCivil'])->name('sireh.personal-civil.index');
    Route::get('/sireh/personal-militar-noprof/index', [PersonalController::class, 'indexPersonalMilitarNoProf'])->name('sireh.personal-militar-noprof.index');

    Route::get('/sireh/auxiliares', [PersonalController::class, 'auxiliares'])->name('sireh.auxiliares');
    
    //CRUD Tabla Cargos
    Route::get('/sireh/cargos', [PersonalController::class, 'cargosIndex'])->name('sireh.cargos');
    Route::get('/sireh/cargos/create', [PersonalController::class, 'createCargo'])->name('sireh.cargos.create');
    Route::post('/sireh/cargos/store', [PersonalController::class, 'storeCargo'])->name('sireh.cargos.store');
    Route::get('/sireh/cargos/edit/{id}', [PersonalController::class, 'editCargo'])->name('sireh.cargos.edit');
    Route::post('/sireh/cargos/update/{cargo}', [PersonalController::class, 'updateCargo'])->name('sireh.cargos.update');
    Route::delete('/sireh/cargos/delete/{cargo}', [PersonalController::class, 'destroyCargo'])->name('sireh.cargos.destroy');

    //CRUD Tabla Ubicaciones
    Route::get('/sireh/ubicaciones', [PersonalController::class, 'ubicacionesIndex'])->name('sireh.ubicaciones');
    Route::get('/sireh/ubicaciones/create', [PersonalController::class, 'createUbicacion'])->name('sireh.ubicaciones.create');
    Route::post('/sireh/ubicaciones/store', [PersonalController::class, 'storeUbicacion'])->name('sireh.ubicaciones.store');
    Route::get('/sireh/ubicaciones/edit/{id}', [PersonalController::class, 'editUbicacion'])->name('sireh.ubicaciones.edit');
    Route::post('/sireh/ubicaciones/update/{ubicacion}', [PersonalController::class, 'updateUbicacion'])->name('sireh.ubicaciones.update');
    Route::delete('/sireh/ubicaciones/delete/{ubicacion}', [PersonalController::class, 'destroyUbicacion'])->name('sireh.ubicaciones.destroy');

    Route::get('/sireh/personal-militar-noprof/graduacion', [GraduacionController::class, 'index'])->name('sireh.personal-militar-noprof.graduacion');
    Route::post('/sireh/personal-militar-noprof/graduar', [GraduacionController::class, 'graduar'])->name('sireh.personal-militar-noprof.graduar');

    Route::get('/sireh/personal-militar-noprof/ascensos', [AscensosController::class, 'index'])->name('sireh.personal-militar-noprof.ascensos');
    Route::post('/sireh/personal-militar-noprof/ascender', [AscensosController::class, 'ascender'])->name('sireh.personal-militar-noprof.ascender');

    Route::get('/sireh/personal-militar-noprof/egresos', [EgresosController::class, 'index'])->name('sireh.personal-militar-noprof.egresos');
    Route::post('/sireh/personal-militar-noprof/egresar', [EgresosController::class, 'egresar'])->name('sireh.personal-militar-noprof.egresar');
});


Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', function () {
		return view('home');
	})->name('dashboard');
    Route::get('profile', [ProfilesController::class, 'show'])->name('profile');
    Route::post('update-profile/{user}', [ProfilesController::class, 'updateProfile'])->name('profile.update');
     
});

//RUTA FORMULARIO FAM002 

Route::group(['middleware' => ['auth']], function() {
    Route::get('fam0001',                   [FormaFAMController::class, 'fam0001'])->name('fam0001');

    Route::get('FormaFAM',                  [FormaFAMController::class, 'index'])->name('FormaFAM');
    Route::get('FormaFAM_status/{fam_id}',  [FormaFAMController::class, 'FormaFAM_status'])->name('FormaFAM.status');
    Route::get('aeronaves_grupos',          [FormaFAMController::class, 'aeronaves_grupos'])->name('aeronaves_grupos'); 
    Route::get('seriales',                  [FormaFAMController::class, 'seriales'])->name('seriales'); 
    Route::get('matriculas',                [FormaFAMController::class, 'matriculas'])->name('matriculas'); 

    Route::post('steps',                    [FormaFAMController::class, 'steps'])->name('steps'); 
    Route::post('steps_status',             [FormaFAMController::class, 'steps_status'])->name('steps_status'); 
    Route::post('store_header',             [FormaFAMController::class, 'store'])->name('store_header'); 
    Route::post('store_a1',                 [FormaFAMController::class, 'store_a1'])->name('store_a1'); 
    Route::post('consumibles',              [FormaFAMController::class, 'consumibles'])->name('consumibles'); 
    Route::post('store_a1_consumibles',     [FormaFAMController::class, 'store_a1_consumibles'])->name('store_a1_consumibles');
    Route::post('delete_a1_mision',         [FormaFAMController::class, 'delete_a1_mision'])->name('delete_a1_mision');  
    Route::post('editar_a1_mision',         [FormaFAMController::class, 'editar_a1_mision'])->name('editar_a1_mision');
    Route::post('actualizar_a1_mision',     [FormaFAMController::class, 'actualizar_a1_mision'])->name('actualizar_a1_mision');  
    Route::post('editar_paso1',             [FormaFAMController::class, 'editar_paso1'])->name('editar_paso1');  
    
    Route::post('codigos_mision_json',      [FormaFAMController::class, 'codigos_mision_json'])->name('codigos_mision_json'); 
    Route::post('tripulante_funcion',       [FormaFAMController::class, 'tripulante_funcion'])->name('tripulante_funcion'); 
    Route::post('data_vuelo',               [FormaFAMController::class, 'data_vuelo'])->name('data_vuelo'); 
    Route::post('data_v_trip',              [FormaFAMController::class, 'data_v_trip'])->name('data_v_trip'); 
    Route::post('store_b1',                 [FormaFAMController::class, 'store_b1'])->name('store_b1'); 
    Route::post('store_aterrizaje',         [FormaFAMController::class, 'store_aterrizaje'])->name('store_aterrizaje'); 
    Route::post('codigos_aterrizaje_json',  [FormaFAMController::class, 'codigos_aterrizaje_json'])->name('codigos_aterrizaje_json'); 
    Route::post('datos_empleado_vuelo',     [FormaFAMController::class, 'datos_empleado_vuelo'])->name('datos_empleado_vuelo'); 

    Route::post('editar_b1',                [FormaFAMController::class, 'editar_b1'])->name('editar_b1'); 
    Route::post('actualizar_b1',            [FormaFAMController::class, 'actualizar_b1'])->name('actualizar_b1');  
    Route::post('delete_b1',                [FormaFAMController::class, 'delete_b1'])->name('delete_b1');  
    
    Route::post('store_a3',                 [FormaFAMController::class, 'store_a3'])->name('store_a3'); 
    Route::post('delete_a3',                [FormaFAMController::class, 'delete_a3'])->name('delete_a3');  
    Route::post('editar_a3',                [FormaFAMController::class, 'editar_a3'])->name('editar_a3'); 
    Route::post('actualizar_a3',            [FormaFAMController::class, 'actualizar_a3'])->name('actualizar_a3');  
    
    Route::post('pasoFinal',                [FormaFAMController::class, 'pasoFinal'])->name('pasoFinal');  

});

Route::get('no_authorize', function () {
    return view('no_authorize');
})->name('no_authorize');