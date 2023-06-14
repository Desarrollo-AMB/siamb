<table>
,

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
    @foreach($aeronave as $row)
    <tr>
        <td style="text-align: center;background-color: #3468AF; color: #000000; "> {{ $row->unidad }}</td>
        <td style="text-align: center;">{{ $row->sistema}}</td>
        <td style="text-align: center;">{{ $row->matricula}}</td>
        <td style="text-align: center;">{{ $row->codigo}}</td>
        <td style="text-align: center;">{{ isset($horasDecimalesPorRegistro[$row->id]) ? $horasDecimalesPorRegistro[$row->id] : 0 }}</td>
        <td style="text-align: center;">{{ $row->en_apoyo_A2}}</td>
        <td style="text-align: center;">{{ $row->count }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: center;"> {{ $row->ruta_desde}} - {{$row->ruta_hasta}}</td>
        <td style="text-align: center;"> {{ $row->consumibles}} - {{$row->cantidad}}</td>
        <td></td>
        <td style="text-align: center;"> {{ $row->pesocargaTotal}} </td>
        <td style="text-align: center;"> {{ $row->pers}}</td>
    </tr>
@endforeach
</table>
