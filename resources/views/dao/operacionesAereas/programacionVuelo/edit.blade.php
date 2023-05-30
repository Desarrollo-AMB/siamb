@extends('layouts.user_type.auth')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger mx-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                @include('dao.operacionesAereas.programacionVuelo.header_programacionEdit')
            </div>
            <div class="card mb-4 mx-4">
                <div class="card-body px-2 pt-2 pb-2">
                    <!-- el otro formato -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <h6>BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                @role('aviacion_dao')
                                    <select name="base_estacion" class="form-control select2 base_estacion load_estacion"
                                        disabled="true">
                                        <option value="{{ $headerFam0001[0]->base_estacion }}">{{ $headerFam0001[0]->base_estacion }}</option>
                                    </select>
                                @endrole
                                @role('aviacion_grupo_aereo|administrador')
                                    <select name="base_estacion" class="form-control select2 base_estacion load_estacion" disabled>
                                        <option value="{{ $headerFam0001[0]->base_estacion }}">{{ $headerFam0001[0]->base_estacion }}</option>
                                    </select>
                                @endrole
                            </div>
                        </div>
                        <div class="col-2">
                            <h6>Selecionar</h6>
                            @role('aviacion_dao')
                                <select name="matriculaSelect" id="matriculaSelect" class="form-control select2 matriculaSelect"
                                    disabled>
                                    <option value="">Seleccionar...</option>
                                </select>
                            @endrole
                            @role('aviacion_grupo_aereo|administrador')
                                <select disabled name="matriculaSelect" id="matriculaSelect"
                                    class="form-control select2 matriculaSelect">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($matriculas as $data)
                                        <option value="{{ $data->matricula }}">{{ $data->matricula }}</option>
                                    @endforeach
                                </select>
                            @endrole
                        </div>
                        <div class="col-6" id="div_matricula_input">
                            <h6>MATRICULAS ALTERNAS</h6>
                            @role('aviacion_dao')
                                <input readonly type="text" name="matricula_alterna" id="matricula_alterna"
                                    class="form-control matricula_alterna" width="100%"
                                    value="{{ $headerFam0001[0]->matriculas_alternas }}">
                            @endrole
                            @role('aviacion_grupo_aereo|administrador')
                                <input readonly type="text" name="matricula_alterna" id="matricula_alterna"
                                    class="form-control matricula_alterna" width="100%"
                                    value="{{ $headerFam0001[0]->matriculas_alternas }}">
                            @endrole
                        </div>
                    </div>
                    <!-- fin de otro formato -->
                </div>
            </div>
            <div class="card mb-4 mx-4">
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="table_responsive">
                        <table id="responsiveA1" class="table table_responsive align-items-center mb-0">
                            <thead style="background: #e1e1e0;">
                                <tr>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>N°</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>ORDENADA POR</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>T. MISIÓN</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>CÓDIGO</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>DESDE</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>HASTA</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>SALIDA</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder">
                                        <h6>LLEGADA</h6>
                                    </th>
                                    <th class="text-uppercase font-weight-bolder text-center">
                                        <h6>ACCIÓN</h6>
                                    </th>
                                </tr>
                            </thead>
                            @role('aviacion_dao|administrador')
                                <tbody id="cargandotable">
                                    <tr>
                                        <td colspan="9" style="text-align: center; vertical-align: middle;"><h5><strong>Cargando...</strong></h5></td>
                                    </tr>
                                </tbody>
                                <tbody id="A1_data" hidden>
                                    @php
                                        $contador = 1; // Inicializamos el contador en 1
                                    @endphp
                                    @foreach ($A1_mision as $data)
                                        <tr id="delete_a1_mision{{ $data->id }}">
                                            <td>
                                                <span> v {{ $contador++ }}</span>
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                            </td>
                                            <td>
                                                <select disabled name="ordenada_por"
                                                    class="form-control select2 ordenada_por load_ordenado_por enviables">
                                                    <option value="{{ $data->ordenada_por }}">{{ $data->ordenada_por }}
                                                    </option>
                                                    @foreach ($vueloOrdenadaPor as $datosOrdenadaPor)
                                                        <option value="{{ $datosOrdenadaPor->codigo }}">
                                                            {{ $datosOrdenadaPor->codigo }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select disabled name="siglas" class="form-control select2 siglas load_siglas"
                                                    id="{{ $data->id }}">
                                                    @if ($data->siglas == 'ALERTA')
                                                        <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                        <option value="ENCENDIDO Y CHEQUEO EN TIERRA">ENCENDIDO Y CHEQUEO EN TIERRA</option>
                                                    @elseif($data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                        <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                        <option value="ALERTA">ALERTA</option>
                                                    @else
                                                        <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                        <option value="ALERTA">ALERTA</option>
                                                        <option value="ENCENDIDO Y CHEQUEO EN TIERRA">ENCENDIDO Y CHEQUEO EN TIERRA</option>
                                                    @endif
                                                    @foreach ($codigoTipoMisionSiglas as $datos)
                                                        <option value="{{ $datos->siglas }}">{{ $datos->siglas }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA' || $data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                    <select disabled name="codigo" disabled class="form-control select2 codigo load_codigo"
                                                        id="codigo{{ $data->id }}">
                                                        <option value="{{ $data->numero }}">{{ $data->numero }}</option>
                                                        @foreach ($codigoMision as $datoscodigo)
                                                            <option title="{{ $datoscodigo->nombre }}"
                                                                value="{{ $datoscodigo->codigo }}">
                                                                {{ $datoscodigo->codigo }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select disabled name="codigo" class="form-control select2 codigo load_codigo"
                                                        id="codigo{{ $data->id }}">
                                                        <option value="{{ $data->numero }}">{{ $data->numero }}</option>
                                                        @foreach ($codigoMision as $datoscodigo)
                                                            <option title="{{ $datoscodigo->nombre }}"
                                                                value="{{ $datoscodigo->codigo }}">
                                                                {{ $datoscodigo->codigo }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </td>
                                            <td>
                                                <select disabled name="ruta_desde"
                                                    class="form-control select2 ruta_desde load_ruta_desde"
                                                    id="ruta_desde{{ $data->id }}">
                                                    @if ($data->ruta_desde == 'EVENTUAL')
                                                        <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}
                                                        </option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @elseif($data->ruta_desde == 'LOCAL')
                                                        <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                    @else
                                                        <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @endif
                                                    @foreach ($aeropuertos as $dataruta_desde)
                                                        <option title="{{ $dataruta_desde->nombre }}"
                                                        value="{{ $dataruta_desde->codigo_icao }}">
                                                        {{ $dataruta_desde->codigo_icao }}</option>
                                                    @endforeach
                                                        <option value="">_______PARROQUIA__________</option>
                                                    @foreach ($parroquias as $dataParroquia)
                                                        <option value="{{ mb_strtoupper($dataParroquia->parroquia) }}">{{ mb_strtoupper($dataParroquia->parroquia) }}
                                                        </option>
                                                    @endforeach
                                                        <option value="">_______BASE__________</option>
                                                    @foreach ($bases as $dataBase)
                                                        <option value="{{ $dataBase->siglas }}">{{ $dataBase->descripcion }} -
                                                        {{ $dataBase->siglas }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select disabled name="ruta_hasta"
                                                    class="form-control select2 ruta_hasta load_ruta_hasta"
                                                    id="ruta_hasta{{ $data->id }}">
                                                    @if ($data->ruta_hasta == 'EVENTUAL')
                                                        <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @elseif($data->ruta_hasta == 'LOCAL')
                                                        <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                    @else
                                                        <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @endif
                                                    @foreach ($aeropuertos as $dataruta_hasta)
                                                        <option title="{{ $dataruta_hasta->nombre }}"
                                                        value="{{ $dataruta_hasta->codigo_icao }}">
                                                        {{ $dataruta_hasta->codigo_icao }}</option>
                                                    @endforeach
                                                        <option value="">_______PARROQUIA__________</option>
                                                    @foreach ($parroquias as $dataParroquia)
                                                        <option value="{{ mb_strtoupper($dataParroquia->parroquia) }}">{{ mb_strtoupper($dataParroquia->parroquia) }}
                                                        </option>
                                                    @endforeach
                                                        <option value="">_______BASE__________</option>
                                                    @foreach ($bases as $dataBase)
                                                        <option value="{{ $dataBase->siglas }}">{{ $dataBase->descripcion }} -
                                                        {{ $dataBase->siglas }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA' || $data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                    <input hidden name="encend" type="time"
                                                        class="form-control encend load_encend calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->encend }}"
                                                        id="encend{{ $data->id }}">
                                                @else
                                                    <input disabled name="encend" type="time"
                                                        class="form-control encend load_encend calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->encend }}"
                                                        id="encend{{ $data->id }}">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA' || $data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                    <input hidden name="apag" type="time"
                                                        class="form-control apag load_apag calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->apag }}"
                                                        id="apag{{ $data->id }}">
                                                @else
                                                    <input disabled name="apag" type="time"
                                                        class="form-control apag load_apag calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->apag }}"
                                                        id="apag{{ $data->id }}">
                                                @endif
                                            </td>
                                            <td style="padding-left: 20px;">

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endrole
                            @role('aviacion_grupo_aereo|administrador')
                                <tbody id="cargandotable">
                                    <tr>
                                        <td colspan="9" style="text-align: center; vertical-align: middle;"><h5><strong>Cargando...</strong></h5></td>
                                    </tr>
                                </tbody>
                                <tbody id="A1_data" hidden>
                                    @php
                                        $contador = 1; // Inicializamos el contador en 1
                                    @endphp
                                    @foreach ($A1_mision as $data)
                                        <tr id="delete_a1_mision{{ $data->id }}">
                                            <td>
                                                <span> v {{ $contador++ }}</span>
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                            </td>
                                            <td>
                                                <select name="ordenada_por"
                                                    class="form-control select2 ordenada_por load_ordenado_por enviables">
                                                    <option value="{{ $data->ordenada_por }}">{{ $data->ordenada_por }}
                                                    </option>
                                                    @foreach ($vueloOrdenadaPor as $datosOrdenadaPor)
                                                        <option value="{{ $datosOrdenadaPor->codigo }}">
                                                            {{ $datosOrdenadaPor->codigo }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA')
                                                    <select disabled name="siglas" class="form-control select2 siglas load_siglas"
                                                    id="{{ $data->id }}">
                                                        <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                    </select>
                                                @else
                                                    <select name="siglas" class="form-control select2 siglas load_siglas"
                                                        id="{{ $data->id }}">
                                                        @if($data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                            <option value="{{ $data->siglas }}">ENC.-CHECK EN TIERRA</option>
                                                        @else
                                                            <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                            <option value="ENCENDIDO Y CHEQUEO EN TIERRA">ENC.-CHECK EN TIERRA</option>
                                                        @endif
                                                        @foreach ($codigoTipoMisionSiglas as $datos)
                                                            <option value="{{ $datos->siglas }}">{{ $datos->siglas }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA' || $data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                    <select name="codigo" disabled class="form-control select2 codigo load_codigo"
                                                        id="codigo{{ $data->id }}">
                                                        <option value="{{ $data->numero }}">{{ $data->numero }}</option>
                                                        @foreach ($codigoMision as $datoscodigo)
                                                            <option title="{{ $datoscodigo->nombre }}"
                                                                value="{{ $datoscodigo->codigo }}">
                                                                {{ $datoscodigo->codigo }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select name="codigo" class="form-control select2 codigo load_codigo"
                                                        id="codigo{{ $data->id }}">
                                                        <option value="{{ $data->numero }}">{{ $data->numero }}</option>
                                                        @foreach ($codigoMision as $datoscodigo)
                                                            <option title="{{ $datoscodigo->nombre }}"
                                                                value="{{ $datoscodigo->codigo }}">
                                                                {{ $datoscodigo->codigo }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </td>
                                            <td>
                                                <select name="ruta_desde"
                                                    class="form-control select2 ruta_desde load_ruta_desde"
                                                    id="ruta_desde{{ $data->id }}">
                                                    @if ($data->ruta_desde == 'EVENTUAL')
                                                        <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}
                                                        </option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @elseif($data->ruta_desde == 'LOCAL')
                                                        <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                    @else
                                                        <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @endif
                                                    @foreach ($aeropuertos as $dataruta_desde)
                                                        <option title="{{ $dataruta_desde->nombre }}"
                                                        value="{{ $dataruta_desde->codigo_icao }}">
                                                        {{ $dataruta_desde->codigo_icao }}</option>
                                                    @endforeach
                                                        <option value="">_______PARROQUIA__________</option>
                                                    @foreach ($parroquias as $dataParroquia)
                                                        <option value="{{ mb_strtoupper($dataParroquia->parroquia) }}">{{ mb_strtoupper($dataParroquia->parroquia) }}
                                                        </option>
                                                    @endforeach
                                                        <option value="">_______BASE__________</option>
                                                    @foreach ($bases as $dataBase)
                                                        <option value="{{ $dataBase->siglas }}">{{ $dataBase->descripcion }} -
                                                        {{ $dataBase->siglas }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="ruta_hasta"
                                                    class="form-control select2 ruta_hasta load_ruta_hasta"
                                                    id="ruta_hasta{{ $data->id }}">
                                                    @if ($data->ruta_hasta == 'EVENTUAL')
                                                        <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @elseif($data->ruta_hasta == 'LOCAL')
                                                        <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                    @else
                                                        <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>
                                                        <option value="EVENTUAL">EVENTUAL</option>
                                                        <option value="LOCAL">LOCAL</option>
                                                    @endif
                                                    @foreach ($aeropuertos as $dataruta_hasta)
                                                        <option title="{{ $dataruta_hasta->nombre }}"
                                                        value="{{ $dataruta_hasta->codigo_icao }}">
                                                        {{ $dataruta_hasta->codigo_icao }}</option>
                                                    @endforeach
                                                        <option value="">_______PARROQUIA__________</option>
                                                    @foreach ($parroquias as $dataParroquia)
                                                        <option value="{{ mb_strtoupper($dataParroquia->parroquia) }}">{{ mb_strtoupper($dataParroquia->parroquia) }}
                                                        </option>
                                                    @endforeach
                                                        <option value="">_______BASE__________</option>
                                                    @foreach ($bases as $dataBase)
                                                        <option value="{{ $dataBase->siglas }}">{{ $dataBase->descripcion }} -
                                                        {{ $dataBase->siglas }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA' || $data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                    <input hidden name="encend" type="time"
                                                        class="form-control encend load_encend calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->encend }}"
                                                        id="encend{{ $data->id }}">
                                                @else
                                                    <input name="encend" type="time"
                                                        class="form-control encend load_encend calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->encend }}"
                                                        id="encend{{ $data->id }}">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA' || $data->siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA')
                                                    <input hidden name="apag" type="time"
                                                        class="form-control apag load_apag calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->apag }}"
                                                        id="apag{{ $data->id }}">
                                                @else
                                                    <input name="apag" type="time"
                                                        class="form-control apag load_apag calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->apag }}"
                                                        id="apag{{ $data->id }}">
                                                @endif
                                            </td>
                                            <td style="padding-left: 20px;">
                                                @if (count($A1_mision) > 1 && $data->siglas !== 'ALERTA')
                                                    <button value="{{ $data->id }}"
                                                        style="background: rgb(189, 0, 0);color: white;" type="button"
                                                        class="btn btn-danger delete_a1_mision" id="DeleteRow">X</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endrole
                        </table>
                        <div style="padding-top:5px" class="row">
                            @role('aviacion_grupo_aereo|administrador')
                                <div class="pull-right">
                                    @if ($esAlerta === 0)
                                        <button style="float: right; color:black;" class="btn btn-warning" id="aggAlerta">ESTABLECER ALERTA</button>
                                    @else
                                        @if (count($A1_mision) > 1)
                                            <button style="float: right; color:black;" class="btn btn-warning" id="deletAlerta">QUITAR ALERTA</button>
                                        @endif
                                    @endif
                                    <button style="float: right; background: green;color: white;" type="button"
                                        class="btn-sm btn-success agregar_mision add_edit_input"
                                        id="agregar_mision">Agregar Pierna</button>
                                    <button style="float: right; background: rgb(122, 151, 231);color: rgb(0, 0, 0);"
                                        type="button" class="btn btn-success edit_input actualizar_a1_mision"
                                        id="actualizar_a1_mision">ACTUALIZAR</button>
                                </div>
                            @endrole
                            @role('aviacion_dao|administrador')
                                <div style="text-align: center;">
                                    <button style="background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button"
                                        class="btn btn-success" id="revisado">REVISADO</button>
                                </div>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $(document).ready(function() {


            setTimeout(function() {
                // Mostrar el tbody de datos y ocultar el tbody de carga
                $('#A1_data').removeAttr('hidden');
                $('#cargandotable').attr('hidden', true);
                    $('#responsiveA1').DataTable({
                    processing: true,
                    //serverSide: true,
                    responsive: true,
                    pageLength: 25,
                    search: {
                        return: true,
                    },
                    "language": {
                        "sProcessing":    "Procesando...",
                        "sLengthMenu":    "Mostrar _MENU_ registros",
                        "sZeroRecords":   "No se encontraron resultados",
                        "sEmptyTable":    "Ningún dato disponible en esta tabla",
                        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":   "",
                        "sSearch":        "Buscar:",
                        "sUrl":           "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":    "Último",
                            "sNext":    "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
                });

            }, 2000);


            //$('#A1_data').removeAttr('hidden');
            //$('#A1_data').removeAttr('hidden');

            var id_fam0001;
            var fam0001_a1_mision_id;
            var ov_ota_om;
            var base_estacion;
            var siglasUnidad;
            base_estacion = $('.base_estacion').val();

            //PASO 1 Convierto en select2 los campos que lo necesitan
            $('.select2').select2();

            $('.base_estacion').change(function(e) {
                e.preventDefault();
                base_estacion = $('.base_estacion').val();
            });

            $('.siglas').on('change', function() {
                var siglaId = $(this).val();
                var id = $(this).attr('id');
                if (siglaId) {
                    if(siglaId == 'ALERTA'){
                        $('#codigo' + id).val('').trigger('change');
                        $("#codigo" + id).prop('disabled', true);
                        $("#ruta_desde" + id).val('EVENTUAL').trigger('change');
                        $("#ruta_hasta" + id).val('EVENTUAL').trigger('change');
                        $("#encend" + id).prop('hidden', true);
                        $("#apag" + id).prop('hidden', true);
                    }
                    else if(siglaId == 'ENCENDIDO Y CHEQUEO EN TIERRA'){
                        $('#codigo' + id).val('').trigger('change');
                        $("#codigo" + id).prop('disabled', true);
                        $("#ruta_desde" + id).val('LOCAL').trigger('change');
                        $("#ruta_hasta" + id).val('LOCAL').trigger('change');
                        $("#encend" + id).prop('hidden', true);
                        $("#apag" + id).prop('hidden', true);
                    }else{
                        $("#codigo" + id).prop('disabled', false);
                        $('#codigo' + id).val('').trigger('change');
                        $("#ruta_desde" + id).prop('disabled', false);
                        $("#ruta_hasta" + id).prop('disabled', false);
                        $('#ruta_desde' + id).val('EVENTUAL').trigger('change');
                        $('#ruta_hasta' + id).val('EVENTUAL').trigger('change');
                        $("#encend" + id).prop('hidden', false);
                        $("#apag" + id).prop('hidden', false);
                    }
                }
            });

            //LIMPIAR A1
            function cleanA1() {
                $('.ordenada_por').val('').trigger('change');
                $('.en_apoyo').val('').trigger('change');
                $('.codigo').val('').trigger('change');
            }

            //FORMULARIO GUARDAR
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var data_id = parseInt('{{ $fam0001 }}')
            //TRAER DATA DEL PRIMER PASO
            $.ajax({
                url: "{{ route('programacion_data') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data_id: data_id
                },
                cache: false,
                dataType: 'json',
                success: function(response) {

                    if (response.headerData.length > 0) {
                        var loopSteps = response.headerData.length
                        for (let i = 0; i < loopSteps; i++) {
                            let famSteps = response.headerData[i]
                            id_fam0001 = famSteps.id;
                            ov_ota_om = famSteps.ov_ota_om;
                            var dataHeader = 1;
                            //PASOS COMPLETADOS
                            if (dataHeader > 0) {
                                var unidad = response.unidad[0].unidad;
                                siglasUnidad = famSteps.unidad;
                                $("#ov_ota_om").text(famSteps.ov_ota_om);
                                $("#aeronave").text(famSteps.aeronaves.aeronave + " - MATRÍCULA: " +
                                    famSteps.matricula);
                                $("#unidad_componente").text(unidad + " - " + famSteps
                                    .componente_organismo);
                                //CARGAR DATOS DE PASOS

                                $("#fecha_cabecera").val(famSteps.fecha);
                                $("#serial").val(famSteps.serial);
                                $(".load_componente_organismo").val(famSteps.componente_organismo)
                                    .trigger('change')
                                $(".load_unidad").val(famSteps.unidad).trigger('change')

                            }
                        }
                    }
                }

            });

            $("#agregar_mision").click(function() {
                $(this).prop('disabled', true);
                $.ajax({
                    url: "{{ route('store_a1') }}",
                    method: 'POST',
                    data: {
                        pierna: 1,
                        ordenada_por: siglasUnidad,
                        codigo: "E-10",
                        ruta_desde: "EVENTUAL",
                        ruta_hasta: "EVENTUAL",
                        encend: "EVENTUAL",
                        apag: "EVENTUAL",

                        ov_ota_om: ov_ota_om,
                        fam0001_id: id_fam0001,
                        completado: "actualizado",
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Misión Agregada Correctamente!',
                                text: '¡EN ALAS VENCEREMOS!.',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            window.location.href =
                                "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });

            });

            $("#aggAlerta").click(function() {
                $(this).prop('disabled', true);
                $.ajax({
                    url: "{{ route('store_a1') }}",
                    method: 'POST',
                    data: {
                        pierna: 2,
                        ordenada_por: siglasUnidad,
                        codigo: "ALERTA",
                        ruta_desde: "EVENTUAL",
                        ruta_hasta: "EVENTUAL",
                        encend: "EVENTUAL",
                        apag: "EVENTUAL",

                        ov_ota_om: ov_ota_om,
                        fam0001_id: id_fam0001,
                        completado: "actualizado",
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Misión Agregada Correctamente!',
                                text: '¡EN ALAS VENCEREMOS!.',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            window.location.href =
                                "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });

            });

            //PASO #1 - revisar Programacion
            $("#revisado").click(function(e) {
                e.preventDefault();
                $(this).prop('disabled', true);
                $.ajax({
                    url: "{{ route('revisarProgramacion') }}",
                    method: 'POST',
                    data: {
                        id: id_fam0001
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response)

                            Swal.fire({
                                title: 'Programación Enviada con éxito!',
                                text: 'Se Creo Correctamente.',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });

                            window.location.href = "{{ URL::to('/dao/ver-programacion') }}";
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });

            });

            $("#actualizar_a1_mision").click(function(e) {
                e.preventDefault();
                $(this).prop('disabled', true);
                try {

                    // recorrer cada fila de la tabla
                    $('table tbody tr').each(function() {
                        // recorrer cada celda de la fila

                        var rowData = {};

                        // Obtener los valores de los inputs y selects de cada fila
                        var id = $(this).find("input[name='id']").val();
                        var ordenada_por = $(this).find("select[name='ordenada_por']").val();
                        var siglas = $(this).find("select[name='siglas']").val();
                        var numero = $(this).find("select[name='codigo']").val();

                        if (siglas == 'ALERTA') {
                            rowData.codigo = 'ALERTA';
                            var ruta_desde = $(this).find("select[name='ruta_desde']").val();
                            var ruta_hasta = $(this).find("select[name='ruta_hasta']").val();
                            var encend = "EVENTUAL";
                            var apag = "EVENTUAL";
                        } else if (siglas == 'ENCENDIDO Y CHEQUEO EN TIERRA') {
                            rowData.codigo = 'ENCENDIDO Y CHEQUEO EN TIERRA';
                            var ruta_desde = $(this).find("select[name='ruta_desde']").val();
                            var ruta_hasta = $(this).find("select[name='ruta_hasta']").val();
                            var encend = "EVENTUAL";
                            var apag = "EVENTUAL";
                        } else {
                            rowData.codigo = siglas + "-" + numero;
                            var ruta_desde = $(this).find("select[name='ruta_desde']").val();
                            var ruta_hasta = $(this).find("select[name='ruta_hasta']").val();
                            var encend = $(this).find("input[name='encend']").val();
                            var apag = $(this).find("input[name='apag']").val();

                            if (encend === "") {
                                encend = "EVENTUAL";
                            }
                            if (apag === "") {
                                apag = "EVENTUAL";
                            }
                        }

                        //rowData.id_fam0001 = id_fam0001;
                        rowData.id = id;
                        rowData.ordenada_por = ordenada_por;
                        rowData.ruta_desde = ruta_desde;
                        rowData.ruta_hasta = ruta_hasta;
                        rowData.encend = encend;
                        rowData.apag = apag;
                        rowData.completado = 'actualizado';

                        if (siglas !== 'ENCENDIDO Y CHEQUEO EN TIERRA' && siglas !== 'ALERTA') {
                            if (numero === "" || numero === null) {
                                throw new Error(
                                    "El codigo de la mision no puede estar vacio mientras la misión no sea de alerta."
                                    );
                            } else {

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    }
                                });
                                // // enviar los datos de la fila actual al servidor
                                $.ajax({
                                    url: "{{ route('actualizarProgramacionA1') }}",
                                    method: "POST",
                                    data: rowData,
                                    success: function(response) {
                                    },
                                    error: function(error) {
                                        console.log(error)
                                    }
                                });
                            }
                        } else {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            // // enviar los datos de la fila actual al servidor
                            $.ajax({
                                url: "{{ route('actualizarProgramacionA1') }}",
                                method: "POST",
                                data: rowData,
                                success: function(response) {
                                },
                                error: function(error) {
                                    console.log(error)
                                }
                            });
                        }

                        //FORMULARIO GUARDAR

                    });
                    Swal.fire({
                        title: 'Programación Actualizada con éxito!',
                        text: '¡EN ALAS VENCEREMOS!',
                        icon: 'success',
                        timer: 6000,
                        showConfirmButton: true,
                    });
                    window.location.href = "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                } catch (error) {
                    console.error(error);
                    $(this).prop('disabled', false);
                    Swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        timer: 6000,
                        showConfirmButton: true,
                    });
                }
            });

            $('.delete_a1_mision').on('click', function(event) {
                event.preventDefault();
                var id = $(this).val();

                Swal.fire({
                    title: 'Estas Seguro de Eliminar?',
                    text: "No podrás revertir esto.!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).prop('disabled', true);
                        $.ajax({
                            url: "{{ route('delete_a1_mision') }}",
                            method: 'POST',
                            data: {
                                id: id
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        title: 'Eliminado!',
                                        text: 'La Misión ha sido eliminado.',
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: true,
                                    });
                                    window.location.href = "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                                }
                            }
                        });
                    }
                });
            });

            $('#deletAlerta').on('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Estas Seguro de Eliminar la Alerta?',
                    text: "Atención.!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).prop('disabled', true);
                        $.ajax({
                            url: "{{ route('concluir_alerta') }}",
                            method: 'POST',
                            data: {
                                id: id_fam0001
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        title: 'Eliminado!',
                                        text: 'La Misión ha sido eliminado.',
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: true,
                                    });
                                    window.location.href = "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                                }
                            }
                        });
                    }
                });
            });

        });

    </script>
@endsection
