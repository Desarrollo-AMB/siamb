
<table>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">#</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SISTEMA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UNIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SITUACION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">OBSERVACIÓN</td>
    </tr>
    @php
        $i = 1;
    @endphp
    @foreach($programacion as $row)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $row->sistema }}</td>
            <td>{{ $row->unidad}}</td>
            <td>{{ $row->situacion }}</td>
            <td>{{ $row->observacion }}</td>
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
</table>
