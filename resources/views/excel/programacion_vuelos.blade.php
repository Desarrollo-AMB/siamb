@php
    $hoy = now();
    $dia = date_format($hoy,'d');
    $mes = date_format($hoy,'m');
    $año = date_format($hoy,'Y');

    switch ($mes) {
        case '01':
        $mes = 'ENERO';
        break;

        case '02':
        $mes = 'FEBRERO';
        break;

        case '03':
        $mes = 'MARZO';
        break;

        case '04':
        $mes = 'ABRIL';
        break;

        case '05':
        $mes = 'MAYO';
        break;

        case '06':
        $mes = 'JUNIO';
        break;

        case '07':
        $mes = 'JULIO';
        break;

        case '08':
        $mes = 'AGOSTO';
        break;

        case '09':
        $mes = 'SEPTIEMBRE';
        break;

        case '10':
        $mes = 'OCTUBRE';
        break;

        case '11':
        $mes = 'NOVIEMBRE';
        break;

        case '12':
        $mes = 'DICIEMBRE';
        break;

        default:
        $mes = 'NO EXISTE EL MES';
        break;
    }
@endphp
<table>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">REPÚBLICA BOLIVARIANA DE VENEZUELA</td>
    </tr>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</td>
    </tr>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">COMANDO ESTRATEGICO OPERACIONAL DE LA F.A.N.B</td>
    </tr>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">AVIACION MILITAR BOLIVARIANA</td>
    </tr>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: right; font-size: 19pt">ORDEN DE VUELO DEL DÍA {{ $dia.' DE '.$mes.' DEL '.$año }}</td>
    </tr>
    <tr>
        <td colspan="9" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" rowspan="2">GRUPO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" rowspan="2">SISTEMA/MATRICULA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" rowspan="2">MATRICULAS ALTERNAS</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" rowspan="2">A LA ORDEN DE</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" rowspan="2">MISIÓN/RUTA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" colspan="2">HORA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" colspan="2">PAX</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;" rowspan="2">CARGA LIBRA "LB"</td>
    </tr>
    <tr>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">SALIDA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">RETORNO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">MILITAR</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">CIVIL</td>
    </tr>
    {{-- @foreach($datos as $row)
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
    @endforeach--}}
</table>
