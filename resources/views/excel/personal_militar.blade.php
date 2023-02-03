<table>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">GRADO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CEDULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRES</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">APELLIDOS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SEXO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CATEGORIA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SITUACIÓN</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA DE GRADUACIÓN</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UBICACIÓN</td>
    </tr>
    @foreach($datos as $row)
        @php
            $fecha_graduacion = date("d/m/Y", strtotime($row->fecha_graduacion));
        @endphp
        <tr>
            <td>{{ $row->siglas . ' - ' . $row->grado_militar }}</td>
            <td> {{ $row->cedula }}</td>
            <td>{{ $row->nombre . ' '. $row->nombre2  }}</td>
            <td>{{ $row->apellido1.' '. $row->apellido2  }}</td>
            <td>{{ $row->genero }}</td>
            <td>{{ $row->categoria_militar }}</td>
            <td>{{ $row->situacion }}</td>
            <td>{{ $fecha_graduacion }}</td>
            <td>{{ $row->ubicacion }}</td>
        </tr>
    @endforeach
</table>
