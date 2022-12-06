<table>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">TIPO EMPLEADO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CEDULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRES Y APELLIDOS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOTA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">OBSERVACION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA EVALUACION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRE EVALUADOR</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CEDULA EVALUADOR</td>

    </tr>
    @foreach($evaluaciones as $row)
    @php
    $fecha_evaluacion = date("d/m/Y", strtotime($row->fecha_evaluacion));
    @endphp
    <tr>
        <td>{{ $row->tipo_emp }}</td>
        <td>{{ $row->cedula }}</td>
        <td>{{ $row->nombre1." ".$row->nombre2." ".$row->apellido1." ".$row->apellido2 }}</td>
        <td>{{ $row->nota }}</td>
        <td>{{ $row->observaciones }}</td>
        <td>{{ $fecha_evaluacion }}</td>
        <td>{{ $row->nombre_evaluador }}</td>
        <td>{{ $row->cedula_evaluador }}</td>
    </tr>
    @endforeach
</table>
