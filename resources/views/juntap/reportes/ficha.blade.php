<!DOCTYPE html>
<html>
    @php
    use Carbon\Carbon;

@endphp
<head>
<style>
    @page {
    size: 50in 100.5in landscape; /* Establece el tamaño de página en formato oficio y la orientación en horizontal */
    margin: 0.1in; /* Establece los márgenes de la página */
}
        .bloque {
            display: table;
            border: 1px solid black;
            width: 100%;
        } .planilla {
            width:auto;
            padding: 2.5cm 2cm;
            display: flex;
            flex-direction: column;
            justify-content: initial;
            font-family: 'Lato', sans-serif;
        }.header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        } .databloq {
            display: flex;
            flex-direction: column;
        } .databloq {
            font-size: 0.5rem;
        }.logocontainer {
            display: flex;
            flex-direction: columns;
            justify-content: center;
        }.header .bloque {
            height: 2.55cm;
        }.bloqrow {
            display: flex;
            border: 1px solid black;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }.header div {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }.campo {
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 1px solid black;
            height: .7cm;
            font-size: .65rem;
        }.formbloq {
            text-align: center;
            display: flex;
        }  .checkox {
            width: 10px;
            height: 10px;
            margin: 3px;
            border: 1px solid black;
            align-self: flex-end;
        }.check {
            display: flex;
            flex-direction: row;
            align-content: flex-start
        }
    </style>
