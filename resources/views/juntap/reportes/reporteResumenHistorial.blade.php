<style>
    * {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .tabels {
        border: 2px solid black;
        border-collapse: collapse;
        width: 100%;

    }

    .tabels th,
    .tabels td {
        border: 2px solid black;
        padding: 8px;
        line-height: 1;
    }

    .fixed {
        height: auto;
    }

    div {
        margin-bottom: 3%;
    }

    .divtitulo {
        margin-bottom: 0%;
    }

    footer {
        background-color: #ffffff;
        color: #000000;
        padding: 10px;
        height: -30cm;
        text-align: center;
    }

    .fondo-th {
        text-align: center;
        background-color: #337AFF;
    }

    .img {
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        width: 16.5%;
        height: 26.3%;
        margin-top: 35%;
        margin-left: 82%;
        border: 2px solid black;
    }
</style>
<header>
   
</header>

<body>
    <div class="header">
        {{--<div class="bloque logocontainer" style="width: 12%;">
            <img class="logo" src="template/assets/img/logo.png" alt="Logo Aviacion">
        </div>--}}
        <div class="bloque" style="text-align:center;font-size:1rem">
            <strong>
                <div class="divtitulo"> República Bolivariana de Venezuela </div>
                <div class="divtitulo"> Ministerio del Poder Popular para la Defensa </div>
                <div class="divtitulo"> Aviación Militar Bolivariana </div>
            </strong>
        </div>
        <div>
            <h1 style="text-align: center;  text-decoration: underline;">Resumen Digital del Historial (MPPD)</h1>
        </div>
    </div>
    <div>


        <div>

            <table class="tabels">
                <tr>
                    <th class="fondo-th" colspan="6">DATOS PERSONALES</th>
                </tr>
                {{-- <tr>

                </tr>--}}
                <tr>
                    <th>Grado</th>
                    <td colspan="4" class="fixed" >TTE </td>
                    <th style=" width: 20%; background-color: #337AFF;" rowspan="10">
                        <img src="{{ $datos->foto ? url($datos->foto): '' }}" class="img"></th> </tr>
                <tr>
                    <th>Nombre y Apellido</th>
                    <td colspan="4" class="fixed">{{$datos->nombre1.' '.$datos->nombre2}}, {{$datos->apellido1.'
                        '.$datos->apellido2}}</td>
                    </td>
                </tr>
                <tr>
                <th>Cedula de Identidad</th>
                <td colspan="4" class="fixed">{{$datos->cedula}}</td>
            </tr>
                
                <tr>
                <th>Fecha de Nacimiento</th>
                <td colspan="4" class="fixed">{{$datos->cargo}}</td>
                </tr>
                <tr>
                    <th>Fecha de ultimo Ascenso</th>
                    <td colspan="4" class="fixed">{{$datos->ubicacion}}</td>
                </tr>
                <tr>
                    <th> Fecha de Ingreso</th>
                    <td colspan="4" class="fixed">{{$datos->cedula}}</td>
                </tr>
                <tr>
                    @if($datos->edo_civil == 'SO')
                    <th>Estado civil</th>
                    <td colspan="4" class="fixed">Soltero</td>
                    @elseif($datos->edo_civil == 'CA')
                    <th>Estado civil</th>
                    <td colspan="4" class="fixed">Casado</td>
                        
                    @endif
                </tr>
                <tr>
                    <th>Direccion</th>
                    <td colspan="4" class="fixed">{{$datos->direccion}}</td>
                </tr>
                <tr>
                    <th>Telefono</th>
                    <td colspan="4" class="fixed">{{$datos->telefono}}</td>
                </tr>
                <tr>
                    <th>Cargo actual por resolucion</th>
                    <td colspan="4" class="fixed">{{$datos->cargo}}--{{$datos->ubicacion}}</td>
                </tr>
               
            </table>
        </div>
        <div>
            <table class="tabels">
                <tr>
                    <th class="fixed fondo-th" colspan="5">ASCENSOS</th>
                </tr>
                <tr>

                    <th>Grado</th>
                    <th>Fecha de Ascenso</th>
                    <th>Resolucion</th>
                    <th>Orden de Mérito</th>
                    <th>Total de Orden de Mérito</th>
                </tr>
                @foreach($historico as $historico)
                <tr>
                    <td class="fixed">{{$historico->grado}}</td>
                    <td class="fixed">{{$historico->fecha_a}}</td>
                    <td class="fixed">{{$historico->orden_merito}}</td>
                    <td class="fixed">{{$historico->total_orden_merito}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div>
            <table class="tabels">
                <tr>
                    <th class="fixed fondo-th" colspan="5">ESTUDIOS MILITARES Y/O CIVILES</th>
                </tr>
                <tr>

                    <th>Profresion</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Pais</th>
                    <th>Resultado</th>
                </tr>
                @foreach($estudios as $estudios)
                <tr>
                    <td class="fixed">{{$estudios->descripcion}}</td>
                    <td class="fixed">{{$estudios->desde}}</td>
                    <td class="fixed">{{$estudios->hasta}}</td>
                    <td class="fixed">{{$estudios->pais}}</td>
                    <td class="fixed">{{$estudios->resultado}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div>
            <table class="tabels">
                <tr>
                    <th class="fixed fondo-th" colspan="3">CARGOS</th>
                </tr>
                <tr>

                    <th>Cargo</th>
                    <th>Fecha de Inicio</th>
                    <th> Nro. Resolucion</th>
                </tr>
                @foreach($cargos as $cargos)
                <tr>
                    <td class="fixed">{{$cargos->cargo}} ({{$cargos->unidad}})</td>
                    <td class="fixed">{{$cargos->fecha}}</td>
                    <td class="fixed">{{$cargos->resolucion}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div>
            <table class="tabels">
                <tr>
                    <th class="fixed fondo-th" colspan="5">SANCIONES</th>
                </tr>
                <tr>

                    <th>Grado</th>
                    <th>Naturaleza</th>
                    <th>Causa</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                </tr>
                @foreach($sanciones as $sanciones)
                <tr>
                    <th>{{$sanciones->grado}}</th>

                    @if($sanciones->naturaleza == '1')
                    <th>AMONESTACION</th>
                    @elseif($sanciones->naturaleza == '2')
                    <th>SANCION SIMPLE</th>
                    @elseif($sanciones->naturaleza == '3')
                    <th>SANCION SEVERA</th>
                    @endif
                    <th>{{$sanciones->falta_real}}</th>
                    <th>{{$sanciones->desde}}</th>
                    <th>{{$sanciones->hasta}}</th>
                </tr>
                @endforeach
            </table>
        </div>

    </div>
    

</body>