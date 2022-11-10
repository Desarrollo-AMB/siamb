@extends('layouts.user_type.auth')
@section('title', 'Personal')
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
                        <h5 class="mb-0">Ingreso de Personal</h5>
                    </div>
                    <a class="btn btn-bg-gradient-primary btn-sm mb-0" href="{{ route('sireh.ingreso-personal.new') }}">+&nbsp;nuevo Ingreso</a>
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
                                            <th>Cedula</th>
                                            <th>Nombre </th>
                                            <th>Apellido</th>
                                            <th>Tipo Empleado</th>
                                            <th>Ubicacion</th>
                                            <th>Cargo</th>
                                            <th>Grado Militar</th>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function () {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('api.sireh.empleados.inactivos') }}",
            columns: [
                {data: 'cedula',},
                {data: 'nombre1'},
                {data: 'apellido1'},
                {data: 'tipo_empleado', name: 'tipos_empleados.descripcion', searchable: false},
                {data: 'ubicacion', name: 'ubicaciones.descripcion', searchable: false},
                {data: 'cargo', name: 'cargos.nombre_cargo'},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
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
                title: 'Estas Seguro de Eliminar?',
                text: "No podrás revertir esto.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => { 
                if(result.isConfirmed){
                    $.ajax(
                        { 
                            url: url, 
                            type: 'DELETE', 
                            dataType: 'json', 
                            data: {method: '_DELETE'}, 
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} 
                        }
                    ).always(function (data) { 
                        $('#table').DataTable().ajax.reload(); 
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'El Registro de Ingreso ha sido eliminado.',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                    }); 
                }
            });
        });

        $('#table').on('click', '.activar-ingreso' ,function (e) { 
            e.preventDefault(); 
            var url =$(this).data('target') ;
            Swal.fire({
                title: 'Estas Seguro de Activar?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => { 
                if(result.isConfirmed){
                    $.ajax(
                        { 
                            url: url, 
                            type: 'POST', 
                            dataType: 'json', 
                            data: {method: '_POST'}, 
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} 
                        }
                    ).always(function (data) {
                        //console.log(data);
                        $('#table').DataTable().ajax.reload(); 
                        Swal.fire({
                            title: 'Activado!',
                            text: 'El Registro de Ingreso ha sido activado.',
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