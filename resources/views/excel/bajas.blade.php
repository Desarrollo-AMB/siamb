<table>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">#</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">GRADO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CEDULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRES</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">APELLIDOS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SEXO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UNIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRES HIJO(A)</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">APELLIDOS HIJO(A)</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA DE NACIMIENTO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">EDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SEXO HIJO(A)</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA DE REGISTRO</td>
    </tr>
    @php
        $i = 1;
    @endphp
    @foreach($familiares as $row)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $row->siglas }}</td>
            <td>{{ $row->cedula }}</td>
            <td>{{ $row->nombre1.' '.$row->nombre2 }}</td>
            <td>{{ $row->apellido1.' '.$row->apellido2 }}</td>
            <td>{{ $row->genero }}</td>
            <td>{{ $row->ubicacion }}</td>
            <td>{{ $row->nombref1.' '.$row->nombref2 }}</td>
            <td>{{ $row->apellidof1.' '.$row->apellidof2 }}</td>
            <td>{{ $row->fecha_nacimiento }}</td>
            <td>{{ $row->edad }}</td>
            <td>{{ $row->sexof }}</td>
            <td>{{ $row->fecha_registro }}</td>
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
</table>
