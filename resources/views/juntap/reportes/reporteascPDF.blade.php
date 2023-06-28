<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-3.3.7-dist/css/bootstrap.css') }}">
    <style>
        /* Define the margins of your page */
        @page {
            margin: 100px 25px 50px 25px;
        }

        header {
            position: fixed;
            top: -125px;
            left: 0px;
            right: 0px;
            height: 25px;

            /* Extra personal styles*/
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

            /* Extra personal styles */
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

       
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        #tabla-empleados tbody td {
        font-size: 10px; /* Tamaño de fuente deseado */
    }
    </style>
</head>

<body>
    <div class="row">
        <div class="row" style="margin-top:5px">
            <div class="col-xs-2">
                <img src="{{ public_path('template/assets/img/logo.png') }}"style="margin-left:5px;margin-top:-50px"
                    width="70px" alt="logo">
            </div>
            <div class="col-xs-6" style="text-align: center; margin-top:-50px">
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
        <div class="row">
            <h1>REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO</h1>
            <table id="tabla-empleados">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Grado militar</th>
                        <th>Grado a ascender</th>
        
                        <th>Demerito</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $empleado->codigo_empleado }}</td>
                            <td>{{ $empleado->cedula }}</td>
                            <td>{{ $empleado->nombre1 }}</td>
                            <td>{{ $empleado->apellido1 }}</td>
                            <td>{{ $empleado->grado_militar }}</td>
                            <td>{{ $empleado->grado_ascender }}</td>
                          
                            <td>{{ $empleado->demerito }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           
        </div>
        
    </div>
</body>

</html>
