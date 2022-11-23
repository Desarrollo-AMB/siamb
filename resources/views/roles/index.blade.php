@extends('layouts.user_type.auth')

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
                        <h5 class="mb-0">Administración de Roles</h5>
                    </div>
                    <a class="btn btn-primary btn-sm mb-0" href="{{ route('roles.create') }}">+&nbsp;Crear Rol</a>
                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table id="table" class="table align-items-center mb-0" data-order='[[2, "asc"]]'>
                        <thead>
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" >Id.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre Rol</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Modulo/Sistema</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="false">Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td class="text-center">{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->guard_name =='web' ? 'SIAMB': Str::upper($role->guard_name) }}</td>
                            <td class="text-center">
                                <a href="{{ route('roles.show',$role->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Mostrar Rol">
                                    <i class="fas fa-address-book text-secondary" aria-hidden="true"></i>
                                </a>
                                @can('Editar Roles')
                                <a href="{{ route('roles.edit',$role->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar Rol">
                                    <i class="fas fa-edit text-secondary" aria-hidden="true"></i>
                                </a>
                                @endcan
                                @can('Eliminar Roles')
                                <a href="#" class="confirm-delete" form-target="delete-form-{{  $role->id }}"
                                    title="Eliminar" onclick="event.preventDefault();" >
                                    <i class="cursor-pointer fas fa-trash text-danger" aria-hidden="true"></i>
                                </a>
                                <form id="delete-form-{{  $role->id }}" action="{{ route('roles.destroy',  $role->id) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{-- !! $roles->render() !!--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function (){
        var table = $('#table').DataTable({
            responsive: true,
            pageLength: 15,
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
        $('.confirm-delete').on('click', function (event) {
            event.preventDefault();
            var idForm= $(this).attr('form-target');
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
                    $('#'+idForm).submit();
                    Swal.fire({
                        title: 'Eliminado!',
                        text: 'El Rol ha sido eliminado.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: true,
                    });   
                }
            });
        });
    });
</script>
@endsection