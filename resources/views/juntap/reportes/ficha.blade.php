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
    <div class="planilla" id="content">
        <div class="header">
            <div class="databloq">
                <div class="bloque logocontainer" style="width: 100%;">
                    <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" style="width: 70px
                    ;">
                </div>
                <div style="display: flex; flex-direction: row; height: 50%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        PROM.AÑO
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        <div class="text"> {{$datos->promocion}}</div>
                    </div>
                </div>
            </div>
            <div class="databloq" style="width: 40%;"> <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                      NOMBRE Y APELLIDO
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        <div class="text">   {{ $datos->nombre1 . ' ' . $datos->nombre2 . ' ' . $datos->apellido1 . ' ' . $datos->apellido2 }}</div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                   CEDULA DE IDENTIDAD
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        <div class="text">  {{ $datos->cedula }}</div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        GDO/CAT
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        <div class="text">  {{$datos->siglas}} - {{$datos->categoria}}</div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                       AÑOS DE SERVICIO
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        <div class="text">{{strtoupper($años)}},AÑOS</div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        TIEMPO EN EL GRADO
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        <div class="text"> {{strtoupper($años)}},AÑOS</div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        ESPECIALIDAD
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        <div class="text">{{ $datos->especialidad }}</div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        NIVEL EDUCATIVO
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
                        OPORTUNIDAD DE ASCENSO
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        PRIMERA
                    </div>
                </div> </div>
            <div class="databloq" style="width: 40%;">
                <div class="bloqrow">
                    ORDEN DE MERITO ASCENSO
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        GB
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($gb) && $gb->orden_merito_ascenso != null || isset($gb) && $gb->total_orden_merito_ascenso != null)
                        {{ $gb->orden_merito_ascenso }}/ {{ $gb->total_orden_merito_ascenso }}
                    @else
                        0/0
                    @endif
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if ( isset($añoascensogb ) && $añoascensogb != null)
                        {{strtoupper( $añoascensogb )}}
                        @else
                        0
                        @endif
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        CNEL
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($cnel) && $cnel->orden_merito_ascenso != null || isset($cnel) && $cnel->total_orden_merito_ascenso != null)
                        {{ $cnel->orden_merito_ascenso }}/ {{ $cnel->total_orden_merito_ascenso }}
                    @else
                        0/0
                    @endif
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if ( isset($añoascensocnel ) && $añoascensocnel != null)
                        {{strtoupper( $añoascensocnel )}}
                        @else
                        0
                        @endif
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        TCNEL
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($tcnel) && $tcnel->orden_merito_ascenso != null || isset($tcnel) && $tcnel->total_orden_merito_ascenso != null)
                        {{ $tcnel->orden_merito_ascenso }}/ {{ $tcnel->total_orden_merito_ascenso }}
                    @else
                        0/0
                    @endif
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($añoascensotcnel) && $añoascensotcnel != null)
                        {{strtoupper( $añoascensotcnel )}}
                        @else
                        0
                        @endif
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        MY
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                          @if (isset($may) && $may->orden_merito_ascenso != null || isset($may) && $may->total_orden_merito_ascenso != null)
                        {{ $may->orden_merito_ascenso }}/ {{ $may->total_orden_merito_ascenso }}
                    @else
                        0/0
                    @endif
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($añoascensomay) && $añoascensomay != null)
                        {{strtoupper( $añoascensomay )}}
                        @else
                        0
                        @endif
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        CAP
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($cap) && $cap->orden_merito_ascenso != null || isset($cap) && $cap->total_orden_merito_ascenso != null)
                        {{ $cap->orden_merito_ascenso }}/ {{ $cap->total_orden_merito_ascenso }}
                    @else
                        0/0
                    @endif
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($añoascensocap) && $añoascensocap != null)
                        {{strtoupper( $añoascensocap )}}
                        @else
                        0
                        @endif
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        PTTE
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($ptte) && $ptte->orden_merito_ascenso != null ||isset($ptte) && $ptte->total_orden_merito_ascenso != null)
                        {{ $ptte->orden_merito_ascenso }}/ {{ $ptte->total_orden_merito_ascenso }}
                    @else
                        0/0
                    @endif
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset ($añoascensoptte) && $añoascensoptte != null)
                        {{strtoupper( $añoascensoptte )}}
                        @else
                        0
                        @endif
                    </div>
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        TTE
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset($tte) && $tte->orden_merito_ascenso != null || isset($tte) && $tte->total_orden_merito_ascenso != null)
                        {{ $tte->orden_merito_ascenso }}/ {{ $tte->total_orden_merito_ascenso }}
                    @else
                        0/0
                    @endif
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        @if (isset ($añoascensotte) && $añoascensotte != null)
                        {{ strtoupper($añoascensotte) }}
                        @else
                        0
                        @endif
                    </div>
                </div> </div>
            <div class="databloq" style="width: 40%;">
                <div class="bloqrow">
                    RESULTADOS DE EVALUACION
                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        PUNTAJE NIEA
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        0
                    </div></div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        OM NIEA
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        0
                    </div></div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        OM J/A
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        0
                    </div></div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        OM J/R
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        0
                    </div></div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        OM J/C
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        0
                    </div></div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        SITUACION
                    </div>
                    <div class="bloqrow" style="height: auto;width: 100%;"></div></div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        PAF
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
                    <div class="text"> REGIME DISIPLINARIO MILITAR </div>
                </div>
            </div>
            <div class="databloq" style="width: 100%;">
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        INVESTIGACION ADMINISTRATIVA
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
                        INVESTIGACION JUDICIAL
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
                        REGISTRO EN EL SIPOL
                    </div>

                </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 26%;">
                        INVESTIGACION PENAL MILITAR
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
                        JUCIO ABIERTO
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
                    <div class="text"> CARGO ACTUAL </div>
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
                    <div class="text"> ÚLTIMOS CARGOS </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 50%;">
                <div class="check">
                    <div class="text"> CURSOS REALIZADOS </div>
                </div>
            </div>
        </div>
        <div class="formbloq">
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> UNIDAD </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 40%;">
                <div class="check">
                    <div class="text"> DESCRIPCION/FECHA</div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> UNIDAD/PAIS </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> NOMBRE DEL CUROS </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> ORDEN DE MERITO </div>
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
                    OTRAS EVALUACIONES</div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        CALIFICACIÓN
                        DE CONDUCTA</div>
                    <div class="bloqrow" style="height: auto;width: 40%;">
                        {{$datos->notatotal}}
                    </div> </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        EVALUACIÓN
                        DE COMPAÑEROS</div>
                    <div class="bloqrow" style="height: auto;width: 40%;">
                        0
                    </div> </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        ENTREVISTA </div>
                    <div class="bloqrow" style="height: auto;width: 40%;">
                        0 </div> </div>
                <div style="display: flex; flex-direction: row; height: 100%;">
                    <div class="bloqrow" style="height: auto;width: 100%;">
                        EXAMEN DE CONOCIMIENTO</div>
                    <div class="bloqrow" style="height: auto;width: 40%;">   0 </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 100%;">
                <div class="check">
                    <div class="text"> REGIME DISIPLINARIO MILITAR </div>
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
                    <div class="text"> OM:Orden de merito</div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> NIEA:Nomina Inicila de ascenso </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> J/A Junta de Apreciacion</div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> J/R Junta Revisora </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> J/C Junta Calificadora </div>
                </div>
            </div>
            <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> Situacion:   R recomendado NR no recomendado </div>
                </div>
            </div>
             <div class="campo" style=" height: auto; width: 20%;">
                <div class="check">
                    <div class="text"> PAF :prueba de Actitu Fisica </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
