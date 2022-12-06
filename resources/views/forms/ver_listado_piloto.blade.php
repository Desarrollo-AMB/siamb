@extends('layouts.user_type.auth')
@section('title', 'form')
@section('content')

    @if ($message = Session::get('success'))
    <div class="alert alert-success mx-4" role="alert">
        <span class="text-white">{{ $message }}</span>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Listado Individual del Piloto {{$datos->nombre1." ".$datos->apellido1}}</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('forms.listado_pilotos') }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger mx-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- DATOS PERSONALES -->
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Personales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                <h6>Cédula:</h6>
                                                <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" disabled 
                                                    value="{{ $datos->cedula }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Grado:</h6>
                                                @if ($datos->nomina->grado_militar != "")
                                                    @foreach ($grados_militares as $row)
                                                        @if ($row->codigo_grado == $datos->nomina->grado_militar)
                                                            {!! Form::text('grado', $row->descripcion, array('class' => 'form-control','disabled')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('grado', '', array('placeholder' => 'No Posee Grado','class' => 'form-control','disabled')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Nombre y Apellidos:</h6>
                                                <input id="nombres" type="text" class="form-control" name="nombres" disabled 
                                                    value="{{ $datos->nombre1." ".$datos->nombre2." ".$datos->apellido1." ".$datos->apellido2 }}"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Ubicación:</h6>
                                                @if ($datos->nomina->codigo_ubicacion != "")
                                                    @foreach ($ubicaciones as $row)
                                                        @if ($row->codigo_ubicacion == $datos->nomina->codigo_ubicacion)
                                                            {!! Form::text('ubicacion', $row->descripcion, array('class' => 'form-control','disabled')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('ubicacion', '', array('placeholder' => 'No Posee Ubicación','class' => 'form-control','disabled')) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('forms.reporte_vuelos', $datos->id) }}">
                        <button class="btn btn-danger">
                            <i class="fas fa-file-pdf fa-2x"></i>
                            Imprimir Reporte
                        </button>
                    </a>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                                <div class="card-body">
                                    <table id="table" class="table table-sm table-hover w-100 nowrap">
                                        <thead>
                                            <tr>
                                                <th>OV/OTA/OM</th>
                                                <th>Fecha</th>
                                                <th>Unidad</th>
                                                <th>Modelo Aeronave</th>
                                                <th>Serial</th>
                                                <th>Matricula</th>
                                                <th>Base</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('api.forms.ver_listado_piloto.data', $datos->cedula) }}",
            columns: [
                {data: 'cedula',},
                {data: 'fecha',},
                {data: 'unidad',},
                {data: 'aeronave',},
                {data: 'serial',},
                {data: 'matricula',},
                {data: 'base',},
                
            ],
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
    });
</script>
@endsection