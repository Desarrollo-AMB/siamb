<table>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">TIPO EMPLEADO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CEDULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRES Y APELLIDOS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA INGRESO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA JUBILACION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">OBSERVACION</td>

    </tr>
    @foreach($jubilados as $row)
    @php
    $fecha_ingreso = date("d/m/Y", strtotime($row->fecha_ingreso));
    $fecha_jubilacion = date("d/m/Y", strtotime($row->fecha_jubilacion));
    @endphp
    <tr>
        <td>{{ $row->tipo_empleado->descripcion }}</td>
        <td> {{ $row->cedula }}</td>
        <td>{{ $row->nombre1 . ' '. $row->nombre2.', '.$row->apellido1.' '. $row->apellido2  }}</td>
        <td>{{ $fecha_ingreso }}</td>
        <td>{{ $fecha_jubilacion }}</td>
        <td>{{ $row->observaciones }}</td>
    </tr>
    @endforeach
</table>
