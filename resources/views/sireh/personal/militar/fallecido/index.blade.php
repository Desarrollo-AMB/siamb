@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
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
                        <h5 class="mb-0">Personal Militar Egresado</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.personal-militar.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            {{--@include('sireh.personal.militar.suspendidos._barra_auxiliar')
            <hr class="horizontal dark my-0">--}}
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap" data-order='[[2, "asc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Cedula</th>
                                            <th>Nombre </th>
                                            <th>Apellido</th>
                                            <th>Grado Militar</th>
                                            <th>Ubicacion</th>
                                            <th>Motivo</th>
                                            <th>Fecha de Egreso</th>
                                            <th>Numero de Resuelto</th>
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
            ajax: "{{ route('api.sireh.personal.militar.fallecido') }}",
            columns: [
                {data: 'cedula',},
                {data: 'nombre1'},
                {data: 'apellido1'},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: 'ubicacion', name: 'ubicaciones.descripcion', searchable: false},
                {data: 'motivo', name: 'tipo_de_baja.codigo_egreso', searchable: false},
                {data: 'fecha_salida', name: 'egresos.fecha_salida', searchable: false},
                {data: 'nro_resuelto', name: 'egresos.nro_resuelto', searchable: false},
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