@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro Indivisual de Vuelo para Pilotos</title>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 96px 72px;
            }

            main {
                /** Posicion **/
                position: relative;
                top: -50px;

                /** Tamaño de Fuente **/
                font-size: 12px;
            }

            /*.page:after {
                content: counter(page);
            }*/
        </style>
    </head>
    <body>
        <footer class="page">
        </footer>

        <main>
            <table border="1">
                <thead>
                    <tr>
                        <th colspan="10">REGISTRO INDIVIDUAL PARA PILOTOS</th>
                        <th>
                            1. HOJA N°
                        </th>
                        <th>
                            2. MES Y AÑO
                            <br><br>
                            @php
                                $cantidad = count($piloto);

                                $desde = $piloto[0]->fecha;
                                for ($i=0; $i < $cantidad; $i++) { 
                                    $hasta = $piloto[$i]->fecha;
                                }

                                $desde = date("My", strtotime($desde));
                                $hasta = date("My", strtotime($hasta));

                                if ($desde === $hasta) {
                                    $intervalo = $desde;
                                }
                                else {
                                    $intervalo = $desde." - ".$hasta;
                                }
                            @endphp
                            {{$intervalo}}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="12">DATOS DEL PILOTO</th>
                    </tr>
                    <tr>
                        <th align="left" colspan="4">
                            3. DATOS Y NOMBRES
                            <br><br>
                            {{$piloto[0]->nombre}}
                        </th>
                        <th align="left" colspan="2">
                            4. CEDULA DE IDENTIDAD
                            <br><br>
                            {{$piloto[0]->cedula}}
                        </th>
                        <th align="left" colspan="2">
                            5. FECHA-GRADO PILOTO
                            <br><br>
                            fecha graduacion como piloto
                            {{--$piloto[0]->--}}
                        </th>
                        <th align="left" colspan="2">
                            6. CLASIFICACIÓN AERONAUTICA ACTUAL
                            <br><br>
                            {{$piloto[0]->nombre_funcion}}
                        </th>
                        <th align="left" colspan="2">
                            7. CEFA ACTUAL
                            <br><br>
                            {{$piloto[0]->especialidad}}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="12">UNIDAD</th>
                    </tr>
                    <tr>
                        <th align="left" colspan="6">
                            8. COMANDO
                            <br><br>
                            {{$piloto[0]->organismo}}
                        </th>
                        <th align="left" colspan="4">
                            9. GRUPO
                            <br><br>
                            {{$piloto[0]->unidad}}
                        </th>
                        <th align="left" colspan="2">
                            10. ESCUADRON
                            <br><br>
                            {{$piloto[0]->unidad}}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="12">EL TIEMPO DE VUELO</th>
                    </tr>
                    <tr>
                        <th rowspan="2">11. DIA</th>
                        <th rowspan="2">12. TIPO AVION</th>
                        <th rowspan="2">13. MISION</th>
                        <th rowspan="2">14. FUNCION</th>
                        <th rowspan="2">15. TIEMPO</th>
                        <th colspan="2">DIA</th>
                        <th colspan="2">NOCHE</th>
                        <th rowspan="2">20. ATERRIZ.</th>
                        <th rowspan="2">21. SIMUL.</th>
                        <th rowspan="2">22. COMBATE</th>
                    </tr>
                    <tr>
                        <th>16. V.F.R</th>
                        <th>17. I.F.R</th>
                        <th>18. V.F.R</th>
                        <th>19. I.F.R</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- DECLARACION DE VARIABLES NUEVAS -->
                    @php
                    $total_tiempo = 0;
                    $total_vfr_dia = 0;
                    $total_ifr_dia = 0;
                    $total_vfr_noche = 0;
                    $total_ifr_noche = 0;
                    $total_aterriz = 0;
                    $total_simul = 0;
                    $total_combate = 0;
                    @endphp
                    @foreach ($piloto as $pilot)
                        <tr>
                            <th>{{$pilot->fecha}}</th>
                            <th>{{$pilot->aeronave." (".$pilot->modelo.")"}}</th>
                            <th>{{$pilot->COD}}</th>
                            <th>{{$pilot->funcion}}</th>
                            <th>{{$pilot->hv}}</th>
                            <th>{{$pilot->hv}}</th>
                            <th>{{$pilot->hv}}</th>
                            <th>{{$pilot->hv}}</th>
                            <th>{{$pilot->hv}}</th>
                            <th>{{$pilot->aterriz}}</th>
                            <th>{{$pilot->aterriz}}</th>
                            <th>{{$pilot->aterriz}}</th>
                            @php
                            $total_tiempo = $total_tiempo + $pilot->hv;
                            $total_vfr_dia = $total_vfr_dia + $pilot->hv;
                            $total_ifr_dia = $total_ifr_dia + $pilot->hv;
                            $total_vfr_noche = $total_vfr_noche + $pilot->hv;
                            $total_ifr_noche = $total_ifr_noche + $pilot->hv;
                            $total_aterriz = $total_aterriz + $pilot->aterriz;
                            $total_simul = $total_simul + $pilot->aterriz;
                            $total_combate = $total_combate + $pilot->aterriz;
                            @endphp
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th align="left" colspan="4">23. TOTALES ESTA HOJA</th>
                        <th>{{$total_tiempo}}</th>
                        <th>{{$total_vfr_dia}}</th>
                        <th>{{$total_ifr_dia}}</th>
                        <th>{{$total_vfr_noche}}</th>
                        <th>{{$total_ifr_noche}}</th>
                        <th>{{$total_aterriz}}</th>
                        <th>{{$total_simul}}</th>
                        <th>{{$total_combate}}</th>
                    </tr>
                    <!-- DECLARACION DE VARIABLES ANTERIORES -->
                    @php
                        $tiempo_anterior = 0;
                        $vfr_dia_anterior = 0;
                        $ifr_dia_anterior = 0;
                        $vfr_noche_anterior = 0;
                        $ifr_noche_anterior = 0;
                        $aterriz_anterior = 0;
                        $simul_anterior = 0;
                        $combate_anterior = 0;
                    @endphp
                    @foreach ($anteriores as $row)
                        @php
                            $tiempo_anterior = $tiempo_anterior + $row->hv;
                            $vfr_dia_anterior = $vfr_dia_anterior + $row->hv;
                            $ifr_dia_anterior = $ifr_dia_anterior + $row->hv;
                            $vfr_noche_anterior = $vfr_noche_anterior + $row->hv;
                            $ifr_noche_anterior = $ifr_noche_anterior + $row->hv;
                            $aterriz_anterior = $aterriz_anterior + $row->aterriz;
                            $simul_anterior = $simul_anterior + $row->aterriz;
                            $combate_anterior = $combate_anterior + $row->aterriz;
                        @endphp
                    @endforeach
                    <tr>
                        <th align="left" colspan="4">24. TOTALES ANTERIORES</th>
                        <th>{{$tiempo_anterior}}</th>
                        <th>{{$vfr_dia_anterior}}</th>
                        <th>{{$ifr_dia_anterior}}</th>
                        <th>{{$vfr_noche_anterior}}</th>
                        <th>{{$ifr_noche_anterior}}</th>
                        <th>{{$aterriz_anterior}}</th>
                        <th>{{$simul_anterior}}</th>
                        <th>{{$combate_anterior}}</th>
                    </tr>
                    <tr>
                        <th align="left" colspan="4">25. TOTALES GENERALES</th>
                        <th>{{$total_tiempo+$tiempo_anterior}}</th>
                        <th>{{$total_vfr_dia+$vfr_dia_anterior}}</th>
                        <th>{{$total_ifr_dia+$ifr_dia_anterior}}</th>
                        <th>{{$total_vfr_noche+$vfr_noche_anterior}}</th>
                        <th>{{$total_ifr_noche+$ifr_noche_anterior}}</th>
                        <th>{{$total_aterriz+$aterriz_anterior}}</th>
                        <th>{{$total_simul+$simul_anterior}}</th>
                        <th>{{$total_combate+$combate_anterior}}</th>
                    </tr>
                </tfoot>
            </table>
        </main>
        <!--<div style="page-break-after:always;"></div>-->
    </body>
</html>
