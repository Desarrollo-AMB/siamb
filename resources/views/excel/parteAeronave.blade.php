<table>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 16pt">REPUBLICA BOLIVARIANA DE VENEZUELA</td>
    </tr>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 16pt">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</td>
    </tr>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 16pt">AVIACION MILITAR BOLIVARIANA</td>
    </tr>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 16pt">DIRECCIÓN DE APRESTO OPERACIONAL</td>
    </tr>

    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align:right; font-size: 14pt">{{$fechaFormateada}}</td>
    </tr>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td colspan="6" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>

    <tr>

        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UNIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SISTEMA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">DISPONIBLE</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">DISPONIBLE PARA EL COMBATE</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">INSDISPONIBLE</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SINIESTRADA</td>
    </tr>
    @foreach($num as $row)
        <tr>
            <td style="text-align: center;background-color: #3468AF; color: #000000; "> {{ $row->unidad }}</td>
            <td style="text-align: center;">{{ $row->sistema}}</td>
            <td style="text-align: center;">{{ $row->total1}}</td>
            <td style="text-align: center;">{{ $row-> total2}}</td>
            <td style="text-align: center;">{{ $row-> total3}}</td>
            <td style="text-align: center;"> {{ $row-> total4}}</td>
        </tr>
    @endforeach
</table>
<br>
<table>
    <tr>

        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UNIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SISTEMA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SERIAL</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">MATRICULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SITUACION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">OBSERVACION</td>
    </tr>
    @foreach($programacion as $row)
    <tr>
        <td style="text-align: center;background-color: #3468AF; color: #000000; "> {{ $row->unidad }}</td>
        <td style="text-align: center;">{{ $row->sistema}}</td>
        <td style="text-align: center;">{{ $row->serial}}</td>
        <td style="text-align: center;">{{ $row->matricula}}</td>
        <td style="text-align: center;">{{ $row->situacion}}</td>
        <td style="text-align: center;"> {{ $row->observacion}}</td>
    </tr>
@endforeach
</table>
