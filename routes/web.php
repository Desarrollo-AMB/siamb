<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\MilitarNoProf\ReingresosController;
use App\Http\Controllers\Auxiliares\CargosController;
use App\Http\Controllers\Auxiliares\UbicacionesController;
use App\Http\Controllers\Auxiliares\UniversidadesController;
use App\Http\Controllers\Auxiliares\ProfesionesController;
use App\Http\Controllers\Auxiliares\UbicacionesDetalladasController;
use App\Http\Controllers\CargaFamiliarController;
use App\Http\Controllers\CondecoracionesController;

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

    //PERSONAL MILITAR
    Route::get('/sireh/personal-militar/index', [PersonalController::class, 'indexPersonalMilitar'])->name('sireh.personal-militar.index');
    Route::get('/sireh/personal-militar/suspendidos/index', [PersonalController::class, 'listPersonalMilitarSuspendido'])->name('sireh.personal-militar.suspendido');
    Route::get('/sireh/personal-militar/bajas/index', [PersonalController::class, 'listPersonalMilitarBajas'])->name('sireh.personal-militar.bajas');
    Route::get('/sireh/personal-militar/escalafon', [PersonalController::class, 'escogerEscalafon'])->name('sireh.personal-militar.escalafon');
    Route::get('/sireh/personal-militar/view/{id}', [PersonalController::class, 'viewPersonalMilitar'])->name('sireh.personal-militar.view');
    Route::get('/sireh/personal-militar/edit/{id}', [PersonalController::class, 'editPersonalMilitar'])->name('sireh.personal-militar.edit');
    Route::get('/sireh/personal-militar/cargo/{id}', [PersonalController::class, 'cargosPersonalMilitar'])->name('sireh.personal-militar.cargo');
    Route::get('/sireh/personal-militar/ubicacion/{id}', [PersonalController::class, 'ubicacionesPersonalMilitar'])->name('sireh.personal-militar.ubicacion');
    Route::get('/sireh/personal-militar/baja/{id}', [PersonalController::class, 'bajaPersonalMilitar'])->name('sireh.personal-militar.baja');
    Route::post('/sireh/personal-militar/updatedatos', [PersonalController::class, 'updatePersonalMilitar'])->name('sireh.personal-militar.update.datos');
    Route::post('/sireh/personal-militar/updatecargo', [PersonalController::class, 'updateCargosPersonalMilitar'])->name('sireh.personal-militar.update.cargo');
    Route::post('/sireh/personal-militar/updateubicacion', [PersonalController::class, 'updateUbicacionesPersonalMilitar'])->name('sireh.personal-militar.update.ubicacion');
    Route::post('/sireh/personal-militar/suspender', [PersonalController::class, 'suspenderPersonalMilitar'])->name('sireh.personal-militar.suspender');
    Route::post('/sireh/personal-militar/activar', [PersonalController::class, 'activarPersonalMilitar'])->name('sireh.personal-militar.activar');
    Route::post('/sireh/personal-militar/darbaja', [PersonalController::class, 'darBajaPersonalMilitar'])->name('sireh.personal-militar.dar.baja');
    Route::post('/sireh/personal-militar/imprimirescalafon', [PersonalController::class, 'imprimirEscalafon'])->name('sireh.personal-militar.imprimirescalafon');

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



    //CRUD Tabla Universidades
    Route::get('/auxiliares/universidades', [UniversidadesController::class, 'index'])->name('auxiliares.universidades.index');
    Route::get('/auxiliares/universidades/create', [UniversidadesController::class, 'create'])->name('auxiliares.universidades.create');
    Route::post('/auxiliares/universidades/store', [UniversidadesController::class, 'store'])->name('auxiliares.universidades.store');
    Route::get('/auxiliares/universidades/edit/{id}', [UniversidadesController::class, 'edit'])->name('auxiliares.universidades.edit');
    Route::patch('/auxiliares/universidades/update/{universidad}', [UniversidadesController::class, 'update'])->name('auxiliares.universidades.update');
    Route::delete('/auxiliares/universidades/delete/{id}', [UniversidadesController::class, 'destroy'])->name('auxiliares.universidades.destroy');

    //CRUD Tabla Profesiones
    Route::get('/auxiliares/profesiones', [ProfesionesController::class, 'index'])->name('auxiliares.profesiones.index');
    Route::get('/auxiliares/profesiones/create', [ProfesionesController::class, 'create'])->name('auxiliares.profesiones.create');
    Route::post('/auxiliares/profesiones/store', [ProfesionesController::class, 'store'])->name('auxiliares.profesiones.store');
    Route::get('/auxiliares/profesiones/edit/{id}', [ProfesionesController::class, 'edit'])->name('auxiliares.profesiones.edit');
    Route::patch('/auxiliares/profesiones/update/{profesion}', [ProfesionesController::class, 'update'])->name('auxiliares.profesiones.update');
    Route::delete('/auxiliares/profesiones/delete/{id}', [ProfesionesController::class, 'destroy'])->name('auxiliares.profesiones.destroy');

    Route::get('/sireh/personal-militar-noprof/graduacion', [GraduacionController::class, 'index'])->name('sireh.personal-militar-noprof.graduacion');
    Route::post('/sireh/personal-militar-noprof/graduar', [GraduacionController::class, 'graduar'])->name('sireh.personal-militar-noprof.graduar');

    Route::get('/sireh/personal-militar-noprof/ascensos', [AscensosController::class, 'index'])->name('sireh.personal-militar-noprof.ascensos');
    Route::post('/sireh/personal-militar-noprof/ascender', [AscensosController::class, 'ascender'])->name('sireh.personal-militar-noprof.ascender');

    Route::get('/sireh/personal-militar-noprof/egresos-alistados', [EgresosController::class, 'indexAlistados'])->name('sireh.personal-militar-noprof.egresos-alistados');
    Route::post('/sireh/personal-militar-noprof/egresar-alistados', [EgresosController::class, 'egresarAlistados'])->name('sireh.personal-militar-noprof.egresar-alistados');

    Route::get('/sireh/personal-militar-noprof/view/{id}', [PersonalController::class, 'viewPersonalMilitarNoProf'])->name('sireh.personal-militar-noprof.view');
    Route::get('/sireh/personal-militar-noprof/edit/{id}', [PersonalController::class, 'editPersonalMilitarNoProf'])->name('sireh.personal-militar-noprof.edit');
    Route::get('/sireh/personal-militar/view/{id}', [PersonalController::class, 'viewPersonalMilitar'])->name('sireh.personal-militar.view');
    
    Route::post('/sireh/personal-militar/showData',     [PersonalController::class, 'showDataPersonalMilitar'])->name('sireh.personal-militar.showData');
    Route::post('/sireh/personal-militar/storeFuncion', [PersonalController::class, 'storeFuncionPersonalMilitar'])->name('sireh.personal-militar.storeFuncion');
    Route::post('/sireh/personal-militar/deleteFuncion',[PersonalController::class, 'deteleFuncionPersonalMilitar'])->name('sireh.personal-militar.deleteFuncion');

    Route::get('/sireh/personal-civilf/view/{id}',   [PersonalController::class, 'viewPersonalCivil'])->name('sireh.personal-civil.view');
    
    Route::get('/sireh/personal-civil/noActive',      [PersonalController::class, 'personalCivilNoActive'])->name('sireh.personal-civil.noActive');
    Route::get('/sireh/personal-civil/edit/{id}',     [PersonalController::class, 'editPersonalCivil'])->name('sireh.personal-civil.edit');
    Route::get('/sireh/personal-civil/evaluar/{id}',  [PersonalController::class, 'evaluarPersonalCivil'])->name('sireh.personal-civil.evaluar');
    Route::post('/sireh/personal-civil/storeEvaluar', [PersonalController::class, 'storeEvaluarPersonalCivil'])->name('sireh.personal-civil.storeEvaluar');
    Route::post('/sireh/personal-civil/egreso',       [PersonalController::class, 'egresoPersonalCivil'])->name('sireh.personal-civil.egreso');
    Route::post('/sireh/personal-civil/suspender',    [PersonalController::class, 'suspenderPersonalCivil'])->name('sireh.personal-civil.suspender');
    Route::post('/sireh/personal-civil/activar',      [PersonalController::class, 'activarPersonalCivil'])->name('sireh.personal-civil.activar');
    Route::post('/sireh/personal-civil/update',       [PersonalController::class, 'updatePersonalCivil'])->name('sireh.personal-civil.update');
    Route::post('/sireh/personal-civil/agregarCurso', [PersonalController::class, 'AgregarCursoPersonalCivil'])->name('sireh.personal-civil.agregarCurso');
    Route::post('/sireh/personal-civil/editarEvalua', [PersonalController::class, 'EditEvaluarPersonalCivil'])->name('sireh.personal-civil.editEvaluar');
    Route::post('/sireh/personal-civil/updateEvaluar',[PersonalController::class, 'updateEvaluarPersonalCivil'])->name('sireh.personal-civil.updateEvaluar');
    Route::post('/sireh/personal-civil/showJubilado', [PersonalController::class, 'showJubiladoPersonalCivil'])->name('sireh.personal-civil.showJubilado');
    Route::post('/sireh/personal-civil/storeJubilado',[PersonalController::class, 'storeJubiladoPersonalCivil'])->name('sireh.personal-civil.storeJubilado');

    Route::get('/sireh/personal-militar-noprof/reingresos', [ReingresosController::class, 'index'])->name('sireh.personal-militar-noprof.reingresos');

    Route::post('/sireh/personal-militar-noprof/update/{empleado}', [PersonalController::class, 'updatePersonalMilitarNoProf'])->name('sireh.personal-militar-noprof.update');
    Route::post('/sireh/personal-militar-noprof/egresar', [PersonalController::class, 'egresarMilitarNoProf'])->name('sireh.personal-militar-noprof.egresar');
    Route::post('/sireh/personal-militar-noprof/reingresar', [ReingresosController::class, 'reingresarMilitarNoProf'])->name('sireh.personal-militar-noprof.reingresar');

    Route::get('/sireh/carga-familiar/{id}', [CargaFamiliarController::class, 'cargaFamiliar'])->name('sireh.carga-familiar.view');
    Route::post('/sireh/cargar-familiar/store', [CargaFamiliarController::class, 'storeCargarFamiliar'])->name('sireh.cargar-familiar.store');
    Route::get('/sireh/carga-familiar/edit/{id}', [CargaFamiliarController::class, 'editCargaFamiliar'])->name('sireh.carga-familiar.edit');
    Route::delete('/sireh/carga-familiar/delete/{id}', [CargaFamiliarController::class, 'destroy'])->name('sireh.carga-familiar.destroy');

    Route::get('/sireh/condecoraciones/{id}', [CondecoracionesController::class, 'indexView'])->name('sireh.condecoraciones.view');
    Route::post('/sireh/condecoraciones/store', [CondecoracionesController::class, 'store'])->name('sireh.condecoraciones.store');
    Route::get('/sireh/condecoraciones/edit/{id}', [CondecoracionesController::class, 'edit'])->name('sireh.condecoraciones.edit');
    Route::delete('/sireh/condecoraciones/delete/{id}', [CondecoracionesController::class, 'destroy'])->name('sireh.condecoraciones.destroy');
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
