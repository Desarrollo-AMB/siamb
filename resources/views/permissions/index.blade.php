@extends('layouts.user_type.auth')

@section('title', 'Permisos')

@section('content_header', 'Permisos')

@push('plugins-css')

@endpush

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
                        <h5 class="mb-0">Administracion de Permisos</h5>
                    </div>
                    @if ($privateRoutesWithoutPermission->count())
                        <button type="button" class="btn btn-secondary btn-sm mb-0" data-toggle="modal" 
                            data-target="#modal-private-routes-without-permission">
                            Mostrar Rutas Privadas sin Permisos ({{ $privateRoutesWithoutPermission->count() }})
                        </button>
                    @endif
                    @if ($unnecessaryPermissions->count())
                        <a href="#" class="btn btn-danger btn-sm mb-0"
                            onclick="event.preventDefault();
                            document.getElementById('clean-permissions-form').submit();"
                            >Eliminar Permisos Innecesarios ({{ $unnecessaryPermissions->count() }})</a>
                        <form id="clean-permissions-form" action="{{ route('permissions.clean') }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                    <a href="{{ route('permissions.create') }}" class="btn btn-bg-gradient-primary btn-sm mb-0">+&nbsp;Crear</a>
                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                <table id="table" class="table table-sm table-bordered table-hover w-100" data-order='[[2, "asc"], [0, "asc"]]'>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nombre de la Ruta</th>
                            <th>Grupo</th>
                            <th>Necesario</th>
                            <th data-sortable="false">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal with private routes without permission --}}
<div class="modal fade" id="modal-private-routes-without-permission">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Rutas Privadas sin Permiso</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    @foreach ($privateRoutesWithoutPermission as $route)
                        <div class="col-4">
                            <p>{{ $route->getName() }}</p>
                        </div>
                    @endforeach
                </div>
			</div>
			<div class="modal-footer justify-content-rigth">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
{{-- /.modal --}}

@endsection

@section('scripts')
<script>
    $(function () {
        
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('permissions.index') }}",
            columns: [
                {
                    data: 'name',
                    render: (data, type, row) => `<a href='`+row.show_link+`'>`+data+`</a>`
                },
                {data: 'route_name'},
                {data: 'group'},
                {data: 'is_private_route'},
                {data: 'actions', name: 'action', orderable: false, searchable: false},
            ]
        });
        $('#table').on('click', '.confirm-delete', function (event) {
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
                        text: 'El Permiso ha sido eliminado.',
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

@push('plugins-js')
<script>
        
</script>
@endpush