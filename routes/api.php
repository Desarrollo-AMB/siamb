<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\MilitarNoProf\GraduacionController;
use App\Http\Controllers\MilitarNoProf\AscensosController;
use App\Http\Controllers\MilitarNoProf\EgresosController;
use App\Http\Controllers\MilitarNoProf\ReingresosController;
use App\Http\Controllers\Auxiliares\CargosController;
use App\Http\Controllers\Auxiliares\UniversidadesController;
use App\Http\Controllers\Auxiliares\ProfesionesController;
use App\Http\Controllers\Auxiliares\UbicacionesController;
use App\Http\Controllers\Auxiliares\UbicacionesDetalladasController;
use App\Http\Controllers\CargaFamiliarController;
use App\Http\Controllers\CondecoracionesController;
use App\Http\Controllers\FormaFAMController;
use App\Http\Controllers\Civil\JubiladosController;
use App\Http\Controllers\empleadoExtraComponeteController;
use App\Http\Controllers\Nomina\militarControllers;
use App\Http\Controllers\PartegeneralController;
use App\Http\Controllers\juntaperm\controllerjuntap;

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

Route::get('personal/empleadosnotuser', [PersonalController::class, 'empleadosSinUser'])->name('api.personal.empleados.notuser');
Route::get('personal/notempleadosnotuser', [PersonalController::class, 'notEmpleadosSinUser'])->name('api.personal.not-empleados.notuser');
Route::get("ciudades/{estado_id}", [ApiController::class, 'getListCiudades'])->name("api.ciudades");
Route::get("grados-militares/{tipo_emp?}", [ApiController::class, 'getGradosMilitares'])->name("api.grados_militares");
Route::get("grados-militares-persmil/{tipo_emp?}", [ApiController::class, 'getGradosMilitaresPersMil'])->name("api.grados_militares_persmil");
Route::get('sireh/empleadosinactivos', [PersonalController::class, 'empleadosInactivos'])->name('api.sireh.empleados.inactivos');
Route::get('sireh/personal-militar/index', [PersonalController::class, 'personalMilitar'])->name('api.sireh.personal.militar.data');
Route::get('sireh/personalcivil', [PersonalController::class, 'personalCivil'])->name('api.sireh.personal.civil.data');
Route::get('sireh/personalmilitarnoprof', [PersonalController::class, 'personalMilitarNoProf'])->name('api.sireh.personal.militar-noprof.data');

Route::get('auxiliares/cargos/data', [CargosController::class, 'cargosData'])->name('api.auxiliares.cargos.data');
Route::get("categoria/{tipo_emp}", [ApiController::class, 'getCategoriasMilitares'])->name("api.categoria");
Route::get("promociones-militares/{categoria}", [ApiController::class, 'getPromocionesMilitares'])->name("api.promociones");
Route::get("ubicaciones-detalladas/{ubicacion}", [ApiController::class, 'getUbicacionesDetalladas'])->name("api.ubicaciones.detalladas");

Route::get('sireh/personalmilitar/suspendidos', [PersonalController::class, 'personalMilitarSuspendido'])->name('api.sireh.personal.militar.suspendidos');
Route::get('sireh/personalmilitar/bajas', [PersonalController::class, 'personalMilitarBaja'])->name('api.sireh.personal.militar.bajas');

Route::get('auxiliares/universidades/data', [UniversidadesController::class, 'universidadesData'])->name('api.auxiliares.universidades.data');
Route::get('auxiliares/profesiones/data', [ProfesionesController::class, 'profesionesData'])->name('api.auxiliares.profesiones.data');

//parteGeneral//
Route::get('sireh/personal-militar/parte', [PartegeneralController::class, 'PartegeneralData'])->name('api.sireh.personal.militar.parte.data');
//ubucaciones//
Route::get('auxiliares/ubicaciones/data', [UbicacionesController::class, 'ubicacionesData'])->name('api.auxiliares.ubicaciones.data');
//Ubicaciones_detalladas////
Route::get('auxiliares/ubicacionesDetalladas/data', [UbicacionesDetalladasController::class, 'ubicacionesDetalladasData'])->name('api.auxiliares.ubicacionesDetalladas.data');

