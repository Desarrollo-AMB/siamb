@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
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
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Nuevo Usuario</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('users.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-form-tab" data-toggle="pill" href="#custom-tabs-form" role="tab" aria-controls="custom-tabs-form" aria-selected="false">Creacion Usuario</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-empleados-tab" data-toggle="pill" href="#custom-tabs-empleados" role="tab" aria-controls="custom-tabs-empleados" aria-selected="false">Lista Empleados</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-form" role="tabpanel" aria-labelledby="custom-tabs-form-tab">
                                        {!! Form::open(array('route' => 'users.store','method'=>'POST', 'id'=>'crear_usuario')) !!}
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Nombre:</strong>
                                                    {!! Form::text('name', null, array('placeholder' => 'Nombre','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Usuario:</strong>
                                                    {!! Form::text('username', null, array('placeholder' => 'Usuario','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Email:</strong>
                                                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Password:</strong>
                                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Confirmar Password:</strong>
                                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirmar Password','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong>Roles:</strong>
                                                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                <input  type="hidden" id="codigo_empleado" name="codigo_empleado" value="">
                                                <button id="btn-submit" type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-empleados" role="tabpanel" aria-labelledby="custom-tabs-empleados-tab">
                                        <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap" data-order='[[2, "asc"]]'>
                                            <thead>
                                                <tr>
                                                    <th data-sortable="false">Asociar</th>
                                                    <th>Cedula</th>
                                                    <th>Nombre </th>
                                                    <th>Apellido</th>
                                                    <th>Tipo Empleado</th>
                                                    <th>Cargo</th>
                                                    <th>Ubicacion</th>
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
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function () {
        
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('personal.empleados.notuser') }}",
            columns: [
                {data: 'actions', name: 'action', orderable: false, searchable: false},
                {
                    data: 'cedula',
                },
                {data: 'nombre1'},
                {data: 'apellido1'},
                {data: 'nomina.tipo_empleado.descripcion'},
                {data: 'nomina.cargo.nombre_cargo'},
                {data: 'nomina.ubicacion.descripcion'},
            ]
        });
        new $.fn.dataTable.FixedHeader( table );
        $('#table').on('click', '.confirm-asociar', function (event) {
            event.preventDefault();
            var codigo_empleado= $(this).data('id');
            console.log(codigo_empleado);
            Swal.fire({
                title: 'Empleado Seleccinado!',
                text: "Esta seguro de asociarlo al usuario?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#codigo_empleado').val(codigo_empleado);
                    $('#custom-tabs-form').tab('show');
                }
            });
           
            return false;
            
        });
       
        $('#btn-submit').on('click', function (event) {
            event.preventDefault();
            if ($('#codigo_empleado').val().length != 0){
                $('#crear_usuario').submit();
            }else{
                Swal.fire({
                    title: 'No tiene Asociado el empleado!',
                    text: "Estas Seguro de Crear el Usuario?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#crear_usuario').submit();
                    }
                });
            }
            
        });
    });
</script>
@endsection