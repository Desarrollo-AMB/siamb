<table>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">N°</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CEDULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">GRADO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRES</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">APELLIDOS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UBICACIÓN</td>
    </tr>
    @php
        $id = 1;
    @endphp
    @foreach($datos as $row)
        <tr>
            <td>{{$id++}}</td>
            <td> {{ $row->cedula }}</td>
            <td>{{ $row->siglas }}</td>
            <td>{{ $row->nombre1 . ' '. $row->nombre2  }}</td>
            <td>{{ $row->apellido1.' '. $row->apellido2  }}</td>
            <td> {{ $row->codigo_ubicacion }} {{ $row->ubicacion }}</td>
        </tr>
    @endforeach
</table>