////////////////////////////////////////////////////NOMINA////////////////////////
Route::get('sireh/nomina/data', [NominaController::class, 'NominaData'])->name('api.nomina.data');

Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_comando', [GraduacionController::class, 'getOficialesComando'])->name('api.sireh.militar-noprof.graduacion.dataOficialesComando');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tecnicos_medicina', [GraduacionController::class, 'getOficialesTecnicosMedicina'])->name('api.sireh.militar-noprof.graduacion.dataOficialesTecnicosMedicina');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tecnicos_salud', [GraduacionController::class, 'getOficialesTecnicosSalud'])->name('api.sireh.militar-noprof.graduacion.dataOficialesTecnicosSalud');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tecnicos', [GraduacionController::class, 'getOficialesTecnicos'])->name('api.sireh.militar-noprof.graduacion.dataOficialesTecnicos');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tropa', [GraduacionController::class, 'getOficialesTropa'])->name('api.sireh.militar-noprof.graduacion.dataOficialesTropa');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_asimilados', [GraduacionController::class, 'getOficialesAsimilados'])->name('api.sireh.militar-noprof.graduacion.dataOficialesAsimilados');
Route::get('sireh/personalmilitarnoprof/graduacion/oficiales_tropa_profesional', [GraduacionController::class, 'getOficialesTropaProfesional'])->name('api.sireh.militar-noprof.graduacion.dataOficialesTropaProfesional');

Route::get('sireh/personalmilitarnoprof/ascensos/alferez_6to_medicina', [AscensosController::class, 'getAlferez6toMedicina'])->name('api.sireh.militar-noprof.ascensos.dataAlferez6toMedicina');
Route::get('sireh/personalmilitarnoprof/ascensos/alferez_5to_medicina', [AscensosController::class, 'getAlferez5toMedicina'])->name('api.sireh.militar-noprof.ascensos.dataAlferez5toMedicina');
Route::get('sireh/personalmilitarnoprof/ascensos/alferez_5to_salud', [AscensosController::class, 'getAlferez5toSalud'])->name('api.sireh.militar-noprof.ascensos.dataAlferez5toSalud');
Route::get('sireh/personalmilitarnoprof/ascensos/alferez', [AscensosController::class, 'getAlferez'])->name('api.sireh.militar-noprof.ascensos.dataAlferez');
Route::get('sireh/personalmilitarnoprof/ascensos/cadete_3er', [AscensosController::class, 'getCadete3er'])->name('api.sireh.militar-noprof.ascensos.dataCadete3er');
Route::get('sireh/personalmilitarnoprof/ascensos/cadete_2do', [AscensosController::class, 'getCadete2do'])->name('api.sireh.militar-noprof.ascensos.dataCadete2do');

Route::get('sireh/personalmilitarnoprof/egreso_contingente', [EgresosController::class, 'dataEgresoAlistadosContingente'])->name('api.sireh.personal.militar-noprof.egresoContingente');

Route::get('sireh/personalmilitarnoprof/reingresos', [ReingresosController::class, 'personalMilitarNoProfEgresado'])->name('api.sireh.personal.militar-noprof.dataEgresados');

Route::get('sireh/carga-familiar/data', [CargaFamiliarController::class, 'dataCargaFamiliar'])->name('api.sireh.carga-familiar.data');


Route::get('sireh/condecoraciones/data', [CondecoracionesController::class, 'dataCondecoraciones'])->name('api.sireh.condecoraciones.data');
//Route::post('/sireh/personal-civil/suspender', [PersonalController::class, 'suspenderPersonalCivil'])->name('sireh.personal-civil.suspender');
//Route::post('/sireh/personal-civil/egreso', [PersonalController::class, 'egresoPersonalCivil'])->name('sireh.personal-civil.egreso');
Route::post('/sireh/personal-civil/activar',   [PersonalController::class, 'activarPersonalCivil'])->name('sireh.personal-civil.activar');
Route::post('/sireh/personal-civil/update',     [PersonalController::class, 'updatePersonalCivil'])->name('sireh.personal-civil.update');

Route::get('forms/listado_pilotos/data', [FormaFAMController::class, 'data_pilotos'])->name('api.forms.listado_pilotos.data');