<body>
    <header>
        <div class="planilla" id="content">
            <div class="header">
                <div class="databloq">
                    <div class="bloque logocontainer" style="width: 100%; height: 100%;">
                       <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" style="width: 100px
                        ;">
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>PROM.AÑO</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <div class="text"> {{$datos->promocion}}</div>
                        </div>
                    </div>
                </div>
                <div class="databloq" style="width: 100%;"> <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                          <strong>NOMBRE Y APELLIDO</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <div class="text">   {{ $datos->nombre1 . ' ' . $datos->nombre2 . ' ' . $datos->apellido1 . ' ' . $datos->apellido2 }}</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                       <strong>CEDULA DE IDENTIDAD</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <div class="text">  {{ $datos->cedula }}</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>GDO/CAT</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <div class="text">  {{$datos->siglas}} - {{$datos->categoria}}</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong>AÑOS DE SERVICIO</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <div class="text">{{strtoupper($años)}},AÑOS</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>TIEMPO EN EL GRADO</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <div class="text"> {{strtoupper($años)}},AÑOS</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>ESPECIALIDAD</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <div class="text">{{ $datos->especialidad }}</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                          <strong>  NIVEL EDUCATIVO</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            @foreach ($niveles as $key=>$value)
                            @if($datos->nivel == $key)
                            <div class="text">{{ $value }}</div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> OPORTUNIDAD DE ASCENSO</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            PRIMERA
                        </div>
                    </div> </div>
                <div class="databloq" style="width: 13%;">
                    <div class="bloqrow">
                        <strong>  ORDEN DE MERITO ASCENSO </strong>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 50px;">
                          <strong>  GB</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($gb) && $gb->orden_merito_ascenso != null || isset($gb) && $gb->total_orden_merito_ascenso != null)
                            {{ $gb->orden_merito_ascenso }}/ {{ $gb->total_orden_merito_ascenso }}
                        @else
                            0/0
                        @endif
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if ( isset($añoascensogb ) && $añoascensogb != null)
                            {{strtoupper( $añoascensogb )}}
                            @else
                            0
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 50px;">
                          <strong>  CNEL</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($cnel) && $cnel->orden_merito_ascenso != null || isset($cnel) && $cnel->total_orden_merito_ascenso != null)
                            {{ $cnel->orden_merito_ascenso }}/ {{ $cnel->total_orden_merito_ascenso }}
                        @else
                            0/0
                        @endif
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if ( isset($añoascensocnel ) && $añoascensocnel != null)
                            {{strtoupper( $añoascensocnel )}}
                            @else
                            0
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 50px;">
                           <strong> TCNEL</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($tcnel) && $tcnel->orden_merito_ascenso != null || isset($tcnel) && $tcnel->total_orden_merito_ascenso != null)
                            {{ $tcnel->orden_merito_ascenso }}/ {{ $tcnel->total_orden_merito_ascenso }}
                        @else
                            0/0
                        @endif
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($añoascensotcnel) && $añoascensotcnel != null)
                            {{strtoupper( $añoascensotcnel )}}
                            @else
                            0
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 50px;">
                           <strong> MY</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                              @if (isset($may) && $may->orden_merito_ascenso != null || isset($may) && $may->total_orden_merito_ascenso != null)
                            {{ $may->orden_merito_ascenso }}/ {{ $may->total_orden_merito_ascenso }}
                        @else
                            0/0
                        @endif
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($añoascensomay) && $añoascensomay != null)
                            {{strtoupper( $añoascensomay )}}
                            @else
                            0
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 50px;">
                           <strong> CAP</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($cap) && $cap->orden_merito_ascenso != null || isset($cap) && $cap->total_orden_merito_ascenso != null)
                            {{ $cap->orden_merito_ascenso }}/ {{ $cap->total_orden_merito_ascenso }}
                        @else
                            0/0
                        @endif
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($añoascensocap) && $añoascensocap != null)
                            {{strtoupper( $añoascensocap )}}
                            @else
                            0
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 50px;">
                           <strong> PTTE</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($ptte) && $ptte->orden_merito_ascenso != null ||isset($ptte) && $ptte->total_orden_merito_ascenso != null)
                            {{ $ptte->orden_merito_ascenso }}/ {{ $ptte->total_orden_merito_ascenso }}
                        @else
                            0/0
                        @endif
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset ($añoascensoptte) && $añoascensoptte != null)
                            {{strtoupper( $añoascensoptte )}}
                            @else
                            0
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 50px;">
                           <strong> TTE</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset($tte) && $tte->orden_merito_ascenso != null || isset($tte) && $tte->total_orden_merito_ascenso != null)
                            {{ $tte->orden_merito_ascenso }}/ {{ $tte->total_orden_merito_ascenso }}
                        @else
                            0/0
                        @endif
                        </div>
                        <div class="bloqrow" style="height: auto;width: 50px;">
                            @if (isset ($añoascensotte) && $añoascensotte != null)
                            {{ strtoupper($añoascensotte) }}
                            @else
                            0
                            @endif
                        </div>
                    </div> </div>
                <div class="databloq" style="width: 20%;">
                    <div class="bloqrow">
                        <strong> RESULTADOS DE EVALUACION </strong>
                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>PUNTAJE NIEA</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            0
                        </div></div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>OM NIEA</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            0
                        </div></div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> OM J/A</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            0
                        </div></div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>OM J/R</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            0
                        </div></div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>OM J/C</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            0
                        </div></div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> SITUACION</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;"></div></div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> PAF</strong>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            {{$datos->total}}
                        </div></div> </div>
            </div>
            <div class="formbloq">
                <div class="campo" style="width: 10%;">
                    <div class="label">N° DE TELEFONO</div>
                </div>
                <div class="campo" style="width: 15%;">
                    <div class="input"> <strong>{{$datos->telefono}}</strong> </div>
                </div>
                <div class="campo" style="width: 80%;display: flex; flex-wrap: wrap;">
                    <div class="label" style="width: 150px;">CMDTE DE UNIDAD</div>
                    <div class="input" style="width: 200px;"> <strong>{{$cmdt->nombre1 . ' ' . $cmdt->nombre2 . ' ' . $cmdt->apellido1}}</strong> </div>
                    <div class="input" style="width: 50px;"> <strong>TLF:</strong> </div>
                    <div class="input" style="width: 150px;"> <strong>{{$cmdt->telefono_cel}}</strong> </div>
                </div> </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 30%;">
                    <div class="check">
                        <div class="text"> <strong>REGIME DISIPLINARIO MILITAR</strong> </div>
                    </div>
                </div>
                <div class="databloq" style="width: 100%;">
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> INVESTIGACION ADMINISTRATIVA</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="bloqrow" style="height: auto;width: 100%; display: flex; flex-direction: row;">
                                <div style="display: inline-flex; margin-right: 10px;">SI <div class="checkox"></div>
                                </div>
                                <div style="display: inline-flex;">NO <div class="checkox"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 110%;">
                           <strong> INVESTIGACION JUDICIAL</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="bloqrow" style="height: auto;width: 100%; display: flex; flex-direction: row;">
                                <div style="display: inline-flex; margin-right: 10px;">SI <div class="checkox"></div>
                                </div>
                                <div style="display: inline-flex;">NO <div class="checkox"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>REGISTRO EN EL SIPOL</strong>
                        </div>

                    </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 26%;">
                           <strong> INVESTIGACION PENAL MILITAR</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="bloqrow" style="height: auto;width: 100%; display: flex; flex-direction: row;">
                                <div style="display: inline-flex; margin-right: 10px;">SI <div class="checkox"></div>
                                </div>
                                <div style="display: inline-flex;">NO <div class="checkox"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bloqrow" style="height: auto;width: 30%;">
                            <strong>JUCIO ABIERTO</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div class="bloqrow" style="height: auto;width: 100%; display: flex; flex-direction: row;">
                                <div style="display: inline-flex; margin-right: 10px;">SI <div class="checkox"></div>
                                </div>
                                <div style="display: inline-flex;">NO <div class="checkox"></div>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; width: 26.2%;">
                            <div class="bloqrow" style="height: auto;width: 100%; display: flex; flex-direction: row;">
                                <div style="display: inline-flex; margin-right: 10px;">SI <div class="checkox"></div>
                                </div>
                                <div style="display: inline-flex;">NO <div class="checkox"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 30%;">
                    <div class="check">
                        <div class="text"> <strong>CARGO ACTUAL </strong></div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 100%;">
                    <div class="check">
                        <div class="text">{{$datos->cargo}}</div>
                    </div>
                </div>
            </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 50%;">
                    <div class="check">
                        <div class="text"> <strong>ÚLTIMOS CARGOS </strong></div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 50%;">
                    <div class="check">
                        <div class="text"> <strong>CURSOS REALIZADOS </strong></div>
                    </div>
                </div>
            </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"><strong> UNIDAD</strong> </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 40%;">
                    <div class="check">
                        <div class="text"><strong> DESCRIPCION/FECHA</strong></div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>UNIDAD/PAIS </strong></div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>NOMBRE DEL CUROS</strong> </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>ORDEN DE MERITO </strong></div>
                    </div>
                </div>
            </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$cargo1->unidad}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 40%;">
                    <div class="check">
                        <div class="text">{{$cargo1->cargo}}/{{$cargo1->fecha}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text">{{$curso1->unidad}}/{{$curso1->pais}} </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso1->curso}} </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso1->ordenI}}/{{$curso1->ordenT}}  </div>
                    </div>
                </div>
            </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$cargo2->unidad}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 40%;">
                    <div class="check">
                        <div class="text">{{$cargo2->cargo}}/{{$cargo2->fecha}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso2->unidad}}/{{$curso2->pais}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso2->curso}}  </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso2->ordenI}}/{{$curso2->ordenT}}  </div>
                    </div>
                </div>
            </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text">{{$cargo3->unidad}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 40%;">
                    <div class="check">
                        <div class="text">{{$cargo3->cargo}}/{{$cargo3->fecha}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso3->unidad}}/{{$curso3->pais}}</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso3->curso}} </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> {{$curso3->ordenI}}/{{$curso3->ordenT}}</div>
                    </div>
                </div>
            </div>
            <div class="formbloq"><div class="databloq" style="width: 40%;">
                    <div class="bloqrow" style="width: 100%;">
                        <strong>OTRAS EVALUACIONES</strong></div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                            <strong>CALIFICACIÓN
                            DE CONDUCTA</strong></div>
                        <div class="bloqrow" style="height: auto;width: 40%;">
                            {{$datos->notatotal}}
                        </div> </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> EVALUACIÓN
                            DE COMPAÑEROS</strong>
                    </div>
                    <div class="bloqrow" >
                        0
                        </div> </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> ENTREVISTA </strong></div>
                        <div class="bloqrow" style="height: auto;width: 40%;">
                            0 </div> </div>
                    <div style="display: flex; flex-direction: row; height: 100%;">
                        <div class="bloqrow" style="height: auto;width: 100%;">
                           <strong> EXAMEN DE CONOCIMIENTO</strong></div>
                        <div class="bloqrow" style="height: auto;width: 40%;">   0 </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 100%;">
                    <div class="check">
                        <div style="display: flex; justify-content: flex-start;">
                            <div  class="text" style="text-align: left;">
                              <strong>APRECIACION GENERAL:
                              </strong>SE HA DESEMPEÑADO DURANTE DIECINUEVE (19) AÑOS EN UNIDADES OPERACIONALES, MANTENIÉNDOSE EN SU ESPECIALIDAD COMO PILOTO DE CAZA. REGISTRA UN TOTAL DE TRES MIL TRESCIENTAS CUARENTA Y DOS (3342) HORAS DE VUELO, DE LAS CUALES MIL OCHOCIENTAS DIECISÉIS (1816) SON COMO PILOTO INSTRUCTOR EN LOS SISTEMAS: OV-10, SF-260, DA-40, T-27, K-8 Y SU-30. HA CUMPLIDO MISIONES PARA EL SISTEMA DE DEFENSA AEROESPACIAL INTEGRAL (SIDAI), TRECE (13) COMISIONES PRESIDENCIALES COMO PILOTO, ENTRE OTRAS DE RELEVADA IMPORTANCIA PARA LA DEFENSA MILITAR DE LA SOBERANÍA DEL ESTADO. FUE COMANDANTE DE LA ESCUADRILLA DE POLICÍA DEL EPABARU (MAR03-ENE04). ACTUALMENTE CURSA LA MAESTRÍA EN SEGURIDAD DE LA NACIÓN EN EL IAESEN (MODALIDAD SEMIPRESENCIAL). OPINIÓN DE COMANDO FAVORABLE.
                            </div>
                          </div>
                    </div>
                </div>
            </div>
            <div class="formbloq">
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> Proceso de Ascenso</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 40%;">
                    <div class="check">
                        <div class="text"> <strong>OM:</strong>Orden de merito</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>NIEA:</strong>Nomina Inicila de ascenso </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>J/A:</strong> Junta de Apreciacion</div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>J/R:</strong> Junta Revisora </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>J/C:</strong> Junta Calificadora </div>
                    </div>
                </div>
                <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"><strong> Situacion: </strong>  R recomendado NR no recomendado </div>
                    </div>
                </div>
                 <div class="campo" style=" height: auto; width: 20%;">
                    <div class="check">
                        <div class="text"> <strong>PAF</strong> :prueba de Actitu Fisica </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

</body>

</html>
