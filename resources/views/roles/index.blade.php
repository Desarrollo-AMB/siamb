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
                    <table class="table align-items-center mb-0">
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nro.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre Rol</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td class="text-center">{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
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
                                    <i class="cursor-pointer fas fa-trash text-secondary" aria-hidden="true"></i>
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
                    </table>
                    {!! $roles->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function (){
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