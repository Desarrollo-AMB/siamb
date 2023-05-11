@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Escalafon</title>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 200px 20px 60px;
            }

            header {
                position: fixed;
                top: -165px;
                left: 0px;
                right: 0px;
                height: 100px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                border-radius: 35px;

                line-height: 20px;
            }

            main {
                /** Posicion **/
                position: relative;
                top: -50px;

                /** Tamaño de Fuente **/
                font-size: 12px;
            }

            footer {
                position: fixed;
                bottom: -25px;
                left: 0px;
                right: 0px;
                height: 30px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 20px;
                border-radius: 35px;
            }

            .page:after {
                content: counter(page);
            }
        </style>
    </head>
    <body>
        <header>
            <table cellspacing="10">
                <tr>
                    <th align="center">REPÚBLICA BOLIVARIANA DE VENEZUELA<br>MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>AVIACIÓN MILITAR NACIONAL BOLIVARIANA</th>

                    <th align="center">ESCALAFON GENERAL DEL PERSONAL MILITAR</th>

                    <th align="left">FECHA: {{date('d/m/Y')}}</th>

                    <th>
                        <img src="template/assets/img/logo.png" alt="" width="60">
                    </th>
                </tr>
            </table>
        </header>

        <footer class="page">
        </footer>

        <main>
            @php
            $i = 0;
            @endphp
            @foreach($agrupados as $grado => $categorias)
                @switch($grado)
                    @case('10')
                        @php
                            $grado_desc = 'GENERAL EN JEFE';
                        @endphp
                    @break

                    @case('15')
                        @php
                            $grado_desc = 'MAYOR GENERAL';
                        @endphp
                    @break

                    @case('020')
                        @php
                            $grado_desc = 'GENERAL DE DIVISIÓN';
                        @endphp
                    @break

                    @case('030')
                        @php
                            $grado_desc = 'GENERAL DE BRIGADA';
                        @endphp
                    @break

                    @case('040')
                        @php
                            $grado_desc = 'CORONEL';
                        @endphp
                    @break

                    @case('050')
                        @php
                            $grado_desc = 'TENIENTE CORONEL';
                        @endphp
                    @break

                    @case('060')
                        @php
                            $grado_desc = 'MAYOR';
                        @endphp
                    @break

                    @case('070')
                        @php
                            $grado_desc = 'CAPITAN';
                        @endphp
                    @break

                    @case('080')
                        @php
                            $grado_desc = 'PRIMER TENIENTE';
                        @endphp
                    @break

                    @case('090')
                        @php
                            $grado_desc = 'TENIENTE';
                        @endphp
                    @break

                    @case('410')
                        @php
                            $grado_desc = 'SARGENTO SUPERVISOR';
                        @endphp
                    @break

                    @case('420')
                        @php
                            $grado_desc = 'SARGENTO AYUDANTE';
                        @endphp
                    @break

                    @case('430')
                        @php
                            $grado_desc = 'SARGENTO MAYOR DE PRIMERA';
                        @endphp
                    @break

                    @case('440')
                        @php
                            $grado_desc = 'SARGENTO MAYOR DE SEGUNDA';
                        @endphp
                    @break

                    @case('450')
                        @php
                            $grado_desc = 'SARGENTO MAYOR DE TERCERA';
                        @endphp
                    @break

                    @case('460')
                        @php
                            $grado_desc = 'SARGENTO PRIMERO';
                        @endphp
                    @break

                    @case('470')
                        @php
                            $grado_desc = 'SARGENTO SEGUNDO';
                        @endphp
                    @break

                    @default
                        @php
                            $grado_desc = 'NO POSEE';
                        @endphp
                @endswitch
                <h3>Grado Militar: {{ $grado_desc }}</h3>
                @foreach($categorias as $categoria => $escalafon)
                    @switch($categoria)
                        @case('2')
                            @php
                                $categoria_desc = 'ASIMILADO';
                            @endphp
                        @break

                        @case('4')
                            @php
                                $categoria_desc = 'EFECTIVO DE COMANDO';
                            @endphp
                        @break

                        @case('5')
                            @php
                                $categoria_desc = 'EFECTIVO TECNICO';
                            @endphp
                        @break

                        @case('6')
                            @php
                                $categoria_desc = 'ASIMILADO TECNICO';
                            @endphp
                        @break

                        @case('7')
                            @php
                                $categoria_desc = 'EFECTIVO COMANDO DE TROPA';
                            @endphp
                        @break

                        @case('8')
                            @php
                                $categoria_desc = 'TROPA PROFESIONAL';
                            @endphp
                        @break

                        @default
                            @php
                                $categoria_desc = 'NO POSEE';
                            @endphp
                    @endswitch
                    <h3>Categoría: {{ $categoria_desc }}</h3>
                    <hr>

                    <table>
                        <thead>
                            <tr>
                                <th align="left">Orden Antig.</th>
                                <th align="left">Cedula</th>
                                <th align="left">Nombres y Apellidos</th>
                                <th align="left">Edad</th>
                                <th align="left">Sexo</th>
                                <th align="left">O.M.P</th>
                                <th align="left">Fecha Graduación</th>
                                <th align="left">Fecha Ult. Asc.</th>
                                <th align="left">Fecha Retiro</th>
                                <th align="left">CEAMB-1</th>
                                <th align="left">CEAMB-2</th>
                                <th align="left" style="word-wrap: break-word">Cargo y Ubicación</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($escalafon as $row)
                                @php
                                if ($row->sexo === 'M') {
                                    $sexo = 'MASCULINO';
                                }
                                else {
                                    $sexo = 'FEMENINA';
                                }

                                $i++;
                                $date = Carbon::createFromDate($row->fecha_nacim)->age;
                                $graduacion = date("d/m/Y", strtotime($row->graduacion));
                                $ultimo_ascenso = date("d/m/Y", strtotime($row->ultimo_ascenso));
                                $retiro = date("d/m/Y", strtotime($row->retiro));
                                @endphp
                                <tr>
                                    <td align="center">{{ $i." ".$row->grado_militar}}</td>
                                    <td>{{$row->cedula}}</td>
                                    <td>{{$row->nombre1." ".$row->nombre2." ".$row->apellido1." ".$row->apellido2}}</td>
                                    <td>{{$date}}</td>
                                    <td>{{$sexo}}</td>
                                    <td align="center">{{$row->orden_merito."/".$row->total_merito}}</td>
                                    <td>{{$graduacion}}</td>
                                    <td>{{$ultimo_ascenso}}</td>
                                    <td>{{$retiro}}</td>
                                    <td>{{$row->especialidad1}}</td>
                                    <td>{{$row->especialidad2}}</td>
                                    <td>{{$row->cargo." - ".$row->ubicacion}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="page-break-after:always;"></div>
                @endforeach
            @endforeach
        </main>
    </body>
</html>
