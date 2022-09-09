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
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nro.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Roles</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $user)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.show',$user->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Mostrar usuario">
                                        <i class="fas fa-user text-secondary" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ route('users.edit',$user->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar usuario">
                                        <i class="fas fa-user-edit text-secondary" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" class="confirm-delete" form-target="delete-form-{{  $user->id }}"
                                        title="Eliminar" onclick="event.preventDefault();" >
                                        <i class="cursor-pointer fas fa-trash text-secondary" aria-hidden="true"></i>
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
                    {!! $data->render() !!}
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