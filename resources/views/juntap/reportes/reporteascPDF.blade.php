<!DOCTYPE html>
<html>
<head>
    <title>REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO</title>
    <style>
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
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>REPORTE DE PERSONAL MILITAR TENTATIVO ASCENSO</h1>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Grado militar</th>
                <th>Grado a ascender</th>
                <th>punto</th>
                <th>demerito</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td>{{ $empleado->codigo_empleado }}</td>
                <td>{{ $empleado->cedula }}</td>
                <td>{{ $empleado->nombre1 }}</td>
                <td>{{ $empleado->apellido1 }}</td>
                <td>{{ $empleado->grado_militar }}</td>
                <td>{{ $empleado->grado_ascender }}</td>
                <td>{{ $empleado->punto }}</td>
                <td>{{ $empleado->demerito }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>