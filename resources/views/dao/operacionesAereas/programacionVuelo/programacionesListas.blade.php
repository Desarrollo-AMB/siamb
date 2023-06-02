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
                <div class="col-8">
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
                                <div class="col-xs-9 col-sm-9 col-md-9">
                                    <div class="form-group">
                                        <label for="desde">Elegir Fecha:</label>
                                        <input type="date" name="desde" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3">
                                    <br>
                                    <button type="submit" class="btn btn-success">Buscar</button>
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

        });
    </script>
@endsection
