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
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="card-body px-2 pt-2 pb-2">
        @role('aviacion_dao|aviacion_grupo_aereo|cmd_general')
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0 mb-2">
                            <div class="d-flex flex-row justify-content-between">
                                <div clas="col-xs-3 col-sm-3 col-md-3">
                                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('dao.ver_programacion') }}">Volver</a>
                                </div>
                                <div clas="col-xs-4 col-sm-4 col-md-4">
                                    <h5 class="mb-0">Programaciones Realizadas</h5>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark my-0">
                        <div class="card-body px-2 pt-2 pb-2">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="card-body">
                                        <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-sm-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="reporte"
                                                                    id="flexRadioDefault1" checked="checked" value="1">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Reporte de Programaciones Anteriores
                                                                </label>
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-8 col-sm-6">
                                                            <div id="Parametros1" class="parametros ">
                                                                @role('aviacion_dao')
                                                                    <form id="formDevolucion1"
                                                                        action="{{ route('dao.programacionVuelo.pfecha') }}"
                                                                        method="POST" class="row" target="_blank">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <div class="col-md-8">
                                                                            <div class="row">
                                                                                <h6 class="col-sm-3 col-form-label">Fecha:</h6>
                                                                                <div class="col-sm-9">
                                                                                    <input id="fecha" type="date"
                                                                                        class="form-control @error('fecha') is-invalid @enderror"
                                                                                        name="fecha" value="">
                                                                                    <br>
                                                                            </div>
                                                                            <div class="row">
                                                                                <h6 class="col-sm-3 col-form-label">Fecha:</h6>
                                                                                <div class="col-sm-9">
                                                                                    <select name="tipo" id="tipo" class="form-control select2">
                                                                                        <option value="ce">Caza y Entrenamiento</option>
                                                                                        <option value="th">Transporte y Ala Rotatoria</option>
                                                                                    </select>
                                                                                    <br>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <button
                                                                                class="btn btn-primary btn-sm mb-1">Ejecutar</button>
                                                                        </div>

                                                                    </form>
                                                                @endrole
                                                                @role('aviacion_grupo_aereo')
                                                                    <form id="formDevolucion1"
                                                                        action="{{ route('dao.programacionVuelo.pfechaG') }}"
                                                                        method="POST" class="row" target="_blank">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <div class="col-md-8">
                                                                            <div class="row">
                                                                                <h6 class="col-sm-3 col-form-label">Fecha:</h6>
                                                                                <div class="col-sm-9">
                                                                                    <input hidden name="unidad" type="text" value="{{ $unidad }}">
                                                                                    <input id="fecha" type="date"
                                                                                        class="form-control @error('fecha') is-invalid @enderror"
                                                                                        name="fecha" value="">
                                                                                    <br>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <button
                                                                                class="btn btn-primary btn-sm mb-1">Ejecutar</button>
                                                                        </div>

                                                                    </form>
                                                                @endrole
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-sm-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="reporte"
                                                                    id="flexRadioDefault2" value="3">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    Otro
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div id="Parametros3" class="parametros" style="display: none;">
                                                                <form action="" method="POST" class="row">
                                                                    @csrf
                                                                    <div class="col-md-8">
                                                                        <div class="row">
                                                                            <h6 class="col-sm-3 col-form-label">Filtro:</h6>
                                                                            <div class="col-sm-9">
                                                                                <select name="parametros[filtroBajas]"
                                                                                    id="filtro_bajas" class="select2 form-control"
                                                                                    disabled="disabled">
                                                                                    <option value="">SELECCIONE...</option>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
        @endrole

        @role('aviacion_dao|aviacion_ceo|cmd_general')
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-body px-2 pt-2 pb-2">
                            <h5 class="mb-0 text-center">Programación de Vuelo Vigente: Grupos de Caza y Entrenamiento del día "{{ $fecha_vigente_invertida }}"<br>
                            </h5>
                            <div class="card-body text-center p-2">
                                <a href="{{ route('dao.imprimirProgramacionV', ['tipo' => 'ce']) }}">
                                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                        <i class="fas fa-download" aria-hidden="true"></i>
                                    </div>
                                    <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                        <small class="font-weight-bolder mb-1">
                                            Descargar Programación
                                            <span class="text-success text-sm font-weight-bolder"></span>
                                        </small>
                                    </p>
                                </a>
                            </div>
                            <hr class="horizontal dark my-0">
                            <br>
                            <table id="vuelosCE" class="table table-sm table-bordered table-hover table-striped dt-responsive w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal" style="text-align:center;">GRUPO</th>
                                        <th class="font-weight-normal" style="text-align:center;">SISTEMA / MATRÍCULA</th>
                                        <th class="font-weight-normal" style="text-align:center;">MATRÍCULAS ALTERNAS</th>
                                        <th class="font-weight-normal" style="text-align:center;">ORDENADA POR</th>
                                        <th class="font-weight-normal" style="text-align:center;">MISIÓN / RUTA</th>
                                        <th class="font-weight-normal" style="text-align:center;">SALIDA</th>
                                        <th class="font-weight-normal" style="text-align:center;">RETORNO</th>
                                        <th class="font-weight-normal" style="text-align:center;">MILITAR</th>
                                        <th class="font-weight-normal" style="text-align:center;">CIVIL</th>
                                        <th class="font-weight-normal" style="text-align:center;">CARGA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programacionCE as $data)
                                        <tr>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->unidad }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->sistema_matricula }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->matriculas_alternas }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->ordenada_por }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->mision_ruta }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->salida }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->retorno }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->militar }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->civil }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->carga }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-body px-2 pt-2 pb-2">
                            <h5 class="mb-0 text-center">
                                Programación de Vuelo Vigente: Grupos de Transporte y Ala Rotatoria del día "{{ $fecha_vigente_invertida }}"<br>
                            </h5>
                            <div class="card-body text-center p-2">
                                <a href="{{ route('dao.imprimirProgramacionV', ['tipo' => 'th']) }}">
                                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                        <i class="fas fa-download" aria-hidden="true"></i>
                                    </div>
                                    <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                        <small class="font-weight-bolder mb-1">
                                            Descargar Programación
                                            <span class="text-success text-sm font-weight-bolder"></span>
                                        </small>
                                    </p>
                                </a>
                            </div>
                            <hr class="horizontal dark my-0">
                            <br>
                            <table id="vuelosTA" class="table table-sm table-bordered table-hover table-striped dt-responsive w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal" style="text-align:center;">GRUPO</th>
                                        <th class="font-weight-normal" style="text-align:center;">SISTEMA / MATRÍCULA</th>
                                        <th class="font-weight-normal" style="text-align:center;">MATRÍCULAS ALTERNAS</th>
                                        <th class="font-weight-normal" style="text-align:center;">ORDENADA POR</th>
                                        <th class="font-weight-normal" style="text-align:center;">MISIÓN / RUTA</th>
                                        <th class="font-weight-normal" style="text-align:center;">SALIDA</th>
                                        <th class="font-weight-normal" style="text-align:center;">RETORNO</th>
                                        <th class="font-weight-normal" style="text-align:center;">MILITAR</th>
                                        <th class="font-weight-normal" style="text-align:center;">CIVIL</th>
                                        <th class="font-weight-normal" style="text-align:center;">CARGA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programacionTA as $data)
                                        <tr>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->unidad }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->sistema_matricula }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->matriculas_alternas }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->ordenada_por }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->mision_ruta }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->salida }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->retorno }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->militar }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->civil }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->carga }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        @role('aviacion_grupo_aereo')
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-body px-2 pt-2 pb-2">
                            <h5 class="mb-0 text-center">Programación de Vuelo Vigente del día "{{ $fecha_vigente_invertida }}"</h5>
                            <div class="card-body text-center p-2">
                                <a href="{{ route('dao.imprimirProgramacionVG', ['unidad' => $unidad]) }}">
                                    <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                        <i class="fas fa-download" aria-hidden="true"></i>
                                    </div>
                                    <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                        <small class="font-weight-bolder mb-1">
                                            Descargar Programación {{ $unidad }}
                                            <span class="text-success text-sm font-weight-bolder"></span>
                                        </small>
                                    </p>
                                </a>
                            </div>
                            <hr class="horizontal dark my-0">
                            <br>
                            <table id="vuelosCE" class="table table-sm table-bordered table-hover table-striped dt-responsive w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th class="font-weight-normal" style="text-align:center;">GRUPO</th>
                                        <th class="font-weight-normal" style="text-align:center;">SISTEMA / MATRÍCULA</th>
                                        <th class="font-weight-normal" style="text-align:center;">MATRÍCULAS ALTERNAS</th>
                                        <th class="font-weight-normal" style="text-align:center;">ORDENADA POR</th>
                                        <th class="font-weight-normal" style="text-align:center;">MISIÓN / RUTA</th>
                                        <th class="font-weight-normal" style="text-align:center;">SALIDA</th>
                                        <th class="font-weight-normal" style="text-align:center;">RETORNO</th>
                                        <th class="font-weight-normal" style="text-align:center;">MILITAR</th>
                                        <th class="font-weight-normal" style="text-align:center;">CIVIL</th>
                                        <th class="font-weight-normal" style="text-align:center;">CARGA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programacion as $data)
                                        <tr>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->unidad }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->sistema_matricula }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->matriculas_alternas }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->ordenada_por }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->mision_ruta }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->salida }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->retorno }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->militar }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->civil }}</td>
                                            <td class="font-weight-normal" style="text-align:center;">{{ $data->carga }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            if (!$('#vuelosCE').hasClass('dataTable')) {
                $('#vuelosCE').DataTable({
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
            }
            if (!$('#vuelosTA').hasClass('dataTable')) {
                $('#vuelosTA').DataTable({
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
            }

            $('.select2').select2();
            $("input[name$='reporte']").click(function() {
                var test = $(this).val();

                $("div.parametros").hide();
                $("div.parametros *").attr("disabled", true);
                //$("div.parametros").prop('disabled', 'disabled');
                $("#Parametros" + test).show();
                $("#Parametros" + test + ' *').prop("disabled", false);
            });
            $("#formDevolucion5").validate({
                rules: {
                    cedula: {
                        required: true,
                        minlength: 8
                    },
                },
                messages: {
                    cedula: "El parametro es obligatorio.",

                }
            });

        });
    </script>
@endsection
