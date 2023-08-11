@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Reporte de Devolucion 5%</title>
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
            table.borderless td, table.borderless th {
                border: 0;
            }
            small {
                color: white !important;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="row">
                <div class="col-xs-8" style="padding: 1px 1px 1px 30px;">

                </div>
                <div class="col-xs-4 " style="padding: 3px 0px 0px 0px; text-align: center;">
                    <small> Fecha: <?php echo date("d/m/Y H:m a");?> </small>
                </div>
            </div>
            <br>
            <div class="row" style="margin-top:-40px">
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
        </header>
        <footer class="page">
        </footer>

        <main>

            <table id="table" class="table table-sm table-hover w-100" style="margin:0 40px; padding: 1px 10px 1px 10px; border-collapse:collapse; width:600px" >
                <tbody>
                    <tr>
                        <th >
                            <span>Grado:</span>
                        </th>
                        <td >
                            <span>{{$data->siglas}}-{{$data->grado_militar}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th >
                            <span>Nombres y Apellidos:</span>
                        </th>
                        <td >
                            <span>{{$data->nombre1}} {{$data->nombre2}}, {{$data->apellido1}} {{$data->apellido}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th >
                            <span>Cedula:</span>
                        </th>
                        <td >
                            <span>{{$data->cedula}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th >
                            <span>Concepto:</span>
                        </th>
                        <td >
                            <span>{{$concepto_nomina->descripcion}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table id="table" class="table table-sm table-hover w-100 borderless table-borderless" style="margin: 5px 50px 10px 50px; width:600px">
                <thead>
                    <tr>
                        <th class="text-center">FECHA DE PAGO</th>
                        <th class="text-center">MONTO</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $monto = 0;
                        $fecha_retro = null;
                    @endphp
                    @foreach($conceptos_pagados as $row)
                    <tr>
                        @php
                            if ($row->fecha_pago<'2021-11-01'){
                                $monto = $row->monto/1000000;
                            } else {
                                $monto = $row->monto;
                            }
                            if ($row->codigo_concepto == '105') {
                                $monto = $monto;
                                $monto_retro = $monto;
                                $fecha_retro = $row->fecha_pago;
                            }
                            /* OBTENEMOS LOS VALORES QUE SEAN DEL TIPO DE PAGO 20 */
                            else {
                                if (empty($fecha_retro)) {
                                    /* SI FECHA_RETRO ES VACIA SOLO SE OBTIENE EL VALOR DEL MONTO */
                                    $monto = $monto;
                                    $total = $total + $monto;
                                }
                                /* SI SE DUPLICA LA FECHA Y ES UN RETRO ACTIVO O UN AUMENTO SE SUMAN LOS MONTOS */
                                elseif ($fecha_retro == $row->fecha_pago) {
                                    $monto = $monto + $monto_retro;
                                    $total = $total + $monto;
                                }
                                /* SI NO SE DUPLICA LA FECHA */
                                elseif ($fecha_retro != $row->fecha_pago) {
                                    $monto = $monto;
                                    $total = $total + $monto;
                                }
                            }
                        @endphp
                        @if($row->codigo_concepto !== '105')
                            <td class="text-center" style="border:1px solid #e7f0f0; padding: 2px;"> {{ date('d/m/Y', strtotime($row->fecha_pago))  }}</td>
                            <td class="text-center" style="border:1px solid #e7f0f0; padding: 2px;"> {{number_format($monto,2,',','.')}}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center" style="border:1px solid #e7f0f0; padding: 2px;"><b>TOTAL:<b></th>
                        <td class="text-center" style="border:1px solid #e7f0f0; padding: 2px;">{{number_format($total,2,',','.')}}</td>
                    </tr>
                </tfoot>
            </table>
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
