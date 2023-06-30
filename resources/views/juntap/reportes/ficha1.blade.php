<!DOCTYPE html>
<html>
@php
use Carbon\Carbon;

@endphp

<head>
    <style>
        .tabels {
            border: 2px solid black;
            border-collapse: collapse;
            width: 100%;
            font-size: 7px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .tabels td,
        .tabels th {
            border: 2px solid black;
            padding: 8px;
            line-height: 1;
        }

        .fixed-width-td {
            height: auto;
        }

        .checkox {
            width: 10px;
            height: 10px;
            margin: 3px;
            border: 1px solid black;
            align-self: flex-end;
        }

        @media print {
            .tabels {
                page-break-inside: avoid;
            }
        }

        .img-container {
        position: relative;
        width: 70px;
        height: 100px;
    }

    .img {
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        width: 14.5%;
        height: 26.7%;
        border: 2px solid black;
    }


        .checkbox-th {
            text-align: center;
        }
        <style>
    .img-container {
        position: relative;
        width: 70px;
        height: 100px;
    }

    .img1 {
        position: fixed;
        top: 40%;
        left: 45%;
        transform: translate(-50%, -50%);
        margin: 0;
        width: 50%;
        height: 50%;
        z-index: -1;
        opacity: 0.7;
    }.bold-text {
    font-weight: bold;
}

    </style>

<body>
    <header>

    <img src="{{ public_path('template/assets/img/logo.png') }}" class="img1">

        <table class="tabels">
            <tr>
                <th class="fixed-width-td" colspan="2" rowspan="7" style="text-align: center; border: none; ">
                    <img src="{{ $datos->foto ? url($datos->foto): '' }}" class="img">
                </th>
                <th class="fixed-width-td">NOMBRE Y APELLIDO</th>
                <td class="fixed-width-td">{{ $datos->nombre1 . ' ' . $datos->nombre2 . ' ' . $datos->apellido1 . ' ' .
                    $datos->apellido2 }}</td>
                <th class="fixed-width-td" colspan="3">ORDEN DE MERITO ASCENSO</th>
                <th class="fixed-width-td" colspan="3">RESULTADOS DE EVALUACION</th>
            </tr>
            <tr>
                <th>CEDULA DE IDENTIDAD</th>
                <td>{{ $datos->cedula }}</td>
                <th>GB</th>
                <td> @if (isset($gb) && $gb->orden_merito_ascenso != null || isset($gb) &&
                    $gb->total_orden_merito_ascenso != null)
                    {{ $gb->orden_merito_ascenso }}/ {{ $gb->total_orden_merito_ascenso }}
                    @else
                    0/0
                    @endif</td>
                <td> @if ( isset($añoascensogb ) && $añoascensogb != null)
                    {{strtoupper( $añoascensogb )}}
                    @else
                    0
                    @endif</td>
                <th>PUNTAJE NIEA</th>
                <td colspan="2">2</td>
            </tr>
            <tr>
                <th>GDO/CAT</th>
                <td>{{$datos->siglas}} - {{$datos->categoria}}</td>
                <th>CNEL</th>
                <td> @if (isset($cnel) && $cnel->orden_merito_ascenso != null || isset($cnel) &&
                    $cnel->total_orden_merito_ascenso != null)
                    {{ $cnel->orden_merito_ascenso }}/ {{ $cnel->total_orden_merito_ascenso }}
                    @else
                    0/0
                    @endif</td>
                <td> @if ( isset($añoascensocnel ) && $añoascensocnel != null)
                    {{strtoupper( $añoascensocnel )}}
                    @else
                    0
                    @endif</td>
                <th>OM NIEA</th>
                <td colspan="2">0</td>
            </tr>
            <tr>
                <th>AÑOS DE SERVICIO</th>
                <td>{{strtoupper($años)}},AÑOS</td>
                <th>TCNEL</th>
                <td> @if (isset($tcnel) && $tcnel->orden_merito_ascenso != null || isset($tcnel) &&
                    $tcnel->total_orden_merito_ascenso != null)
                    {{ $tcnel->orden_merito_ascenso }}/ {{ $tcnel->total_orden_merito_ascenso }}
                    @else
                    0/0
                    @endif</td>
                <td> @if (isset($añoascensotcnel) && $añoascensotcnel != null)
                    {{strtoupper( $añoascensotcnel )}}
                    @else
                    0
                    @endif</td>
                <th>OM J/A</th>
                <td colspan="2">0</td>
            </tr>
            <tr>
                <th>TIEMPO EN EL GRADO</th>
                <td>{{strtoupper($años)}},AÑOS</td>
                <th>MY</th>
                <td> @if (isset($may) && $may->orden_merito_ascenso != null || isset($may) &&
                    $may->total_orden_merito_ascenso != null)
                    {{ $may->orden_merito_ascenso }}/ {{ $may->total_orden_merito_ascenso }}
                    @else
                    0/0
                    @endif</th>
                <td> @if (isset($añoascensomay) && $añoascensomay != null)
                    {{strtoupper( $añoascensomay )}}
                    @else
                    0
                    @endif</td>
                <th>OM J/R</th>
                <td colspan="2">0</td>
            </tr>
            <tr>
                <th>ESPECIALIDAD</th>
                <td>{{ $datos->especialidad }}</td>
                <th>CAP</th>
                <td> @if (isset($cap) && $cap->orden_merito_ascenso != null || isset($cap) &&
                    $cap->total_orden_merito_ascenso != null)
                    {{ $cap->orden_merito_ascenso }}/ {{ $cap->total_orden_merito_ascenso }}
                    @else
                    0/0
                    @endif</td>
                <td> @if (isset($añoascensocap) && $añoascensocap != null)
                    {{strtoupper( $añoascensocap )}}
                    @else
                    0
                    @endif</td>
                <th>OM J/C</th>
                <td colspan="2">0</td>
            </tr>
            <tr>
                <th>NIVEL EDUCATIVO</th>
                <td> @foreach ($niveles as $key=>$value)
                    @if($datos->nivel == $key)
                    <div class="text">{{ $value }}</div>
                    @endif
                    @endforeach
                </td>
                <th>PTTE</th>
                <td> @if (isset($ptte) && $ptte->orden_merito_ascenso != null ||isset($ptte) &&
                    $ptte->total_orden_merito_ascenso != null)
                    {{ $ptte->orden_merito_ascenso }}/ {{ $ptte->total_orden_merito_ascenso }}
                    @else
                    0/0
                    @endif</td>
                <td> @if (isset ($añoascensoptte) && $añoascensoptte != null)
                    {{strtoupper( $añoascensoptte )}}
                    @else
                    0
                    @endif</td>
                <th>SITUACION</th>
                <th colspan="2">R</th>
            </tr>
            <tr>
                <th>PROM.AÑO</th>
                <td> {{$datos->promocion}}</td>
                <th>OPORTUNIDAD DE ASCENSO</th>
                <th> PRIMERA</th>
                <th>TTE</th>
                <td> @if (isset($tte) && $tte->orden_merito_ascenso != null || isset($tte) &&
                    $tte->total_orden_merito_ascenso != null)
                    {{ $tte->orden_merito_ascenso }}/ {{ $tte->total_orden_merito_ascenso }}
                    @else
                    0/0
                    @endif</td>
                <td> @if (isset ($añoascensotte) && $añoascensotte != null)
                    {{ strtoupper($añoascensotte) }}
                    @else
                    0
                    @endif</td>
                <th>PAF</th>
                <td colspan="2"> {{$datos->total}}</td>
            </tr>
            <tr>
                <th colspan="2">N° DE TELEFONO</th>
                <td>{{$datos->telefono}}</td>
                <td colspan="7"><strong class="bold-text" >COMANDANTE DE UNIDAD:</strong>{{$cmdt->nombre1 . ' ' . $cmdt->nombre2 . ' ' . $cmdt->apellido1}} <strong class="bold-text">TLF:</strong>
                    {{$cmdt->telefono_cel}}</td>
            </tr>
            <tr>
                <th colspan="2" rowspan="2">REGIME DISIPLINARIO MILITAR</th>
                <th>INVESTIGACION ADMINISTRATIVA</th>
                <th class="checkbox-th" valign="middle" colspan="2" style="vertical-align: middle;"><strong class="bold-text"> SI:</strong>
                    <input type="checkbox" style="display: inline-block; margin-right: 5px;"<strong class="bold-text">NO:</strong>
                    <input type="checkbox" style="display: inline-block;">
                </th>

                <th>INVESTIGACION JUDICIAL</th>
                <th class="checkbox-th" colspan="2"><strong class="bold-text"> SI:</strong> <input type="checkbox"> <strong class="bold-text">NO:</strongd><input type="checkbox"></th>
                <th colspan="2">REGISTRO EN EL SIPOL</th>
            </tr>
            <tr>
                <th>INVESTIGACION PENAL MILITAR</th>
                <th class="checkbox-th" valign="middle" colspan="2" style="vertical-align: middle;"><strong class="bold-text"> SI:</strong>
                    <input type="checkbox" style="display: inline-block; margin-right: 5px;"><strong class="bold-text">NO:</strong>
                    <input type="checkbox" style="display: inline-block;">
                </th>
                <th>JUCIO ABIERTO</th>
                <th class="checkbox-th" valign="middle" colspan="2" style="vertical-align: middle;"><strong class="bold-text"> SI:</strong>
                    <input type="checkbox" style="display: inline-block; margin-right: 5px;"><strong class="bold-text">NO:</strong>
                    <input type="checkbox" style="display: inline-block;">
                </th>
                <th class="checkbox-th" valign="middle" colspan="2" style="vertical-align: middle;"><strong class="bold-text"> SI:</strong>
                    <input type="checkbox" style="display: inline-block; margin-right: 5px;"><strong class="bold-text">NO:</strong>
                    <input type="checkbox" style="display: inline-block;">
                </th>
            </tr>
            <tr>
                <th colspan="2">CARGO ACTUAL</th>
                <td colspan="8">{{$datos->cargo}}</td>
            </tr>
            <tr>
                <th colspan="5">ÚLTIMOS CARGOS</th>
                <th colspan="5">CURSOS REALIZADOS</th>
            </tr>
            <tr>
                <th colspan="2"> UNIDAD</th>
                <th colspan="3">DESCRIPCION/FECHA</th>
                <th>UNIDAD/PAIS</th>
                <th colspan="3">NOMBRE DEL CUROS</th>
                <th>ORDEN DE MERITO</th>
            </tr>
            <tr>
                <td colspan="2"> {{$unidad = strtoupper($cargo1->unidad)}}</td>
                <td colspan="3">{{$cargo1->cargo}}/{{$cargo1->fecha}}</td>
                <td>{{$curso1->unidad}}/{{$curso1->pais}}</td>
                <td colspan="3">{{$curso1->curso}}</td>
                <td>{{$curso1->ordenI}}/{{$curso1->ordenT}}</td>
            </tr>
            <tr>
                <td colspan="2"> {{$unidad = strtoupper($cargo2->unidad)}}</td>
                <td colspan="3">{{$cargo2->cargo}}/{{$cargo2->fecha}}</td>
                <td> {{$curso2->unidad}}/{{$curso2->pais}}</td>
                <td colspan="3">{{$curso2->curso}} </td>
                <td> {{$curso2->ordenI}}/{{$curso2->ordenT}}</td>
            </tr>
            <tr>
                <td colspan="2"> {{$unidad = strtoupper($cargo3->unidad)}}</td>
                <td colspan="3">{{$cargo3->cargo}}/{{$cargo3->fecha}}</td>
                <td> {{$curso3->unidad}}/{{$curso3->pais}}</td>
                <td colspan="3">{{$curso3->curso}}</td>
                <td>{{$curso3->ordenI}}/{{$curso3->ordenT}}</td>
            </tr>
            <tr>
                <th colspan="2">OTRAS EVALUACIONES</th>
                <td colspan="8" rowspan="5"><strong class="bold-text">APRECIACION GENERAL:
                    </strong>SE HA DESEMPEÑADO DURANTE DIECINUEVE (19) AÑOS EN UNIDADES OPERACIONALES, MANTENIÉNDOSE EN
                    SU ESPECIALIDAD COMO PILOTO DE CAZA. REGISTRA UN TOTAL DE TRES MIL TRESCIENTAS CUARENTA Y DOS (3342)
                    HORAS DE VUELO, DE LAS CUALES MIL OCHOCIENTAS DIECISÉIS (1816) SON COMO PILOTO INSTRUCTOR EN LOS
                    SISTEMAS: OV-10, SF-260, DA-40, T-27, K-8 Y SU-30. HA CUMPLIDO MISIONES PARA EL SISTEMA DE DEFENSA
                    AEROESPACIAL INTEGRAL (SIDAI), TRECE (13) COMISIONES PRESIDENCIALES COMO PILOTO, ENTRE OTRAS DE
                    RELEVADA IMPORTANCIA PARA LA DEFENSA MILITAR DE LA SOBERANÍA DEL ESTADO. FUE COMANDANTE DE LA
                    ESCUADRILLA DE POLICÍA DEL EPABARU (MAR03-ENE04). ACTUALMENTE CURSA LA MAESTRÍA EN SEGURIDAD DE LA
                    NACIÓN EN EL IAESEN (MODALIDAD SEMIPRESENCIAL). OPINIÓN DE COMANDO FAVORABLE.
                </td>
            </tr>
            <tr>
                <th>CALIFICACIÓN
                    DE CONDUCTA</th>
                <td>{{$datos->notatotal}}</td>
            </tr>
            <tr>
                <th>EVALUACIÓN
                    DE COMPAÑEROS</th>
                <td>0</td>
            </tr>
            <tr>
                <th>ENTREVISTA</th>
                <td>0</td>
            </tr>
            <tr>
                <th> EXAMEN DE CONOCIMIENTO</th>
                <td>0</td>
            </tr>
            <tr>
                <th>Proceso de Ascenso</th>
                <td colspan="2"><strong class="bold-text">OM:</strong>Orden de merito</td>
                <td><strong class="bold-text">NIEA:</strong>Nomina Inicila de ascenso </td>
                <td> <strong class="bold-text">J/A:</strong> Junta de Apreciacion</td>
                <td> <strong class="bold-text">J/R:</strong> Junta Revisora</td>
                <td><strong class="bold-text">J/C:</strong> Junta Calificadora </td>
                <td colspan="2"><strong> Situacion: </strong> R recomendado NR no recomendado</td>
                <td><strong class="bold-text">PAF</strong> :prueba de Actitu Fisica </td>
            </tr>
        </table>
    </header>

</body>

</html>
