<table>

    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 16pt">REPUBLICA BOLIVARIANA DE VENEZUELA</td>
    </tr>
    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 16pt">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</td>
    </tr>
    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 16pt">AVIACION MILITAR BOLIVARIANA</td>
    </tr>
    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 16pt">DIRECCIÓN DE APRESTO OPERACIONAL</td>
    </tr>

    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>

    </tr>
    <tr>
        <td colspan="17" style="font-weight: bold; text-align:right; font-size: 14pt">{{$fechaFormateada}}</td>
    </tr>
    <tr>
        <td colspan="17" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>


    <tr>

        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">UNIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SISTEMA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">MATRICULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">TIPO MISION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">HORAS DE VUELO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">APOYO DE INSTITUCION - ORGANISMO - COMUNIDADES</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CANTIDAD DE MISIONES  PROGRAMADAS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CANTIDAD DE MISIONES CUMPLIDAS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CANTIDAD DE MISIONES CANCELADAS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;"> MOTIVO POR EL CUAL SE CANCELO LA MISION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;"> TRIPULANTES</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;"> ATERRIZAJE</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;"> RUTAS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">COMBUSTIBLE JET-A1 EN LITROS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">COMBUSTIBLE AV-GAS EN LITROS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CARGA TOTAL TRANSPORTADA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;"> PASAJEROS TOTAL TRANSPORTADOS</td>
    </tr>
    @php
        $totalCantidad =0;
        $totalHoras =0;
        $totalCount =0;
        $totalCompletadas =0;
        $totalCanceladas =0;
        $totalTripulacion =0;
        $totalAterrizajes =0;
        $totalPesocargaTotal =0;
        $totalPers =0;
@endphp
    @foreach($aeronave as $row)
    @php
    $totalHoras += $row->horas;
     $totalCantidad += $row->cantidad;
     $totalCount += $row->count;
     $totalCompletadas += $row->completadas;
     $totalCanceladas += $row->canceladas;
     $totalTripulacion += $row->tripulacion;
     $totalAterrizajes += $row->aterrizajes;
     $totalPesocargaTotal += $row->pesocargaTotal;
     $totalPers += $row->pers;
     @endphp
    <tr>
        <td style="text-align: center;background-color: #3468AF; color: #000000; "> {{ $row->unidad }}</td>
        <td style="text-align: center;">{{ $row->sistema}}</td>
        <td style="text-align: center;">{{ $row->matricula}}</td>
        <td style="text-align: center;">{{ $row->codigos}}</td>
        <td style="text-align: center;">{{ $row->horas}}</td>
        <td style="text-align: center;">{{ $row->apoyo}}</td>
        <td style="text-align: center;">{{ $row->count }}</td>
        <td style="text-align: center;">{{$row->completadas}}</td>
        <td style="text-align: center;">{{$row->canceladas}}</td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;">{{$row->tripulacion}}</td>
        <td style="text-align: center;">{{$row->aterrizajes}}</td>
        <td style="text-align: center;"> {{ $row->desde}} - {{$row->hasta}}</td>
        <td style="text-align: center;"> {{ $row->cantidad}}</td>
        <td style="text-align: center;"> {{$row->avgas}}</td>
        <td style="text-align: center;"> {{ $row->pesocargaTotal}} </td>
        <td style="text-align: center;"> {{ $row->pers}}</td>
    </tr>

@endforeach

<tr>
    <td style="text-align: center;background-color: #34af71; color: #000000; "> TOTAL</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "></td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "></td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "></td>
    <td style="text-align: center;background-color: #34af71; color: #000000; ">{{$totalHoras}}</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "></td>
    <td style="text-align: center;background-color: #34af71; color: #000000; ">{{$totalCount}}</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; ">{{$totalCompletadas}}</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; ">{{$totalCanceladas}}</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "></td>
    <td style="text-align: center;background-color: #34af71; color: #000000; ">{{$totalTripulacion}}</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; ">{{$totalAterrizajes}}</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "></td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "> {{ $totalCantidad}}</td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "> </td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "> {{ $totalPesocargaTotal}} </td>
    <td style="text-align: center;background-color: #34af71; color: #000000; "> {{ $totalPers}}</td>

</tr>
</table>
