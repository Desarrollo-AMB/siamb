


@php
    use Carbon\Carbon;

@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Parte por Unidad </title>
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

        #table2 {
            float: left;
            margin-left: 20px;
            margin-top: 65px;
        }


        th,
        td {
            border: 1px solid black;
            padding: 10px;
        }
    </style>
    <style>
        table.title {
            border: none;
            margin-left: 5px;
            margin-top: 50px;
        }

        table.title th,
        table.title td {
            border: none;
            padding: 1px;
            font-size: 12px;
        }

        .tabla-contenedor {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .tabla-fecha {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            margin-right: 5px;
        }

        .tabla-partes,
        .tabla-der,
        .tabla-lista {
            flex: 1;
        }

        table.centers {
            border: 1px solid #ccc;
            margin-left: 50px;
            margin-top: 65px
        }

        table.centers th,
        table.centers td {
            border: 1px solid #ccc;
            padding: 2px;
            font-size: 11px;
            font-family: Arial;
        }

        table.partes {
            border-collapse: collapse;
            border: 0px solid #ccc;
        }

        table.partes th,
        table.partes td {
            border: 1px solid #ccc;
            padding: 2px;
            font-size: 11px;
            font-family: Calibri;
        }


        table.lista {
margin: 0 auto;
            border: 1px solid #ccc;

        }

        table.lista th,
        table.lista td {
            border: 1px solid #ccc;
            padding: 2px;
            font-size: 11px;
            font-family: Arial;
        }

        table.der {
            border: 0px solid #ccc;
            margin-left: 450px;
            margin-top: 60px;
        }

        table.der th,
        table.der td {
            border: 1px solid #ccc;
            padding: 2px;
            font-size: 11px;
            font-family: Arial;
        }

        th {
            font-size: 9.8px;

            font-family: Arial;
        }
        div.p{
            margin-right: 5px
        }
    </style>
</head>

<body>
    <div class="row" style="margin-top:5px">
        <div class="col-xs-2">
            <img src="{{ public_path('template/assets/img/logo.png') }}"style="margin-left:5px;margin-top:-50px" width="70px" alt="logo">
        </div>
        <div class="col-xs-6" style="text-align: center; margin-top:-50px" >
            <h5>REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<br>
                AVIACIÓN MILITAR BOLIVARIANA<br>
                DIRECCIÓN DE PERSONAL
                <small> </small>
            </h5>
        </div>
        <div class="col-xs-3">

        </div>
    </div>



    <main>

        <div class="tabla-contenedor">
            <table class="title">
                <tr>
                    <th>Ubicacion:</th>
                    <td>{{ $datas->ubicacion }}</td>
                </tr>
            </table>
            <div style="text-align: right;">
                <label for="" style="margin-right: 5px; text-align: right;">Fecha:</label>
                <input type="text"  value="{{ $datas->fecha }}" style="text-align: right;border: none;">
            </div>

            <table class=" partes"style="float:left;margin-top:65px">
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
                        <td>{{ $datas->total1 }}</td>
                    </tr>
                    <tr>
                        <th>faltan</th>
                        <td>{{ $ausentes_count }}</td>
                    </tr>
                    <tr>
                        <th>Servicio en la Unidad</th>
                        <td>{{ $datas->total2 }}</td>
                    </tr>
                    <tr>
                        <th>Servicio feura de la unidad</th>
                        <td>{{ $datas->total3 }}</td>
                    </tr>
                    <tr>
                        <th>Retardado</th>
                        <td>{{ $datas->total4 }}</td>
                    </tr>
                    <tr>
                        <th>Permiso</th>
                        <td>{{ $datas->total5 }}</td>
                    </tr>
                    <tr>
                        <th>Comisión País</th>
                        <td>{{ $datas->total6 }}</td>
                    </tr>
                    <tr>
                        <th>Comisíon Exterior</th>
                        <td>{{ $datas->total7 }}</td>
                    </tr>
                    <tr>
                        <th>Curso País</th>
                        <td>{{ $datas->total8 }}</td>
                    </tr>
                    <tr>
                        <th>Curso Exterior</th>
                        <td>{{ $datas->total9 }}</td>
                    </tr>
                    <tr>
                        <th>Ausente sin Causa Justificada</th>
                        <td>{{ $datas->total10 }}</td>
                    </tr>
                    <tr>
                        <th>Destacado fuera de la Unidad</th>
                        <td>{{ $datas->total11 }}</td>
                    </tr>
                    <tr>
                        <th>Consulta</th>
                        <td>{{ $datas->total12 }}</td>
                    </tr>
                    <tr>
                        <th>Reposo</th>
                        <td>{{ $datas->total13 }}</td>
                    </tr>
                    <tr>
                        <th>Hospiatalizado</th>
                        <td>{{ $datas->total14 }}</td>
                    </tr>
                    <tr>
                        <th>Desertor</th>
                        <td>{{ $datas->total15 }}</td>
                    </tr>
                    <tr>
                        <th>Privado de Libertad</th>
                        <td>{{ $datas->total16 }}</td>
                    </tr>
                    <tr>
                        <th>Otro</th>
                        <td>{{ $datas->total17 }}</td>
                    </tr>

                </tbody>



            </table>

            <table border="1"class="centers">
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

            <table id="table2" class="der">
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
                        <td>{{ $datas->coGJ }}</td>
                        <td>{{ $datas->ctrpGJ }}</td>
                        <td>{{ $datas->tecGJ }}</td>
                        <td>{{ $datas->asGJ }}</td>
                        <td>{{ $datas->AStecGJ }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalGJ }}</td>
                    </tr>
                    <tr>
                        <th>M/J</th>

                        <td>{{ $datas->coMJ }}</td>
                        <td>{{ $datas->ctrpMJ }}</td>
                        <td>{{ $datas->tecMJ }}</td>
                        <td>{{ $datas->asMJ }}</td>
                        <td>{{ $datas->AStecMJ }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalMJ }}</td>
                    </tr>
                    <tr>
                        <th>G/D</th>
                        <<td>{{ $datas->coGD }}</td>
                            <td>{{ $datas->ctrpGD }}</td>
                            <td>{{ $datas->tecGD }}</td>
                            <td>{{ $datas->asGD }}</td>
                            <td>{{ $datas->AStecGD }}</td>
                            <td>0</td>
                            <td>{{ $datas->totalGD }}</td>
                    </tr>
                    <tr>
                        <th>G/B</th>
                        <td>{{ $datas->coGB }}</td>
                        <td>{{ $datas->ctrpGB }}</td>
                        <td>{{ $datas->tecGB }}</td>
                        <td>{{ $datas->asGB }}</td>
                        <td>{{ $datas->AStecGB }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalGB }}</td>
                    </tr>
                    <tr>
                        <th>CNEL </th>
                        <td>{{ $datas->coCNEL }}</td>
                        <td>{{ $datas->ctrpCNEL }}</td>
                        <td>{{ $datas->tecCNEL }}</td>
                        <td>{{ $datas->asCNEL }}</td>
                        <td>{{ $datas->AStecCNEL }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalCNEL }}</td>
                    </tr>
                    <tr>
                        <th>TCNEL</th>
                        <td>{{ $datas->coTCNEL }}</td>
                        <td>{{ $datas->ctrpTCNEL }}</td>
                        <td>{{ $datas->tecTCNEL }}</td>
                        <td>{{ $datas->asTCNEL }}</td>
                        <td>{{ $datas->AStecTCNEL }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalTCNEL }}</td>
                    </tr>
                    <tr>
                        <th>MAY</th>
                        <td>{{ $datas->coMY }}</td>
                        <td>{{ $datas->ctrpMY }}</td>
                        <td>{{ $datas->tecMY }}</td>
                        <td>{{ $datas->asMY }}</td>
                        <td>{{ $datas->AStecMY }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalMY }}</td>
                    </tr>
                    <tr>
                        <th>CAP</th>
                        <td>{{ $datas->coCAP }}</td>
                        <td>{{ $datas->ctrpCAP }}</td>
                        <td>{{ $datas->tecCAP }}</td>
                        <td>{{ $datas->asCAP }}</td>
                        <td>{{ $datas->AStecCAP }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalCAP }}</td>
                    </tr>
                    <tr>
                        <th>PTTE</th>
                        <td>{{ $datas->coPTTE }}</td>
                        <td>{{ $datas->ctrpPTTE }}</td>
                        <td>{{ $datas->tecPTTE }}</td>
                        <td>{{ $datas->asPTTE }}</td>
                        <td>{{ $datas->AStecPTTE }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalPTTE }}</td>
                    </tr>
                    <tr>
                        <th>TTE</th>
                        <td>{{ $datas->coTTE }}</td>
                        <td>{{ $datas->ctrpTTE }}</td>
                        <td>{{ $datas->tecTTE }}</td>
                        <td>{{ $datas->asTTE }}</td>
                        <td>{{ $datas->AStecTTE }}</td>
                        <td>0</td>
                        <td>{{ $datas->totalTTE }}</td>
                    </tr>
                    <tr>
                        <th>S/S</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $datas->SS }}</td>
                        <td>{{ $datas->SS }}</td>
                    </tr>
                    <tr>
                        <th>S/A</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $datas->SA }}</td>
                        <td>{{ $datas->SA }}</td>
                    </tr>
                    <tr>
                        <th>SM/1ERA</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $datas->SM1 }}</td>
                        <td>{{ $datas->SM1 }}</td>
                    </tr>
                    <tr>
                        <th>SM/2DA</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $datas->SM2 }}</td>
                        <td>{{ $datas->SM2 }}</td>
                    </tr>
                    <tr>
                        <th>SM/3RA</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $datas->SM3 }}</td>
                        <td>{{ $datas->SM3 }}</td>
                    </tr>
                    <tr>
                        <th>S/1ERO</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $datas->S1 }}</td>
                        <td>{{ $datas->S1 }}</td>
                    </tr>
                    <tr>
                        <th>S/2DO</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>{{ $datas->S2 }}</td>
                        <td>{{ $datas->S2 }}</td>
                    </tr>
                    <tr>
                        <th>TOTAL</th>
                        <td>{{ $datas->TOTALcod }}</td>
                        <td>{{ $datas->TOTALcmdtrp }}</td>
                        <td>{{ $datas->TOTALtec }}</td>
                        <td>{{ $datas->TOTALas }}</td>
                        <td>{{ $datas->TOTALastec }}</td>
                        <td>{{ $datas->TOTALtrp }}</td>
                        <td>{{ $datas->TOTAL }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
        </div>
    </main>
    <footer>
        <div style="display: flex; justify-content: space-between;">
            <h6 style="color:rgb(255, 255, 255)">Aviacion Militar Bolivariana</h6><br>
            <h6 style="color:rgb(255, 255, 255)">SIAMB</h6>
        </div>
    </footer>
</body>

<body>
    <div>
        <table class="lista">
            <tbody>
                <tr>
                    <th>N°</th>
                    <th>Grado</th>
                    <th>Nombre1</th>
                    <th>Apellido</th>
                    <th>Cedula </th>
                    <th>Categoria</th>
                    <th>Situacion</th>
                    <th>Observaciones</th>
                </tr>
            </tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($list as $liste)
                <thead>
                    <td>{{ $i++ }}</td>
                    <td>{{ $liste->grado }}</td>
                    <td>{{ $liste->nombres }}</td>
                    <td>{{ $liste->apellido }}</td>
                    <td>{{ $liste->cedula }}</td>
                    <td>{{ $liste->categoria }}</td>
                    <td>{{ $liste->situacion }}</td>
                    <td></td>
                </thead>
            @endforeach
        </table>

    </div>
</body>

</html>
