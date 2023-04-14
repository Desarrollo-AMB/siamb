
@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Parte por Unidad </title>
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap-3.3.7-dist/css/bootstrap.css') }}">
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 150px 30px 60px;
            }

            header {
                position: fixed;
                top: -125px;
                left: 0px;
                right: 0px;
                height: 100px;

                /** Extra personal styles **/
                background-color: #303e55;
                color: white;

                line-height: 20px;
            }

            footer {
                position: fixed;
                bottom: -50px;
                left: 0px;
                right: 0px;
                height: 30px;

                /** Extra personal styles **/
                background-color: #303e55;
                color: white;
                text-align: center;
                line-height: 20px;
            }
            main {
                font-size: 1rem;
            }

            small {
                color: white !important;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
        <style>
            table {
              border-collapse: collapse;
              margin-top: 30px;
              float: left;
            }

            #table2 {
              float: left;
              margin-left: 20px;
              margin-top: 30px;
            }


            th,
            td {
              border: 1px solid black;
              padding: 10px;
            }
          </style>
        <style>
             table.title {
                border: 1px solid #ccc;
                margin-left: 5px;
                margin-top: -9px;
                }
                table.title th, table.title td {
                border: 0px solid rgb(14, 13, 13);
                padding: 1px;
                font-size: 12px;
                }
            .tabla-contenedor {
  display: flex;
  justify-content: space-between;
}

.tabla-partes, .tabla-der,.tabla-lista  {
  flex: 1;
}
             table.centers {
        border-collapse: collapse;
        border: 1px solid #ccc;
        margin-left: 50px;


    }
    table.centers th, table.centers td {
        border: 1px solid #ccc;
        padding: 2px;
    }
            table.partes {
        border-collapse: collapse;
        border: 0px solid #ccc;
    }
    table.partes th, table.partes td {
        border: 1px solid #ccc;
        padding: 2px;
    }


    table.lista {

        border: 1px solid #ccc;
        margin-left: -600px;
        margin-top: 450px;
    }
    table.lista th, table.lista td {
        border: 1px solid #ccc;
        padding: 2px;
    }
    table.der {
        border-collapse: collapse;
        border: 0px solid #ccc;
        margin-left: 450px;
        margin-top: -1px;
    }
    table.der th, table.der td {
        border: 1px solid #ccc;
        padding: 2px;
    }
    th{
        font-size: 9.8px;
    }
        </style>
    </head>
    <body>
        <div class="row" style="margin-top:-120px">
            <div class="col-xs-2">
                <img src="{{asset('template/assets/img/logo.png')}}" width="70px" alt="logo">
            </div>
            <div class="col-xs-6" style="text-align: center;">
                <h5>REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>
                AVIACIÓN MILITAR BOLIVARIANA<br>
                DIRECCIÓN DE PERSONAL
                    <small>  </small>
                </h5>
            </div>
            <div class="col-xs-3">

            </div>
        </div>

        <main>

            <div class="tabla-contenedor">
                <table class="title">
                    <tr><th>Ubicacion:</th>  <td>{{ $datas->ubicacion}}</td></tr>
                 </table>
                 <br>
                <table class=" partes"style="float:left;">
                    <thead>
                            <tr>
                                <th scope="col" class="center" colspan="2">Parte General</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Personal</th>

                                <td>{{ $nomina_count }}</td>
                                </tr>
                        <tr>
                            <th>Presente</th>
                            <td>{{ $datas->totalq }}</td>
                        </tr>
                        <tr>
                            <th>faltan</th>
                            <td>{{ $ausentes_count }}</td>
                        </tr>
                        <tr>
                            <th>Servicio en la Unidad</th>
                            <td>{{ $datas->total3 }}</td>
                        </tr>
                        <tr>
                            <th>Servicio feura de la unidad</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Retardado</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Permiso</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Comisión País</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Comisíon Exterior</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Curso País</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Curso Exterior</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Ausente sin Causa Justificada</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Destacado fuera de la Unidad</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Consulta</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Reposo</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Hospiatalizado</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Desertor</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Privado de Libertad</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>
                        <tr>
                            <th>Otro</th>
                            <td>{{ $datas->total2}}</td>
                        </tr>

                    </tbody>



                </table>

                <table border="1"class="centers" >
                    <thead>

                            <tr>
                                <th scope="col" class="center" colspan="2">Parte por categoira</th>
                            </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <th>Oficial Efectivo Comando</th>
                                <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>Oficial Efectivo Tecnico</th>
                                <td>{{ $datas->tecnico }}</td>
                        </tr>
                        <tr>
                            <th>Efectivo Comado de tropa</th>
                            <td>{{ $datas->tropacmd }}</td>
                        </tr>
                        <tr>
                            <th>Oficial Asimilado Tecnico</th>
                            <td>{{ $datas->asimiladotc }}</td>
                        </tr>
                        <tr>
                            <th>Oficial Asimilado</th>
                            <td>{{ $datas->asimilado }}</td>
                        </tr>
                        <tr>
                            <th>Tropa Profesional</th>
                            <td>{{ $datas->trp }}</td>
                        </tr>
                    </tbody>
                </table>

                <table id="table2" class="der" >
                    <thead>
                        <tr>
                            <th scope="col" class="center" colspan="8">Parte por Grado</th>
                        </tr>
                        <tr>
                            <th>Grado</th>
                            <th>CDO.</th>
                            <th>CDO.TRP</th>
                            <th>TECN</th>
                            <th>ASIM</th>
                            <th>AS TEC</th>
                            <th>TRP</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>G/J</th>
                                <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>M/J</th>

                                <td>{{ $datas->tecnico }}</td>
                                <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>G/D</th>
                            <td>{{ $datas->tropacmd }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>G/B</th>
                            <td>{{ $datas->asimiladotc }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>CNEL </th>
                            <td>{{ $datas->asimilado }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>TCNEL</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>MAY</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>CAP</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>PTTE</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>TTE</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}



                                </td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>S/S</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>S/A</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>SM/1ERA</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>SM/2DA</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>SM/3RA</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>S/1ERO</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>S/2DO</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                        <tr>
                            <th>TOTAL</th>
                            <td>{{ $datas->trp }}</td>
                            <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                                 <td>{{ $datas->comando }}</td>
                        </tr>
                    </tbody>
                </table >
                <br>
                <table class="lista">
                    <thead>
                        <tbody>
                            <tr>
                                <th>Nombre1</th>
                                <th>Apellido</th>
                                <th>Cedula </th>
                                <th>Categoria</th>
                                <th>Situacion</th>
                                <th>Observaciones</th>
                            </tr>

                        </tbody>
                        <td>{{$datas->nombre}}</td>
                        <td>{{$datas->apellida}}</td>
                        <td>{{ $datas->cedula }}</td>
                        <td>ee</td>
                        <td>{{ $datas->ubicacion }}</td>
                        <td></td>
                    </thead>
                </table>
            </div>


        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $x = $pdf->get_width()-100; //510;
                    $y = $pdf->get_height()-40; //815;
                    $size = 10;
                    $color = array(255,255,255);
                    $word_space = 0.0;  //  default
                    $char_space = 0.0;  //  default
                    $angle = 0.0;   //  default
                    $pdf->text($x, $y, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, $size, $color, $word_space, $char_space, $angle);
                ');
            }
        </script>
        </main>
    </body>
    </html>

