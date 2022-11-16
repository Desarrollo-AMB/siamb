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
                margin: 180px 20px 60px;
            }

            header {
                position: fixed;
                top: -165px;
                left: 0px;
                right: 0px;
                height: 160px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                
                line-height: 20px;
            }

            main {
                font-size: 12px;
            }

            footer {
                position: fixed; 
                bottom: -50px; 
                left: 0px; 
                right: 0px;
                height: 30px; 

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 20px;
            }
        </style>
    </head>
    <body>
        <header>
            <table cellspacing="10">
                <tr>
                    <th align="center">REPÚBLICA BOLIVARIANA DE VENEZUELA<br>MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>AVIACIÓN MILITAR NACIONAL BOLIVARIANA</th>

                    <th align="center">ESCALAFON GENERAL DEL PERSONAL MILITAR</th>

                    <th align="left">FECHA: {{date('d/m/Y')}}<br>PAGINA: {{'PAGINA DE PAGINAS'}}</th>
                </tr>

                <tr>
                    <th style="text-align: left; font-size: 10">Grado: {{$empleados[0]->grado_militar}}</th>
                </tr>

                <tr>
                    <th style="text-align: left; font-size: 10">Categoria: {{$empleados[0]->categoria}}</th>
                </tr>
            </table>
        </header>

        <footer>
            
        </footer>

        <main>
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
                    {{$i = 0}}
                    @foreach ($empleados as $row)
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
                            <td align="center">{{$i}}</td>
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
        </main>
    </body>
</html>