Route::get('sireh/personalcivil/jubilable', [JubiladosController::class, 'jubilablesPersonalCivil'])->name('api.sireh.personal-civil-jubilables.data');



Route::get('dao/personalmilitar', [FormaFAMController::class, 'personalMilitarDao'])->name('api.dao.personal.militar.data');

Route::get('forms/ver_listado_piloto/data/{cedula}', [FormaFAMController::class, 'verListadoPilotoData'])->name('api.forms.ver_listado_piloto.data');

Route::get("grados-militares-noprof/{tipo_emp?}", [ApiController::class, 'getGradosMilitaresPersonalMilitarNoProf'])->name("api.grados_militares.noprof");

//JUNTA P

Route::get('juntap/personalmilitar', [controllerjuntap::class, 'personalMilitarasc'])->name('api.juntap.personalm.data');
 //Route::get('/juntapermanente/ascenso/julio', [controllerjuntap::class, 'select']);
 Route::get('/juntap/reportes/index', [controllerjuntap::class, 'juntap'])->name('api.juntap.reportes.index');
 Route::get('/juntapermanente/ascenso/julio', [controllerjuntap::class, 'select'])->name('api.juntap.ascenso.julio');
 Route::get('/juntapermanente/ascenso/julio/comando', [controllerjuntap::class, 'select_julio_comando'])->name('api.juntap.ascenso.julio.comando');
 Route::get('/juntapermanente/ascenso/julio/tecnico', [controllerjuntap::class, 'select_julio_tecnico'])->name('api.juntap.ascenso.julio.tecnico');
 Route::get('/juntapermanente/ascenso/julio/ofitropa', [controllerjuntap::class, 'select_julio_ofitropa'])->name('api.juntap.ascenso.julio.ofitropa');
 Route::get('/juntapermanente/ascenso/julio/asitecnico', [controllerjuntap::class, 'select_julio_asitecnico'])->name('api.juntap.ascenso.julio.asitecnico');
 Route::get('/juntapermanente/ascenso/julio/asimilado', [controllerjuntap::class, 'select_julio_asimilado'])->name('api.juntap.ascenso.julio.asimilado');
 Route::get('/juntapermanente/ascenso/julio/tropap', [controllerjuntap::class, 'select_julio_tropap'])->name('api.juntap.ascenso.julio.tropap');

 Route::get('/juntapermanente/ascenso/diciembre/ofitropa', [controllerjuntap::class, 'select_diciembre_ofitropa'])->name('api.juntap.ascenso.diciembre.ofitropa');
 Route::get('/juntapermanente/ascenso/diciembre/asitecnico', [controllerjuntap::class, 'select_diciembre_asitecnico'])->name('api.juntap.ascenso.diciembre.asitecnico');
 Route::get('/juntapermanente/ascenso/diciembre/asimilado', [controllerjuntap::class, 'select_diciembre_asimilado'])->name('api.juntap.ascenso.diciembre.asimilado');

 //Route::post('/juntapermanente/ascenso/reportes/reporteascenso', [controllerjuntap::class, 'ascreporte'])->name('api.juntap.reportes.ascrreporte');
 Route::post('/ascender/julio', [controllerjuntap::class, 'ascender_julio'])->name('api.juntap.ascenso.julio.ascender');
 Route::post('/ascender/diciembre', [controllerjuntap::class, 'ascender_diciembre'])->name('api.juntap.ascenso.diciembre.ascender');
 Route::post('/juntapermanente/categoria/personal', [controllerjuntap::class, 'cambio_categoria_personal'])->name('api.juntap.cambio.categoria.personal');
 Route::post('/juntapermanente/ascenso/personal', [controllerjuntap::class, 'ascender_personal'])->name('api.juntap.ascenso.personal');
  //JUNTA P2
 // Route::get('/juntaperm/controllerjuntap', [controllerjuntap::class, 'index'])->name('api.juntap.ascenso.index');
  //Route::get('/juntaperm/controllerjuntap', [controllerjuntap::class, 'index'])->name('api.juntap.reportes.index');
  Route::get('sireh/personalmilitar', [empleadoExtraComponeteController::class, 'personal'])->name('api.personal.data');
