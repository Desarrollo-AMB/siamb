@extends('layouts.user_type.auth')
@section('title', 'form')
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
                        <h5 class="mb-0">Listado de Pilotos con Vuelos Finalizados</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            @role('aviacion_dao|aviacion_grupo_aereo|administrador|cmd_general')
                <a class="btn btn-light btn-sm" href="{{ route('dao.ingresar.horasTripulante') }}">Registrar Horas de Vuelo Acumuladas hasta el mes de Julio 2023</a>
            @endrole
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="table" class="table table-sm table-hover w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>Cedula</th>
                                            <th>Grado</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Acciones</th>
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
            ajax: "{{ route('api.forms.listado_pilotos.data') }}",
            columns: [
                {data: 'cedula', name:'empleados.cedula'},
                {data: 'grado', name:'grados_militares.siglas'},
                {data: 'nombre1', name:'empleados.nombre1'},
                {data: 'apellido1', name:'empleados.apellido1'},
                {data: 'actions', name: 'action', orderable: false, searchable: false},
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