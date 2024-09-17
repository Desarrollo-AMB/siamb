<table>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 16pt">REPUBLICA BOLIVARIANA DE
            VENEZUELA</td>
    </tr>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 16pt">MINISTERIO DEL PODER POPULAR PARA
            LA DEFENSA</td>
    </tr>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 16pt">AVIACION MILITAR BOLIVARIANA</td>
    </tr>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 14pt">Fecha:
            <?php echo date("d/m/Y");?>
        </td>
    </tr>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 19pt">{{ $titulo }}</td>
    </tr>
    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 16pt"></td>
    </tr>

    <tr>
        <td colspan="15" style="font-weight: bold; text-align: center; font-size: 14pt"></td>
    </tr>

    <tr>

        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            N° REPORTE</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            JRES</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            FECHA DE REPORTE</td>
            <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
                GRUPO FECHA HORA
            </td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            PERSONA QUE ENVIA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            UNIDAD INVOLUCRADA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            COMANDANTE DE UNIDAD</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            CLASE DE EVENTO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            TIPO DE EVENTO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            EVENTO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            DESCRIPCION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            DOCUMENTO</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            LUGAR DE OCURRENCIA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            FECHA DE OCURRENCIA</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            SITUACION</td>
        <td style="background-color: #3468AF; color: #FFFFFF; font-weight: bold; text-align: center; font-size: 15pt;">
            IMAGEN
        </td>

    </tr>
    @foreach($datos as $row)
    <tr>
        <td> {{ $row->n_reporte }}</td>
        <td>{{ $row->jres }}</td>
        <td>{{ $row->fecha_reporte }}</td>
        <td>{{ $row->grupo_fecha }}</td>
        <td> {{ $row->persona_envia }}</td>
        <td> {{ $row->unidad_involucrada }}</td>
        <td>{{ $row->cmdt_unidad }}</td>
        <td>{{ $row->clase_envento }}</td>
        <td>{{ $row->tipo_evento }}</td>
        <td>{{ $row->evento }}</td>
        <td>{{ $row->descripcion }}</td>
        <td>{{ $row->documento }}</td>
        <td>{{ $row->lugar_ocurrencia }}</td>
        <td>{{ $row->fecha_ocurrencia }}</td>
        <td>{{ $row->situacion }}</td>
        <td>{{ $row->image }}</td>
    </tr>
    @endforeach
</table>