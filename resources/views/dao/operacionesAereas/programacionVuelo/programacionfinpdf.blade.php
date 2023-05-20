


@php
   use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Agenda </title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-3.3.7-dist/css/bootstrap.css') }}">
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px 50px 25px;
        }

        header {
            position: fixed;
            top: -125px;
            left: 0px;
            right: 0px;
            height: 25px;

            /** Extra personal styles**/
            background-color: #4e99e4;
            color: rgb(17, 17, 17);
            opacity: 10;
            margin-top: 50px;
            line-height: 20px;
            z-index: -44;
            /* Agrega esta línea */
        }
        footer {
            position: fixed;
            bottom: -50px;
            left: 0px;
            right: 0px;
            height: 30px;
            z-index: -44;
            margin-top: 1000px;

            /** Extra personal styles **/
            background-color: #4c86e4;
            color: white;
            line-height: 20px;
        }

        main {
            font-size: 1rem;
        }

        small {
            color: white !important;
        }

        body {
            font-family: Calibri, sans-serif;
        }
    </style>
    <style>
        table {
            border-collapse: collapse;
            margin-top: 30px;
            float: left;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
        }
    </style>

</head>

<body>
    <div class="row" style="margin-top:2px">
        <div class="col-xs-2">
            <img src="{{ public_path('template/assets/img/logo.png') }}" style="margin-left:55px;margin-top:-50px" width="70px" alt="logo">
        </div>
        <div class="col-xs-6" style="text-align: center; margin-top:-60px ;margin-left:55px;">
            <h5>REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>
                AVIACIÓN MILITAR BOLIVARIANA<br>
                DIRECCIÓN DE APRESTO OPERACIONAL
                <small> </small>
            </h5>
        </div>
        <div class="col-xs-3" style="margin-right:150px;">
            <img src="{{ public_path('template/assets/img/DAO.png') }}" style="margin-right:150px;margin-top:-50px" width="70px" alt="logo">
        </div>
        <br>

        <div style="text-align: right;">
            <span style="margin-right: 150px;" id="fecha_cabecerai" class="mb-0">{{ $fecha_inv }}</span>
        </div>
        <br>
        <div style="text-align: center; margin-top:25px ">
            @foreach ($programacion as $data)
        @php
          $fechaDesde = \Carbon\Carbon::parse($data->desde)->formatLocalized('%d%b%y');
        $fechaHasta = \Carbon\Carbon::parse($data->hasta)->formatLocalized('%d%b%y');
        $fechaDesde = strtoupper($fechaDesde);
        $fechaHasta = strtoupper($fechaHasta);
        break;
        @endphp
    @endforeach

            <h5>AGENDA DE OPERACIONES AEREAS DE LA DIRECCION DE APRESTO OPERACIONAL<br>
                CORRESPONDIENTE A LA SEMANA  <span id="fecha_cabecerai" class="mb-0">{{  $fechaDesde  }} - {{ $fechaHasta }}</span></h5> <br>

                <small> </small>
            </h5>

    </div>
        <table style="margin:0 auto;">

            <thead>

                <tr>
                    <th style="background-color: #3468AF; color: #080808; font-weight: bold; text-align: center; font-size: 10pt;">N°</th>
                    <th style="background-color: #3468AF; color: #080808; font-weight: bold; text-align: center; font-size: 10pt;">SISTEMA</th>
                    <th style="background-color: #3468AF; color: #080808; font-weight: bold; text-align: center; font-size: 10pt;">UNIDAD</th>
                    <th style="background-color: #3468AF; color: #080808; font-weight: bold; text-align: center; font-size: 10pt;">SITUACION</th>
                    <th style="background-color: #3468AF; color: #080808; font-weight: bold; text-align: center; font-size: 10pt;">OBSERVACION</th>
                </tr>

            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($programacion as $liste)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $liste->sistema }}</td>
                        <td>{{ $liste->unidad }}</td>
                        <td>{{ $liste->situacion }}</td>
                        <td>{{ $liste->observacion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </thead>


        </table>

        <div style="text-align: center; margin-top:300px ">
            <H6>__________________________________________</H6>
            <h5>SANTIAGO ALEJANDRO INFANGTE INTRIAGO<br>
                MAYOR GENERAL<br>
                COMANDANTE DE LA AVIAION MILITAR BOLIVARIANA<br>

                <small> </small>
            </h5>
        </div>

    <footer>
        <div style="display: flex; justify-content: space-between;">
            <h6 style="color:rgb(255, 255, 255)">Aviacion Militar Bolivariana</h6><br>
            <h6 style="color:rgb(255, 255, 255)">SIAMB</h6>
        </div>
    </footer>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fechaActual = new Date().toISOString().slice(0, 10);
        var fecha_inv = fechaActual.split('-').reverse().join('-');
        document.getElementById('fecha_cabecera').innerHTML = fecha_inv;
    });
</script>

</html>
