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
use App\Http\Controllers\Civil\JubiladosController;
use App\Http\Controllers\Civil\EvaluacionesCivilController;
use App\Http\Controllers\Parte\PartegeneralController;
use App\Http\Controllers\ReportesBSController;
use App\Http\Controllers\Nomina\NominaController;


use App\Http\Controllers\juntaperm\controllerjuntap;

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
    ////////////////////////////////////////////////////////////////////NOMINA///////////////////////////////////////////////////////////////////////
    Route::get('/sireh/nomina/index', [NominaController::class, 'indexNomina'])->name('sireh.nomina.index');
    Route::get('/sireh/nomina/militar', [NominaController::class, 'militarNomina'])->name('sireh.nomina.militar');

    //JUNTA P
    Route::get('/juntapermanente/personalmilitar/index', [controllerjuntap::class, 'indexPersonalMilitarasc'])->name('juntap.personalm.index');
    Route::post('/juntapermanente/personalmilitar/ascender', [controllerjuntap::class, 'ascenderPersonalMilitar'])->name('juntap.personalm.ascenderlos');
    Route::post('/juntapermanente/personalmilitar/ascenderd', [controllerjuntap::class, 'ascDataPersonalMilitar'])->name('juntap.personalm.datas');


    Route::get('/juntapermanente/ascenso', [controllerjuntap::class, 'juntap'])->name('juntap.ascenso.index');
    Route::get('/juntapermanente/reportes', [controllerjuntap::class, 'indexreporte'])->name('juntap.reportes.index');

    Route::get('/juntapermanente/selector', [controllerjuntap::class, 'asccategoria'])->name('juntap.ascenso.categoria');
    Route::get('/juntapermanente/ascenso/julio', [controllerjuntap::class, 'ascjulio'])->name('juntap.ascenso.julio');

    Route::post('/juntapermanente/ascenso/julio/categoria', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.select');

    Route::get('/juntapermanente/ascenso/julio/comando', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.julio.comando');
    Route::get('/juntapermanente/ascenso/julio/tecnico', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.julio.tecnico');
    Route::get('/juntapermanente/ascenso/julio/ofitropa', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.julio.ofitropa');
    Route::get('/juntapermanente/ascenso/julio/asitecnico', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.julio.asitecnico');
    Route::get('/juntapermanente/ascenso/julio/asimilado', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.julio.asimilado');
    Route::get('/juntapermanente/ascenso/julio/tropap', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.julio.tropap');
    Route::get('/juntapermanente/ascenso/diciembre/ofitropa', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.diciembre.ofitropa');
    Route::get('/juntapermanente/ascenso/diciembre/asitecnico', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.diciembre.asitecnico');
    Route::get('/juntapermanente/ascenso/diciembre/asimilado', [controllerjuntap::class, 'ascselect'])->name('juntap.ascenso.diciembre.asimilado');

   // Route::get('/juntapermanente/ascenso/julio', [controllerjuntap::class, 'select'])->name('juntap.ascenso.julio');
    //Route::get('/juntapermanente/ascenso/julio', [controllerjuntap::class, 'select'])->name('juntap.ascenso.julio.select');
    Route::get('/juntapermanente/ascenso/reportes/reporteascenso', [controllerjuntap::class, 'reportenasc'])->name('juntap.reportes.reporteascenso');
    Route::post('/juntapermanente/ascenso/reportes/reporteascensos', [controllerjuntap::class, 'descargarEmpleados'])->name('juntap.reportes.ascrreporte');
    Route::get('/juntapermanente/ascenso/diciembre', [controllerjuntap::class, 'ascdiciembre'])->name('juntap.ascenso.diciembre');

    Route::post('/juntapermanente/reportespdf', [controllerjuntap::class, 'ascreporter2'])->name('juntap.reportes.reporteascPDF');


    //Route::get('/juntapermanente/ascenso', [juntaperm\controllerjuntap::class, 'index'])->name('juntap.ascenso.index');
    //Route::get('/juntapermanente/reportes', [juntaperm\controllerjuntap::class, 'index'])->name('juntap.reportes.index');
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



    //Parte General//

    Route::get('/sireh/personal-militar/parte', [PartegeneralController::class, 'index'])->name('sireh.personal.militar.parte.index');
    Route::get('/sireh/personal-militar/parte/create', [PartegeneralController::class, 'indexparte'])->name('sireh.personal.militar.parte.create');
    Route::post('/sireh/personal-militar/parte/create/store', [PartegeneralController::class, 'store'])->name('sireh.personal.militar.parte');

    //Reporte de Parte General////
    Route::post('/sireh/personal-militar/parte/reporte/reporteParteUnidad', [PartegeneralController::class, 'reporteParteUnidad'])->name('sireh.personal.militar.parte.reporte.reporteParteUnidad');
    Route::get('/sireh/personal-militar/parte/reporte/reportes', [PartegeneralController::class, 'ParteReportes'])->name('sireh.personal.militar.parte.reporte.reportes');
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('/sireh/personal-militar-noprof/graduacion', [GraduacionController::class, 'index'])->name('sireh.personal-militar-noprof.graduacion');
    Route::post('/sireh/personal-militar-noprof/graduar', [GraduacionController::class, 'graduar'])->name('sireh.personal-militar-noprof.graduar');

    Route::get('/sireh/personal-militar-noprof/ascensos', [AscensosController::class, 'index'])->name('sireh.personal-militar-noprof.ascensos');
    Route::post('/sireh/personal-militar-noprof/ascender', [AscensosController::class, 'ascender'])->name('sireh.personal-militar-noprof.ascender');

    Route::get('/sireh/personal-militar-noprof/egresos-alistados', [EgresosController::class, 'indexAlistados'])->name('sireh.personal-militar-noprof.egresos-alistados');
    Route::post('/sireh/personal-militar-noprof/egresar-alistados', [EgresosController::class, 'egresarAlistados'])->name('sireh.personal-militar-noprof.egresar-alistados');

    Route::get('/sireh/personal-militar-noprof/view/{id}', [PersonalController::class, 'viewPersonalMilitarNoProf'])->name('sireh.personal-militar-noprof.view');
    Route::get('/sireh/personal-militar-noprof/edit/{id}', [PersonalController::class, 'editPersonalMilitarNoProf'])->name('sireh.personal-militar-noprof.edit');
<<<<<<< HEAD
    Route::get('/sireh/personal-militar/view/{id}', [PersonalController::class, 'viewPersonalMilitar'])->name('sireh.personal-militar.view');
=======
>>>>>>> 0776901 (Reportes Bienestar Social)


    Route::post('/sireh/personal-militar/showData',     [PersonalController::class, 'showDataPersonalMilitar'])->name('sireh.personal-militar.showData');
    Route::post('/sireh/personal-militar/storeFuncion', [PersonalController::class, 'storeFuncionPersonalMilitar'])->name('sireh.personal-militar.storeFuncion');
    Route::post('/sireh/personal-militar/deleteFuncion',[PersonalController::class, 'deteleFuncionPersonalMilitar'])->name('sireh.personal-militar.deleteFuncion');

    Route::get('/sireh/personal-civil/view/{id}',   [PersonalController::class, 'viewPersonalCivil'])->name('sireh.personal-civil.view');

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
    Route::get('/sireh/personal-civil/evaluaciones/index', [EvaluacionesCivilController::class, 'evaluacionesFecha'])->name('sireh.personal-civil.evaluaciones.index');
    Route::post('/sireh/personal-civil/evaluaciones/reporte-excel', [EvaluacionesCivilController::class, 'evaluacionesReportExcel'])->name('sireh.personal-civil-evaluaciones.reporte.excel');
    Route::get('/sireh/personal-civil/jubilables/index', [JubiladosController::class, 'indexJubilablesCivil'])->name('sireh.personal-civil-jubilables.index');
    Route::post('/sireh/personal-civil/showJubilado', [JubiladosController::class, 'showJubiladoPersonalCivil'])->name('sireh.personal-civil.showJubilado');
    Route::post('/sireh/personal-civil/storeJubilado',[JubiladosController::class, 'storeJubiladoPersonalCivil'])->name('sireh.personal-civil.storeJubilado');
    Route::get('/sireh/personal-civil/jubilados/fecha-jubilados', [JubiladosController::class, 'jubiladosFecha'])->name('sireh.personal-civil.jubilados.fecha-jubilados');
    Route::post('/sireh/personal-civil/jubilados/reporte-excel-jubilado', [JubiladosController::class, 'jubiladosReportExcel'])->name('sireh.personal-civil-jubilados.reporte.excel');
    Route::get('/sireh/personal-civil/jubilados/por-jubilar', [JubiladosController::class, 'porJubilarReportExcel'])->name('sireh.personal-civil-jubilados.por.jubilar');

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

    Route::get('/sireh/personal-militar/reportes', [PersonalController::class, 'reportesPersonalMilitarView'])->name('sireh.personal-militar.reportes');
    Route::post('/sireh/personal-militar/reportes', [PersonalController::class, 'reportesPersonalMilitar'])->name('sireh.personal-militar.reportes.ejecutar');

    Route::get('/bienestar-social/reportes', [ReportesBSController::class, 'reportesBienestarSocial'])->name('bienestar-social.reportes');

    Route::get('/sireh/personal-militar-noprof/reportes', [PersonalController::class, 'reportesPersonalMilitarNoProfView'])->name('sireh.personal-militar-noprof.reportes');

});


Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfilesController::class, 'show'])->name('profile');
    Route::post('update-profile/{user}', [ProfilesController::class, 'updateProfile'])->name('profile.update');

});


//RUTA FORMULARIO FAM002

Route::group(['middleware' => ['auth']], function() {
    Route::get('fam0001',                   [FormaFAMController::class, 'fam0001'])->name('fam0001');

    //RUTAS DAO
    Route::get('/dao/index', [FormaFAMController::class, 'daoIndex'])->name('dao.index');
    Route::get('/dao/militar', [FormaFAMController::class, 'daoMilitar'])->name('dao.militar');
    Route::get('/dao/aeronaves', [FormaFAMController::class, 'daoAeronaves'])->name('dao.aeronaves');
    Route::get('/dao/ver-programacion', [FormaFAMController::class, 'verProgramacion'])->name('dao.ver_programacion');
    Route::get('/dao/nueva-programacion', [FormaFAMController::class, 'nuevaProgramacion'])->name('dao.nuevaProgramacion');
    Route::get('/dao/imprimir-programacion', [FormaFAMController::class, 'imprimirProgramacion'])->name('dao.imprimirProgramacion');
    Route::get('/dao/editar-programacion/{fam_id}', [FormaFAMController::class, 'editProgramacion'])->name('dao.editProgramacion');
    Route::post('programacion_data', [FormaFAMController::class, 'programacion_data'])->name('programacion_data');
    Route::post('store_programacion', [FormaFAMController::class, 'storeProgramacion'])->name('store_programacion');
    Route::post('enviar-programacion-dao', [FormaFAMController::class, 'enviarProgramacionDao'])->name('enviarProgramacionDao');
    Route::post('enviar-reporte-ceo',             [FormaFAMController::class, 'enviarReporteCeo'])->name('enviarReporteCeo');
    Route::post('revisar-programacion',             [FormaFAMController::class, 'revisarProgramacion'])->name('revisarProgramacion');

    //Route::group(['middleware' => ['role:aviacion']], function () {
        Route::get('FormaFAM',                  [FormaFAMController::class, 'index'])->name('FormaFAM');
        Route::get('FormaFAM_status/{fam_id}',  [FormaFAMController::class, 'FormaFAM_status'])->name('FormaFAM.status');

    //});
    Route::get('aeronaves_grupos',          [FormaFAMController::class, 'aeronaves_grupos'])->name('aeronaves_grupos');
    Route::get('seriales',                  [FormaFAMController::class, 'seriales'])->name('seriales');
    Route::get('matriculas',                [FormaFAMController::class, 'matriculas'])->name('matriculas');
    Route::get('matriculasAlternas',                [FormaFAMController::class, 'matriculasAlternas'])->name('matriculasAlternas');

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
    Route::get('dao/forms/listado_pilotos',     [FormaFAMController::class, 'listado_pilotos'])->name('dao.forms.listado_pilotos');
    Route::get('dao/forms/ver_listado_piloto/{id}',     [FormaFAMController::class, 'ver_listado_piloto'])->name('dao.forms.ver_listado_piloto');
    Route::get('dao/forms/reporte_vuelos/{id}',     [FormaFAMController::class, 'reporte_vuelos'])->name('dao.forms.reporte_vuelos');
    Route::post('dao/forms/imprimir_reporte',     [FormaFAMController::class, 'imprimir_reporte'])->name('dao.forms.imprimir_reporte');

});

Route::get('no_authorize', function () {
    return view('no_authorize');
})->name('no_authorize');

Route::post('/bienestar-social/reporte/devolucion5', [ReportesBSController::class, 'reporteDevolucion5'])->name('bienestar-social.reporte.devolucion5');
Route::post('/bienestar-social/reporte/cargafamiliar', [ReportesBSController::class, 'reporteCargaFamiliar'])->name('bienestar-social.reporte.cargafamiliar');
Route::post('/bienestar-social/reporte/bajas', [ReportesBSController::class, 'reporteBajas'])->name('bienestar-social.reporte.bajas');
Route::post('/sireh/personal-militar-noprof/reporte-jerarquia-ubicacion', [PersonalController::class, 'reportePersonalMilitarNoProfJerarquiaUbicacion'])->name('sireh.personal-militar-noprof.reporte.jeraquia-ubicacion');
