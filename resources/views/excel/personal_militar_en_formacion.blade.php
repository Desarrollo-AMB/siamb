<table>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 16pt">REPUBLICA BOLIVARIANA DE VENEZUELA</td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 16pt">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 16pt">AVIACION MILITAR BOLIVARIANA</td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 14pt">Fecha: <?php echo date("d/m/Y");?></td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    @if ($codigo_ubicacion!=='0')
    <tr>
        <td colspan="5" style="font-weight: bold; text-align: center; font-size: 14pt">UBICACION: {{ $codigo_ubicacion }} - {{ $ubicacion_descripcion}}</td>
    </tr>
    @endif
    <tr>
        
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CEDULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">GRADO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">NOMBRES</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">APELLIDOS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UBICACIÓN</td>
    </tr>
    @foreach($datos as $row)
        <tr>
            <td> {{ $row->cedula }}</td>
            <td>{{ $row->siglas . ' - ' . $row->grado_militar }}</td>
            <td>{{ $row->nombre . ' '. $row->nombre2  }}</td>
            <td>{{ $row->apellido1.' '. $row->apellido2  }}</td>
            <td> {{ $row->codigo_ubicacion }} {{ $row->ubicacion }}</td>
        </tr>
    @endforeach
</table>
