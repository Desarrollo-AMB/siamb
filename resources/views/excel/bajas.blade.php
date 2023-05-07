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
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">ESPECIALIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CATEGORIA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UNIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA DE GRADUACIÓN</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CAUSA DE EGRESO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">FECHA DE EGRESO</td>
    </tr>
    @php
        $i = 1;
    @endphp
    
    @foreach($egresos as $row)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $row->siglas }}</td>
            <td>{{ $row->cedula }}</td>
            <td>{{ $row->nombre1.' '.$row->nombre2 }}</td>
            <td>{{ $row->apellido1.' '.$row->apellido2 }}</td>
            <td>{{ $row->genero }}</td>
            @if($especialidades == "" && $categorias == '')
                <td>{{ 'NO POSEE' }}</td>
                <td>{{ 'NO POSEE' }}</td>
            @elseif($especialidades != "" && $categorias == '')
                <td>{{ $especialidades->descripcion }}</td>
                <td>{{ 'NO POSEE' }}</td>
            @elseif($especialidades == "" && $categorias != '')
                <td>{{ 'NO POSEE' }}</td>
                <td>{{ $categorias->descripcion }}</td>
            @elseif($especialidades != "" && $categorias != '')
                <td>{{ $especialidades->descripcion }}</td>
                <td>{{ $categorias->descripcion }}</td>
            @endif
            <td>{{ $row->ubicacion }}</td>
            <td>{{ $row->fecha_graduacion }}</td>
            <td>{{ $row->tipo_de_baja }}</td>
            <td>{{ $row->fecha_egreso }}</td>
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
</table>
