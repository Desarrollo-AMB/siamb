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
use App\Http\Controllers\Auxiliares\CargosController;
use App\Http\Controllers\Auxiliares\UbicacionesController;
use App\Http\Controllers\Auxiliares\UbicacionesDetalladasController;
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

    Route::get('/auxiliares', [HomeController::class, 'auxiliares'])->name('auxiliares');

    //CRUD Tabla Cargos
    Route::get('/auxiliares/cargos', [CargosController::class, 'index'])->name('auxiliares.cargos.index');
    Route::get('/auxiliares/cargos/create', [CargosController::class, 'create'])->name('auxiliares.cargos.create');
    Route::post('/auxiliares/cargos/store', [CargosController::class, 'store'])->name('auxiliares.cargos.store');
    Route::get('/auxiliares/cargos/edit/{id}', [CargosController::class, 'edit'])->name('auxiliares.cargos.edit');
    Route::post('/auxiliares/cargos/update/{cargo}', [CargosController::class, 'update'])->name('auxiliares.cargos.update');
    Route::delete('/auxiliares/cargos/delete/{id}', [CargosController::class, 'destroy'])->name('auxiliares.cargos.destroy');

    //CRUD Tabla Ubicaciones
    Route::get('/auxiliares/ubicaciones', [UbicacionesController::class, 'index'])->name('auxiliares.ubicaciones.index');
    Route::get('/auxiliares/ubicaciones/create', [UbicacionesController::class, 'create'])->name('auxiliares.ubicaciones.create');
    Route::post('/auxiliares/ubicaciones/store', [UbicacionesController::class, 'store'])->name('auxiliares.ubicaciones.store');
    Route::get('/auxiliares/ubicaciones/edit/{id}', [UbicacionesController::class, 'edit'])->name('auxiliares.ubicaciones.edit');
    Route::patch('/auxiliares/ubicaciones/update/{ubicacion}', [UbicacionesController::class, 'update'])->name('auxiliares.ubicaciones.update');
    Route::delete('/auxiliares/ubicaciones/delete/{id}', [UbicacionesController::class, 'destroy'])->name('auxiliares.ubicaciones.destroy');
    //CRUD Tabla Ubicaciones_detalladas
    Route::get('/auxiliares/ubicacionesDetalladas', [UbicacionesDetalladasController::class, 'index'])->name('auxiliares.ubicacionesDetalladas.index');
    Route::get('/auxiliares/ubicacionesDetalladas/create', [UbicacionesDetalladasController::class, 'create'])->name('auxiliares.ubicacionesDetalladas.create');
    Route::post('/auxiliares/ubicacionesDetalladas/store', [UbicacionesDetalladasController::class, 'store'])->name('auxiliares.ubicacionesDetalladas.store');
    Route::get('/auxiliares/ubicacionesDetalladas/edit/{id}', [UbicacionesDetalladasController::class, 'edit'])->name('auxiliares.ubicacionesDetalladas.edit');
    Route::patch('/auxiliares/ubicacionesDetalladas/update/{ubicacionesDetalladas}', [UbicacionesDetalladasController::class, 'update'])->name('auxiliares.ubicacionesDetalladas.update');
    Route::delete('/auxiliares/ubicacionesDetalladas/delete/{id}', [UbicacionesDetalladasController::class, 'destroy'])->name('auxiliares.ubicacionesDetalladas.destroy');



    Route::get('/sireh/personal-militar-noprof/graduacion', [GraduacionController::class, 'index'])->name('sireh.personal-militar-noprof.graduacion');
    Route::post('/sireh/personal-militar-noprof/graduar', [GraduacionController::class, 'graduar'])->name('sireh.personal-militar-noprof.graduar');

    Route::get('/sireh/personal-militar-noprof/ascensos', [AscensosController::class, 'index'])->name('sireh.personal-militar-noprof.ascensos');
    Route::post('/sireh/personal-militar-noprof/ascender', [AscensosController::class, 'ascender'])->name('sireh.personal-militar-noprof.ascender');

    Route::get('/sireh/personal-militar-noprof/egresos', [EgresosController::class, 'index'])->name('sireh.personal-militar-noprof.egresos');
    Route::post('/sireh/personal-militar-noprof/egresar', [EgresosController::class, 'egresar'])->name('sireh.personal-militar-noprof.egresar');

    Route::get('/sireh/personal-militar-noprof/view/{id}', [PersonalController::class, 'viewPersonalMilitarNoProf'])->name('sireh.personal-militar-noprof.view');
    Route::get('/sireh/personal-militar/view/{id}', [PersonalController::class, 'viewPersonalMilitar'])->name('sireh.personal-militar.view');
    Route::get('/sireh/personal-civilf/view/{id}', [PersonalController::class, 'viewPersonalCivil'])->name('sireh.personal-civil.view');
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

    Route::group(['middleware' => ['role:aviacion']], function () {
        Route::get('FormaFAM',              [FormaFAMController::class, 'index'])->name('FormaFAM');
    });
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
