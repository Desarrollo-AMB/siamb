<?php

namespace App\Http\Controllers\Parte;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\CategoriasMilitares;
use App\Models\Empleado;
use App\Models\Estados;
use App\Models\Nomina;
use App\Models\parte_general;
use Dompdf\Dompdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Barryvdh\DomPDF\PDF;
use Dompdf\Adapter\PDFLib;

use App\Models\Ubicaciones;
use Illuminate\Support\Facades\DB;

class PartegeneralController extends Controller
{
    public function index()
    {

        $nomina_count = Nomina::whereIn('situacion', ['A', 'S'])
            ->whereIn('tipo_emp', ['MIL', 'TRP'])
            ->count();
        $presente_count = DB::table('parte_general')
            ->join('nomina', 'parte_general.codigo_empleado', '=', 'nomina.codigo_empleado')
            ->whereIn('nomina.situacion', ['A', 'S'])
            ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
            ->where('parte_general.situacion', 'presente')
            ->count();

        $ausentes_count = $nomina_count - $presente_count;

        $categorias = Nomina::join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->whereIn('nomina.situacion', ['A', 'S'])
            ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
            ->select(
                \DB::raw('count(*) as total'),
                \DB::raw('sum(case when datos_militares.codigo_categoria in ("1","4") then 1 else 0 end) as comando'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecnico'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "6" then 1 else 0 end) as asimiladotc'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "2" then 1 else 0 end) as asimilado'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "7" then 1 else 0 end) as tropacmd'),
                \DB::raw('sum(case when datos_militares.codigo_categoria = "8" then 1 else 0 end) as trp')
            )
            ->get();
        $grados = Nomina::join('datos_militares', 'datos_militares.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->whereIn('nomina.situacion',['A', 'S'])
        ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
        ->select(
            ////////////////////GRADOS Y CATEGORIAS////////////////////////////////////////////////////////7
                                ///////COMANDO////////////////7
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coGJ'),
                                \DB::raw('sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coMJ'),
                                \DB::raw('sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coGD'),
                                \DB::raw('sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coGB'),
                                \DB::raw('sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coCNEL'),
                                \DB::raw('sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coTCNEL'),
                                \DB::raw('sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coMY'),
                                \DB::raw('sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coCAP'),
                                \DB::raw('sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coPTTE'),
                                \DB::raw('sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as coTTE'),
                                                ////////////////////TECNICOS///////////////////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecGJ'),
                                \DB::raw('sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecMJ'),
                                \DB::raw('sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecGD'),
                                \DB::raw('sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecGB'),
                                \DB::raw('sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecCNEL'),
                                \DB::raw('sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecTCNEL'),
                                \DB::raw('sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecMY'),
                                \DB::raw('sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecCAP'),
                                \DB::raw('sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecPTTE'),
                                \DB::raw('sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as tecTTE'),
                                                ////////////////////////ASIMILADO TECNICO /////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecGJ'),
                                \DB::raw('sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecMJ'),
                                \DB::raw('sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecGD'),
                                \DB::raw('sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecGB'),
                                \DB::raw('sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecCNEL'),
                                \DB::raw('sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecTCNEL'),
                                \DB::raw('sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecMY'),
                                \DB::raw('sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecCAP'),
                                \DB::raw('sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecPTTE'),
                                \DB::raw('sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as AStecTTE'),
                                ///////////////////////ASIMILADO  /////////////////////////
                                 \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asGJ'),
                                 \DB::raw('sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asMJ'),
                                 \DB::raw('sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asGD'),
                                 \DB::raw('sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asGB'),
                                 \DB::raw('sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asCNEL'),
                                 \DB::raw('sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asTCNEL'),
                                 \DB::raw('sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asMY'),
                                 \DB::raw('sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asCAP'),
                                 \DB::raw('sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asPTTE'),
                                 \DB::raw('sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as asTTE'),
                                 ////////////////////////COMANDO DE TROPA  /////////////////////////
                                  \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpGJ'),
                                  \DB::raw('sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpMJ'),
                                  \DB::raw('sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpGD'),
                                  \DB::raw('sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpGB'),
                                  \DB::raw('sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpCNEL'),
                                  \DB::raw('sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpTCNEL'),
                                  \DB::raw('sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpMY'),
                                  \DB::raw('sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpCAP'),
                                  \DB::raw('sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpPTTE'),
                                  \DB::raw('sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as ctrpTTE'),
                //////////////////////////////////////SARGENTOS///////////////////////////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "410" then 1 else 0 end) as SS'),
                                \DB::raw('sum(case when nomina.grado_militar = "420" then 1 else 0 end) as SA'),
                                \DB::raw('sum(case when nomina.grado_militar = "430" then 1 else 0 end) as SM1'),
                                \DB::raw('sum(case when nomina.grado_militar = "440" then 1 else 0 end) as SM2'),
                                \DB::raw('sum(case when nomina.grado_militar = "450" then 1 else 0 end) as SM3'),
                                \DB::raw('sum(case when nomina.grado_militar = "460" then 1 else 0 end) as S1'),
                                \DB::raw('sum(case when nomina.grado_militar = "470" then 1 else 0 end) as S2'),
                                /////////////////////////SUMA DE CONTADORES TOTAL POR CADA GRADO////////////////////////////
                                /////////////TOTAL DE GENERALES EN JEFE /////////////
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "5" then 1 else 0 end)  + sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalGJ'),
                                ///////////////////////TOLTAL DE MAYOR GENERAL ////////////////7
                                \DB::raw('sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalMJ'),
                                ///////////////////TOTAL DE GENERAL DE DIVISION ////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "5" then 1 else 0 end)  + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalGD'),
                                ///////////////////TOTAL DE GENERAL DE BRIGADA ////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "5" then 1 else 0 end)  + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalGB'),
                                ///////////////////TOTAL CORONELES ////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalCNEL'),
                                ///////////////////TOTAL TTENIENTE CORONELES ////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalTCNEL'),
                                ///////////////////TOTAL MAYOR ////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalMY'),
                                 ///////////////////TOTAL CAPITAN ////////////////
                                 \DB::raw('sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                 sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalCAP'),
                                  ///////////////////TOTAL PRIMER TENIENTE ////////////////
                                  \DB::raw('sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                  sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalPTTE'),
                                  ////////////////////TOTAL TENIENTES
                                  \DB::raw('sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                  sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalTTE'),
                                  ///////////// TOTAL POR GRADO  DE CATEGORIAS ////////
                                        //////////COMANDO ///////////////////
                                  \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end)+ sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end)+sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end)+ sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end)+ sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end)+ sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end)+ sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) as totalCOM'),
                                                  ////////////////////TECNICOS///////////////////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "5" then 1 else 0 end) +sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "5" then 1 else 0 end) as totalTEC'),
                                ////////////////////////ASIMILADO TECNICO /////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "6" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "6" then 1 else 0 end) as totalASTEC'),
                                ///////////////////////ASIMILADO  /////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "2" then 1 else 0 end) as totalASIM'),
                                 ////////////////////////COMANDO DE TROPA  /////////////////////////
                                 \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "7" then 1 else 0 end) as totalCMDTRP'),
                                 //////////////////////////////////////TROPA PROFESIONAL ///////////////////////////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "410" then 1 else 0 end) + sum(case when nomina.grado_militar = "420" then 1 else 0 end) + sum(case when nomina.grado_militar = "430" then 1 else 0 end) + sum(case when nomina.grado_militar = "440" then 1 else 0 end) + sum(case when nomina.grado_militar = "450" then 1 else 0 end) + sum(case when nomina.grado_militar = "460" then 1 else 0 end) + sum(case when nomina.grado_militar = "470" then 1 else 0 end) as totalTRP'),
                                 ////////////////////TOTAL DEFINITIVO //////////////////////////
                                \DB::raw('sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "5" then 1 else 0 end)  + sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "010" and datos_militares.codigo_categoria = "7" then 1 else 0 end) +
                              sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "015" and datos_militares.codigo_categoria = "7" then 1 else 0 end) +
                               sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "5" then 1 else 0 end)  + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "020" and datos_militares.codigo_categoria = "7" then 1 else 0 end) +
                           sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "5" then 1 else 0 end)  + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "030" and datos_militares.codigo_categoria = "7" then 1 else 0 end) +
                            sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "040" and datos_militares.codigo_categoria = "7" then 1 else 0 end)+
                                sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "050" and datos_militares.codigo_categoria = "7" then 1 else 0 end) +
                               sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "060" and datos_militares.codigo_categoria = "7" then 1 else 0 end) +
                                 sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                 sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "070" and datos_militares.codigo_categoria = "7" then 1 else 0 end) +
                                  sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                  sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "080" and datos_militares.codigo_categoria = "7" then 1 else 0 end)+ sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "5" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "6" then 1 else 0 end) +
                                  sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "2" then 1 else 0 end) + sum(case when nomina.grado_militar = "090" and datos_militares.codigo_categoria = "7" then 1 else 0 end) + sum(case when nomina.grado_militar = "410" then 1 else 0 end) + sum(case when nomina.grado_militar = "420" then 1 else 0 end) + sum(case when nomina.grado_militar = "430" then 1 else 0 end) + sum(case when nomina.grado_militar = "440" then 1 else 0 end) + sum(case when nomina.grado_militar = "450" then 1 else 0 end) + sum(case when nomina.grado_militar = "460" then 1 else 0 end) + sum(case when nomina.grado_militar = "470" then 1 else 0 end)  as TOTAL')


        )->get();
        // Conteo de la tabla parte_general
                 $parte_generales = Nomina::join('parte_general', 'nomina.codigo_empleado', '=', 'parte_general.codigo_empleado')
            ->whereIn('nomina.situacion', ['A', 'S'])
            ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
            ->whereDate('parte_general.fecha', now()->toDateString())
            ->select(
                \DB::raw('count(*) as total'),
                \DB::raw('sum(parte_general.situacion = "presente") as total1'),
                \DB::raw('sum(parte_general.situacion = "Servicio en la Unidad") as total2'),
                \DB::raw('sum(parte_general.situacion = "Servicio fuera de la Unidad") as total3'),
                \DB::raw('sum(parte_general.situacion = "Retardado") as total4'),
                \DB::raw('sum(parte_general.situacion = "Permiso") as total5'),
                \DB::raw('sum(parte_general.situacion = "Comision Pais") as total6'),
                \DB::raw('sum(parte_general.situacion = "Curso Pais") as total7'),
                \DB::raw('sum(parte_general.situacion = "Curso Exterior") as total8'),
                \DB::raw('sum(parte_general.situacion = "Comision Exterior") as total9'),
                \DB::raw('sum(parte_general.situacion = "Ausente sin causa Justificada") as total10'),
                \DB::raw('sum(parte_general.situacion = "Destacado fuera de la Unidad") as total11'),
                \DB::raw('sum(parte_general.situacion = "Consulta") as total12'),
                \DB::raw('sum(parte_general.situacion = "reposo") as total3'),
                \DB::raw('sum(parte_general.situacion = "Hospitalizado") as total14'),
                \DB::raw('sum(parte_general.situacion = "Desertor") as total15'),
                \DB::raw('sum(parte_general.situacion = "Privado de Libertad") as total16'),
                \DB::raw('sum(parte_general.situacion = "Otro") as total17')


            )
            ->get();




        return view('sireh.personal.militar.parte.index', compact('parte_generales', 'nomina_count', 'ausentes_count', 'categorias','grados'));
    }
    public function indexparte()
    {
        $user_id = auth()->user()->id; //obtener el id del usuario que ha iniciado sesión

        $codigo_ubicacion = DB::table('nomina')
            ->join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')
            ->where('empleados.user_id', '=', $user_id)
            ->select('nomina.codigo_ubicacion')
            ->first()
            ->codigo_ubicacion;
        $parte = parte_general::
        select('fecha');
        $nominas = Nomina::join('empleados', 'nomina.codigo_empleado', '=', 'empleados.codigo_empleado')

            ->join('grados_militares', 'nomina.grado_militar', '=', 'grados_militares.codigo_grado')
            ->join('datos_militares', 'nomina.codigo_empleado', '=', 'datos_militares.codigo_empleado')
            ->join('ubicaciones', 'nomina.codigo_ubicacion', '=', 'ubicaciones.codigo_ubicacion')
            ->where('ubicaciones.codigo_ubicacion', '=', $codigo_ubicacion)
            ->whereIn('nomina.situacion',['A', 'S'])
            ->select(
                'nomina.grado_militar',
                'empleados.nombre1',
                'empleados.apellido1',
                'ubicaciones.descripcion',
                'grados_militares.siglas',
                'datos_militares.codigo_categoria',
                'nomina.codigo_empleado',
                'nomina.codigo_ubicacion',
                'nomina.grado_militar'
            )
            ->orderByRaw("CASE WHEN nomina.grado_militar = '010' THEN 1
            WHEN nomina.grado_militar = '015' THEN 2
            WHEN nomina.grado_militar = '020' THEN 3
            WHEN nomina.grado_militar = '030' THEN 4
            WHEN nomina.grado_militar = '040' THEN 5
            WHEN nomina.grado_militar = '050' THEN 6
            WHEN nomina.grado_militar = '060' THEN 7
            WHEN nomina.grado_militar = '070' THEN 8
            WHEN nomina.grado_militar = '080' THEN 9
            WHEN nomina.grado_militar = '090' THEN 10
            WHEN nomina.grado_militar = '410' THEN 11
            WHEN nomina.grado_militar = '420' THEN 12
            WHEN nomina.grado_militar = '430' THEN 13
            WHEN nomina.grado_militar = '440' THEN 14
            WHEN nomina.grado_militar = '450' THEN 15
            WHEN nomina.grado_militar = '460' THEN 16
            WHEN nomina.grado_militar = '470' THEN 17 END, nomina.grado_militar")
            ->orderByRaw("CASE
                            WHEN datos_militares.codigo_categoria = 1 THEN 1
                            WHEN datos_militares.codigo_categoria = 4 THEN 2
                            WHEN datos_militares.codigo_categoria = 5 THEN 3
                            WHEN datos_militares.codigo_categoria = 7 THEN 4
                            WHEN datos_militares.codigo_categoria = 2 THEN 5
                            WHEN datos_militares.codigo_categoria = 6 THEN 6
                            WHEN datos_militares.codigo_categoria = 8 THEN 7
                        END")
            ->get();



        return view('sireh.personal.militar.parte.create', compact('nominas','parte'));
    }
    public function indexregistro(){
    {
        $ubicaciones = Ubicaciones::all();

        $partesGenerales = parte_general::whereDate('fecha', Carbon::today())->get();
        $partesGeneralesPorUbicacion = $partesGenerales->groupBy('codigo_ubicacion');

        $ubicacionesConRegistro = $ubicaciones->filter(function ($ubicacion) use ($partesGeneralesPorUbicacion) {
            return $partesGeneralesPorUbicacion->has($ubicacion->codigo_ubicacion);
        })->values();

        $ubicacionesSinRegistro = $ubicaciones->diff($ubicacionesConRegistro);

        return view('sireh.personal.militar.parte.registro', compact('ubicacionesConRegistro', 'ubicacionesSinRegistro'));
    }
    }



    //Obtiene los cargos, exclusivo por api para el Datatable
    public function UbicacionesData(Request $request)
    {
        /* $ubicaciones = Ubicaciones::
        select(
            'ubicaciones.id','ubicaciones.codigo_ubicacion',
            'ubicaciones.descripcion',
            'ubicaciones.tipo_unidad_organizacional',
            'estados.id_estado as estado',
            'ubicaciones.tipo_unidad',
            'ubicaciones.redi',
            'ubicaciones.zodi',
            'ubicaciones.situacion');
        $ubicaciones->join('nomina','nomina.codigo_ubicacion','=','ubicaciones.codigo_ubicacion');
        $ubicaciones->join('estados','estados.id_estado','=','ubicaciones.codigo_estado'*/

        $ubicaciones = Ubicaciones::join('estados', 'estados.id_estado', '=', 'ubicaciones.codigo_estado');

        $ubicaciones->select(
            'id',
            'codigo_ubicacion',
            'descripcion',
            'tipo_unidad_organizacional',
            'estados.estado as codigo_estado',
            'tipo_unidad',
            'redi',
            'zodi',
            'situacion',

        );


        $datatable = Datatables::of($ubicaciones)
            ->addColumn('actions', 'auxiliares.ubicaciones._actions')
            ->rawColumns(['actions']);
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $estados = Estados::all();
        $bases = Base::all();
        $redi = Config::get('constants.redi');
        $tipo_unidad = Config::get('constants.tipo_unidad');
        return view('sireh.personal.militar.part.create', compact('redi', 'estados', 'tipo_unidad', 'bases'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)


{
    try {
        $nominas = $request->input('nominas');
        $fecha = $request->input('fecha');

        // Comprobar si la fecha ya existe para una ubicación específica
        foreach ($nominas as $nomina) {
            $parteExistente = parte_general::where([
                ['fecha', '=', $fecha],
                ['codigo_ubicacion', '=', $nomina['codigo_ubicacion']]
            ])->first();

            if ($parteExistente) {
                $mensajeError = 'Ya existe un parte para la fecha y ubicación especificadas';
                return redirect()->back()->withErrors($mensajeError);
            }
        }

        // Guardar las nuevas nominas
        foreach ($nominas as $nomina) {
            $parte = new parte_general;
            $parte->fecha = $fecha;
            $parte->codigo_empleado = $nomina['codigo_empleado'];
            $parte->codigo_ubicacion = $nomina['codigo_ubicacion'];
            $parte->codigo_categoria = $nomina['codigo_categoria'];
            $parte->grado_militar = $nomina['grado_militar'];
            $parte->situacion = $nomina['situacion'];
            $parte->observacion = $nomina['observacion'];
            $parte->save();
        }

        return redirect()->route('sireh.personal.militar.parte.create')->with('success_message', 'Parte fue ingresado con éxito');
    } catch (\Exception $e) {
        return redirect()->route('sireh.personal.militar.parte.create')->with('errors', 'Errors al guardar los datos: '.$e->getMessage());
    }
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ubicaciones = Ubicaciones::find($id);
        $estados = Estados::all();
        $bases = Base::all();
        $redi = Config::get('constants.redi');
        $tipo_unidad = Config::get('constants.tipo_unidad');
        return view('auxiliares.ubicaciones.edit', compact('ubicaciones', 'redi', 'estados', 'tipo_unidad', 'bases'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'descripcion' => [
                'required'
            ],
        ]);

        $ubicaciones = Ubicaciones::find($id);
        $ubicaciones->descripcion = strtolower($request->input('descripcion'));
        $ubicaciones->tipo_unidad = $request->input('tipo_unidad');
        $ubicaciones->base = $request->input('base');
        $ubicaciones->codigo_estado = $request->input('codigo_estado');
        $ubicaciones->redi = $request->input('redi');
        $ubicaciones->zodi = $request->input('zodi');
        $ubicaciones->situacion = $request->input('situacion');
        $ubicaciones->save();

        return redirect()->route('auxiliares.ubicaciones.index')
            ->with('success', 'Ubicacion actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //\DB::table("cargos")->where('id',$id)->delete();

        $ubicaciones = Ubicaciones::find($id);
        $ubicaciones->delete();
        return response()->json(['success' => true]);
    }


    public function ParteReportes()
    {
        $ubicaciones = Ubicaciones::all();
        $categorias_militares =  CategoriasMilitares::whereIn('tipo_emp',['MIL','MEX','TRP'])->get();
        return view('sireh.personal.militar.parte.reporte.reportes', compact(
            'categorias_militares','ubicaciones'
        ));
    }



    public function reporteParteUnidad(Request $request) {
        $this->validate($request,
        //dd($request),
            [
                'fecha' => 'required',
                'parametros' => 'required|array|min:1',
                'parametros.*' => 'required|string|distinct',

            ],
            [
                'fecha' => 'La fecha es requerida',
                'parametros.*.required' => 'la ubicacion es requerida',
            ]
        );
        $nameParametro =array_key_first($request->parametros);
        $valueParametro = $request->parametros[$nameParametro];
        $fechas = $request->fecha;
//dd([$valueParametro]);
////obtener los datos del la tabala nomina////////////
           $nomina_count = Nomina::whereIn('situacion', ['A', 'S'])
        ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])

        ->whereIn('nomina.codigo_ubicacion', [$valueParametro])
        ->count();
    $presente_count = DB::table('parte_general')
        ->join('nomina', 'parte_general.codigo_empleado', '=', 'nomina.codigo_empleado')
        ->whereIn('nomina.situacion', ['A', 'S'])
        ->whereIn('nomina.tipo_emp', ['MIL', 'TRP'])
        ->where('parte_general.situacion', 'presente')
        ->whereIn('parte_general.codigo_ubicacion', [$valueParametro])
        ->whereIn('parte_general.fecha',[$fechas])
        ->count();
             $ausentes_count = $nomina_count - $presente_count;

             ///OBTENER LISTA DEL PERSONAL //
$list = Nomina:: join('parte_general','nomina.codigo_empleado','=','parte_general.codigo_empleado')
                ->join('categorias_militares','parte_general.codigo_categoria','=','categorias_militares.codigo_categoria')
                ->join('grados_militares','grados_militares.codigo_grado','=','parte_general.grado_militar')
                ->join('ubicaciones','nomina.codigo_ubicacion','=','ubicaciones.codigo_ubicacion')
                ->where('parte_general.fecha', [$fechas])
                ->whereIn('nomina.situacion', ['A', 'S'])
                ->whereIn('parte_general.codigo_ubicacion', [$valueParametro])
                ->select('grados_militares.siglas as grado','nomina.nombre1 as nombres','nomina.apellido1 as  apellido',
                'nomina.cedula as cedula','ubicaciones.descripcion as ubicacion','parte_general.situacion as situacion'
                ,'categorias_militares.descripcion as categoria')
                ->orderByRaw("CASE WHEN nomina.grado_militar = '010' THEN 1
                WHEN nomina.grado_militar = '015' THEN 2
                WHEN nomina.grado_militar = '020' THEN 3
                WHEN nomina.grado_militar = '030' THEN 4
                WHEN nomina.grado_militar = '040' THEN 5
                WHEN nomina.grado_militar = '050' THEN 6
                WHEN nomina.grado_militar = '060' THEN 7
                WHEN nomina.grado_militar = '070' THEN 8
                WHEN nomina.grado_militar = '080' THEN 9
                WHEN nomina.grado_militar = '090' THEN 10
                WHEN nomina.grado_militar = '410' THEN 11
                WHEN nomina.grado_militar = '420' THEN 12
                WHEN nomina.grado_militar = '430' THEN 13
                WHEN nomina.grado_militar = '440' THEN 14
                WHEN nomina.grado_militar = '450' THEN 15
                WHEN nomina.grado_militar = '460' THEN 16
                WHEN nomina.grado_militar = '470' THEN 17 END, nomina.grado_militar")
                ->orderByRaw("CASE
                                WHEN categorias_militares.codigo_categoria = 1 THEN 1
                                WHEN categorias_militares.codigo_categoria = 4 THEN 2
                                WHEN categorias_militares.codigo_categoria = 5 THEN 3
                                WHEN categorias_militares.codigo_categoria = 7 THEN 4
                                WHEN categorias_militares.codigo_categoria = 2 THEN 5
                                WHEN categorias_militares.codigo_categoria = 6 THEN 6
                                WHEN categorias_militares.codigo_categoria = 8 THEN 7
                            END")


            ->get();


//dd($presente_count);
        $datas = Nomina::join('parte_general','nomina.codigo_empleado','=','parte_general.codigo_empleado')
            ->join('ubicaciones','nomina.codigo_ubicacion','=','ubicaciones.codigo_ubicacion')
            ->join('datos_militares','datos_militares.codigo_empleado','=','nomina.codigo_empleado')
            ->join('grados_militares','grados_militares.codigo_grado','=','nomina.grado_militar')
            ->where('parte_general.fecha', [$fechas])
            ->whereIn('nomina.situacion', ['A', 'S'])
            ->whereIn('parte_general.codigo_ubicacion', [$valueParametro])
            ->select('ubicaciones.descripcion as ubicacion','parte_general.fecha as fecha',
                \DB::raw('count(*) as total'),
                \DB::raw('sum(parte_general.situacion = "presente") as total1'),
                \DB::raw('sum(parte_general.situacion = "Servicio en la Unidad") as total2'),
                \DB::raw('sum(parte_general.situacion = "Servicio fuera de la Unidad") as total3'),
                \DB::raw('sum(parte_general.situacion = "Retardado") as total4'),
                \DB::raw('sum(parte_general.situacion = "Permiso") as total5'),
                \DB::raw('sum(parte_general.situacion = "Comision Pais") as total6'),
                \DB::raw('sum(parte_general.situacion = "Curso Pais") as total7'),
                \DB::raw('sum(parte_general.situacion = "Curso Exterior") as total8'),
                \DB::raw('sum(parte_general.situacion = "Comision Exterior") as total9'),
                \DB::raw('sum(parte_general.situacion = "Ausente sin causa Justificada") as total10'),
                \DB::raw('sum(parte_general.situacion = "Destacado fuera de la Unidad") as total11'),
                \DB::raw('sum(parte_general.situacion = "Consulta") as total12'),
                \DB::raw('sum(parte_general.situacion = "reposo") as total3'),
                \DB::raw('sum(parte_general.situacion = "Hospitalizado") as total14'),
                \DB::raw('sum(parte_general.situacion = "Desertor") as total15'),
                \DB::raw('sum(parte_general.situacion = "Privado de Libertad") as total16'),
                \DB::raw('sum(parte_general.situacion = "Otro") as total17'),
                //////////////////////////////////////////////CATEGORIA/////////////////////////////////
                \DB::raw('sum(case when parte_general.codigo_categoria in ("1","4") then 1 else 0 end) as comando'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "5" then 1 else 0 end) as tecnico'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "6" then 1 else 0 end) as asimiladotc'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "2" then 1 else 0 end) as asimilado'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "7" then 1 else 0 end) as tropacmd'),
                \DB::raw('sum(case when parte_general.codigo_categoria = "8" then 1 else 0 end) as trp'),
                ////////////////////GRADOS Y CATEGORIAS////////////////////////////////////////////////////////7
                                ///////COMANDO////////////////7
                \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coGJ'),
                \DB::raw('sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coMJ'),
                \DB::raw('sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coGD'),
                \DB::raw('sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coGB'),
                \DB::raw('sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coCNEL'),
                \DB::raw('sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coTCNEL'),
                \DB::raw('sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coMY'),
                \DB::raw('sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coCAP'),
                \DB::raw('sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coPTTE'),
                \DB::raw('sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as coTTE'),
                                ////////////////////TECNICOS///////////////////////////////////////
                \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecGJ'),
                \DB::raw('sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecMJ'),
                \DB::raw('sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecGD'),
                \DB::raw('sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecGB'),
                \DB::raw('sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecCNEL'),
                \DB::raw('sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecTCNEL'),
                \DB::raw('sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecMY'),
                \DB::raw('sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecCAP'),
                \DB::raw('sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecPTTE'),
                \DB::raw('sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "5" then 1 else 0 end) as tecTTE'),
                                ////////////////////////ASIMILADO TECNICO /////////////////////////
                \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecGJ'),
                \DB::raw('sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecMJ'),
                \DB::raw('sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecGD'),
                \DB::raw('sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecGB'),
                \DB::raw('sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecCNEL'),
                \DB::raw('sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecTCNEL'),
                \DB::raw('sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecMY'),
                \DB::raw('sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecCAP'),
                \DB::raw('sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecPTTE'),
                \DB::raw('sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "6" then 1 else 0 end) as AStecTTE'),
                                                    ////////////////////////ASIMILADO  /////////////////////////
                 \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asGJ'),
                 \DB::raw('sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asMJ'),
                 \DB::raw('sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asGD'),
                 \DB::raw('sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asGB'),
                 \DB::raw('sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asCNEL'),
                 \DB::raw('sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asTCNEL'),
                 \DB::raw('sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asMY'),
                 \DB::raw('sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asCAP'),
                 \DB::raw('sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asPTTE'),
                 \DB::raw('sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "2" then 1 else 0 end) as asTTE'),
                                                                ////////////////////////COMANDO DE TROPA  /////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpGJ'),
                  \DB::raw('sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpMJ'),
                  \DB::raw('sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpGD'),
                  \DB::raw('sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpGB'),
                  \DB::raw('sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpCNEL'),
                  \DB::raw('sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpTCNEL'),
                  \DB::raw('sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpMY'),
                  \DB::raw('sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpCAP'),
                  \DB::raw('sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpPTTE'),
                  \DB::raw('sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "7" then 1 else 0 end) as ctrpTTE'),
//////////////////////////////////////SARGENTOS///////////////////////////////////////////////
                \DB::raw('sum(case when parte_general.grado_militar = "410" then 1 else 0 end) as SS'),
                \DB::raw('sum(case when parte_general.grado_militar = "420" then 1 else 0 end) as SA'),
                \DB::raw('sum(case when parte_general.grado_militar = "430" then 1 else 0 end) as SM1'),
                \DB::raw('sum(case when parte_general.grado_militar = "440" then 1 else 0 end) as SM2'),
                \DB::raw('sum(case when parte_general.grado_militar = "450" then 1 else 0 end) as SM3'),
                \DB::raw('sum(case when parte_general.grado_militar = "460" then 1 else 0 end) as S1'),
                \DB::raw('sum(case when parte_general.grado_militar = "470" then 1 else 0 end) as S2'),
                 ///////////////////////////////TOTALES DE GRADO/////////////////////////////////////
                      ///////////////////////TOTAL GENERAL EN JEFE ////////////////////////
                 \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalGJ'),
                  //////////////////////TOTAL MAYOR GENERAL ///////////////////////////////
                 \DB::raw('sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalMJ'),
                  //////////////////////TOTAL GENERAL DE DIVISION ///////////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalGD'),
                  //////////////////////TOTAL GENERAL DE BRIGADA ///////////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalGB'),
                  //////////////////////TOTAL DE CORONELES ///////////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalCNEL'),
                  //////////////////////TOTAL DE TENIENTE CORONELES ///////////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalTCNEL'),
                  //////////////////////TOTAL DE MAYOR  ///////////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalMY'),
                  //////////////////////TOTAL DE CAPITANES  ///////////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalCAP'),
                   //////////////////////TOTAL DE PRIMER TENIETE  ///////////////////////////////
                   \DB::raw('sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalPTTE'),
                   //////////////////////TOTAL  TENIETE  ///////////////////////////////
                   \DB::raw('sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "7" then 1 else 0 end) as totalTTE'),
                   /////////////////////////TOTALES DE CATEGORIA POR GRADO //////////////////////////
                          ///////COMANDO////////////////7
                \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) +sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) +sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) +sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) as TOTALcod'),
                   ////////////////////TECNICOS///////////////////////////////////////
                   \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "5" then 1 else 0 end)+ sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "5" then 1 else 0 end) as TOTALtec'),
                    ////////////////////////ASIMILADO TECNICO /////////////////////////
                \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "6" then 1 else 0 end) as TOTALastec'),
                 ////////////////////////ASIMILADO  /////////////////////////
                 \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "2" then 1 else 0 end)+ sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "2" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "2" then 1 else 0 end) as TOTALas'),
                   ////////////////////////COMANDO DE TROPA  /////////////////////////
                   \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "7" then 1 else 0 end) as TOTALcmdtrp'),
                   //////////////////////////////////////SARGENTOS///////////////////////////////////////////////
                \DB::raw('sum(case when parte_general.grado_militar = "410" then 1 else 0 end) + sum(case when parte_general.grado_militar = "420" then 1 else 0 end) + sum(case when parte_general.grado_militar = "430" then 1 else 0 end) + sum(case when parte_general.grado_militar = "440" then 1 else 0 end) + sum(case when parte_general.grado_militar = "450" then 1 else 0 end) + sum(case when parte_general.grado_militar = "460" then 1 else 0 end) + sum(case when parte_general.grado_militar = "470" then 1 else 0 end) as TOTALtrp'),
                /////////////////////////////////////TOTAL DEFINITIVO ///////////////////////////////////////
                  ///////////////////////TOTAL GENERAL EN JEFE ////////////////////////
                  \DB::raw('sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "010" and parte_general.codigo_categoria = "7" then 1 else 0 end) +sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "015" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "020" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "030" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "040" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "050" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "060" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "070" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "080" and parte_general.codigo_categoria = "7" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria in ("1", "4") then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "5" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "6" then 1 else 0 end) + sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "2" then 1 else 0 end) +sum(case when parte_general.grado_militar = "090" and parte_general.codigo_categoria = "7" then 1 else 0 end) as TOTAL'),
        )->first();
       //dd($datas->tecnico);
        if(!$datas){
            return back()
            ->with('warning','No se puede generar el reporte, no existen registros que corresponda a la cedula');
        }




        $pdf = \PDF::loadView('sireh.personal.militar.parte.reporte.rep_parte_unidad', compact('datas', 'nomina_count', 'ausentes_count','list'))
        ->setPaper('letter', 'portrait');
        return $pdf->stream('parte.pdf',array('Attachment'=>0));
        //return view('bienestar_social.reporte_devolucion5', compact('datas'));

    }


}
