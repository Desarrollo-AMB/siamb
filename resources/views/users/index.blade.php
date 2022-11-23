@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
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
                        <h5 class="mb-0">Administración de Usuarios</h5>
                    </div>
                    <a class="btn btn-bg-gradient-primary btn-sm mb-0" href="{{ route('users.create') }}">+&nbsp;Crear Usuario</a>
                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table id="table" class="table align-items-center mb-0" data-order='[[0, "asc"]]'>
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Roles</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="false">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @if ($user->empleado) 
                                    {{ $user->empleado->nombre1 }} {{ $user->empleado->apellido1}}
                                    @elseif ($user->notempleado) 
                                    {{ $user->notempleado->nombre1 }} {{ $user->notempleado->apellido1}}
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->roles as $v)
                                            <label class="badge bg-secondary">{{ $v->guard_name =='web'? 'siamb' : $v->guard_name }}-{{ $v->name }} </label>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.show',$user->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Mostrar usuario">
                                        <i class="fas fa-user text-secondary" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('users.edit',$user->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar usuario">
                                        <i class="fas fa-user-edit text-secondary" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" class="confirmar-delete" form-target="delete-form-{{  $user->id }}"
                                        title="Eliminar" onclick="event.preventDefault();" >
                                        <i class="cursor-pointer fas fa-trash text-danger" aria-hidden="true"></i>
                                    </a>
                                    <form id="delete-form-{{  $user->id }}" action="{{ route('users.destroy',  $user->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{--!! $data->render() !!--}}
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
            pageLength: 25,
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
        
        $('#table').on('click', '.confirmar-delete', function (event) {
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
                        text: 'El Usuario ha sido eliminado.',
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