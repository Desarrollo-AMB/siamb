@extends('layouts.user_type.auth')
@section('title', 'UbicacionesDetalladas')
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
    <div class="col-12 ">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Ubicaciones Detalladas</h5>
                    </div>
                    <a class="btn btn-default btn-sm mb-0" href="{{ route('auxiliares.ubicacionesDetalladas.create') }}">+&nbsp;Crear Ubicacion Detallada</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap" data-order='[[2, "asc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre de la Ubicacions </th>
                                            <th>Ubicacion Macro</th>
                                            <th>Situacion</th>
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
            ajax: "{{ route('auxiliares.ubicacionesDetalladas.data') }}",

            columns: [
                {data: 'codigo_ubicacion',},
                {data: 'descripcion',},
                {data: 'codigo_ubic_nomina',name: 'ubicaciones.descripcion'},
                {data: 'situacion'},
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

        $('#table').on('click', '.confirm-delete' ,function (e) {
            e.preventDefault();
            var url =$(this).data('target') ;
            Swal.fire({
                title: 'Eliminar ubicacion',
                text: "Esta seguro???",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if(result.isConfirmed){
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: '_DELETE'},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }).done(function (data) {
                        $('#table').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'La Ubicacion a sido Eliminada con Exito.',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                    });
                }
            });
        });
    });
</script>
@endsection
