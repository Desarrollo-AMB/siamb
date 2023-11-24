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
                        <h5 class="mb-0">DRES</h5>
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
                                    <a class="nav-link active" id="custom-tabs-form-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-form" role="tab" aria-controls="custom-tabs-form"
                                        aria-selected="false">Reporte RES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="custom-tabs-empleados-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-empleados" role="tab" aria-controls="custom-tabs-empleados"
                                        aria-selected="false">Personal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="custom-tabs-empleados2-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-empleados2" role="tab" aria-controls="custom-tabs-empleados2"
                                        aria-selected="false">Armamento</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="custom-tabs-empleados3-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-empleados3" role="tab" aria-controls="custom-tabs-empleados3"
                                        aria-selected="false">Equipos</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-form" role="tabpanel" aria-labelledby="custom-tabs-form-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">
                                               
                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                    {!! Form::open(array('route' => 'dres.armamento','method'=>'POST', 'id'=>'reporte')) !!}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>N° Reporte:</strong> 
                                                                {!! Form::text('n_reporte', null, array('placeholder' => 'N° Reporte','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>JRES:</strong>
                                                                <select name="JRES" id=""  aria-placeholder='JRES' class="form-control"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Fecha de Reporte:</strong>
                                                                {!! Form::date('fechaR', null, array('placeholder' => 'Fecha de Reporte','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Grupo fecho hora:</strong>
                                                                {!! Form::text('grupo_fecho_hora', null, array('placeholder' => 'Grupo fecho hora','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Persona que Envia:</strong>
                                                                {!! Form::password('p_envia', array('placeholder' => 'Persona que Envia','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Unida Involucrada:</strong>
                                                                <select name="unidad" class="form-control"  placeholder="Unida Involucrada">
                                                                   @foreach ($ubicaciones as $ubicacion)
                                                                       <option value="{{ $ubicacion['descripcion'] }}">{{ $ubicacion['descripcion'] }}</option>
                                                                   @endforeach 
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Cmdt Unidad:</strong>
                                                                {!! Form::text('cmdtU', null,array('placeholder' => 'Comandante de Unidad','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Clase de Evento:</strong>
                                                               <select name="clase" class="form-control" id="" placeholder="Clase de Evento"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Tipo de Evento:</strong>
                                                               <select name="tipo" class="form-control" id="" placeholder="Tipo de Evento"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong> Evento:</strong>
                                                               <textarea name="event" id="" class="form-control" cols="30" rows="10" placeholder="Eventos"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong> Descripcion:</strong>
                                                               <textarea name="descripcion" id="" class="form-control" cols="30" rows="10" placeholder="Descripción"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong> Lugar de Ocurrencia:</strong>
                                                               <textarea name="lugarO" id="" class="form-control" cols="30" rows="10" placeholder="Lugar de Ocurrencia"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Fecha de Ocurrencia:</strong>
                                                                {!! Form::date('fechaO', null, array('placeholder' => 'Fecha de Ocurrencia','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Situacion:</strong>
                                                                {!! Form::text('situacion', null, array('placeholder' => 'Situacion','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Documentos Afectados:</strong>
                                                                {!! Form::text('documentos', null, array('placeholder' => 'Documentos Afectados','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="custom-tabs-empleados" role="tabpanel" aria-labelledby="custom-tabs-empleados-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">
                                                <div class="card-header pb-0 mb-2">
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div>
                                                            <h5 class="mb-0">Personal </h5>
                                                        </div>
                                                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('users.index') }}">Volver</a>
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                   {{-- {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', ]]) !!}--}}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>N° Reporte:</strong> 
                                                                {!! Form::text('N_reporte', null, array('placeholder' => 'N° Reporte','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Especialidad:</strong>
                                                                <select name="especialidad" id="" class="form-control" placeholder="Especialidad"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Sexo:</strong>
                                                                <select name="sexo" id="" class="form-control" placelholder="Sexo"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Grado:</strong>
                                                               <select name="grado" id="" class="form-control"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Nombres:</strong>
                                                                {!! Form::password('text', array('placeholder' => 'Confirmar Password','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Apellidos:</strong>
                                                                {!! Form::password('text', array('placeholder' => 'Confirmar Password','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Cedula:</strong>
                                                                {!! Form::password('text', array('placeholder' => 'Confirmar Password','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Nombres:</strong>
                                                                {!! Form::password('text', array('placeholder' => 'Confirmar Password','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Relacion:</strong>
                                                               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="custom-tabs-empleados2" role="tabpanel" aria-labelledby="custom-tabs-empleados2-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">
                                                <div class="card-header pb-0 mb-2">
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div>
                                                            <h5 class="mb-0">Armamento</h5>
                                                        </div>
                                                      
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                   {{-- {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', ]]) !!}--}}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>N° Reporte:</strong> 
                                                                {!! Form::text('n_reporte', null, array('placeholder' => 'N° Reporte','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Marca:</strong>
                                                                {!! Form::text('marca', null, array('placeholder' => 'Marca','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Modelo:</strong>
                                                                {!! Form::text('modelo', null, array('placeholder' => 'Modelo','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Serial:</strong>
                                                                {!! Form::text('serial', null, array('placeholder' => 'Serial','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Unidad de Asignacion:</strong>
                                                                {!! Form::text('unidad_a', null,array('placeholder' => 'nidad de Asignacion','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Relacion:</strong>
                                                               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="custom-tabs-empleados3" role="tabpanel" aria-labelledby="custom-tabs-empleados3-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">
                                                <div class="card-header pb-0 mb-2">
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div>
                                                            <h5 class="mb-0">Equipo</h5>
                                                        </div>
                                                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('users.index') }}">Volver</a>
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                   {{-- {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', ]]) !!}--}}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>N° Reporte:</strong>
                                                                {!! Form::text('N_reporte', null, array('placeholder' => 'Numero de Reporte','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Tipo:</strong>
                                                                {!! Form::text('tipo', null, array('placeholder' => 'Tipo','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Modelo:</strong>
                                                                {!! Form::text('modelo', null, array('placeholder' => 'Modelo','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Siglas o Serial:</strong>
                                                                {!! Form::text('serial',null, array('placeholder' => 'Siglas','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
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
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(document).ready(function() {
    // Maneja el clic en la pestaña "Armamento"
    $('#custom-tabs-empleados2-tab').click(function(e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace

        // Realiza una solicitud Ajax para cargar el contenido de la URL especificada
        $.get("/resources/views/dress/armamento.blade.php")
            .done(function(data) {
                $('#contenido-dinamico').html(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud Ajax: " + errorThrown);
            });
    });
});
 /*   $(function () {
        $('#roles').select2({
                allowClear: true,
                minimumResultsForSearch: -1,
                width: 300
            });
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('api.personal.empleados.notuser') }}",
            columns: [
                {data: 'actions', name: 'action', orderable: false, searchable: false},
                {data: 'cedula',},
                {data: 'nombre1'},
                {data: 'apellido1'},
                {data: 'tipo_empleado', name: 'tipos_empleados.descripcion', searchable: false},
                {data: 'cargo', name: 'cargos.nombre_cargo'},
                {data: 'ubicacion', name: 'ubicaciones.descripcion'},
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

        $('#table').on('click', '.confirm-asociar', function (event) {
            event.preventDefault();
            var codigo_empleado= $(this).data('id');
            var cedula= $(this).data('cedula');
            var name= $(this).data('name');
            var cargo= $(this).data('cargo');
            var ubicacion= $(this).data('ubicacion');
            Swal.fire({
                title: 'Empleado Seleccionado!',
                text: "Esta seguro de asociarlo al usuario?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#codigo_empleado').val(codigo_empleado);
                    $('#componente_aviacion').val(1);
                    $('#div_seleccion').removeClass("d-none");
                    $('#seleccion_cedula').text(cedula);
                    $('#seleccion_nombre').text(name);
                    $('#seleccion_cargo').text(cargo);
                    $('#seleccion_ubicacion').text(ubicacion);
                    $('.nav-tabs a[href="#custom-tabs-form"]').tab('show')
                }
            });

            return false;

        });

        var table2 = $('#table2').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('api.personal.not-empleados.notuser') }}",
            columns: [
                {data: 'actions', name: 'action', orderable: false, searchable: false},
                {data: 'cedula',},
                {data: 'nombre1'},
                {data: 'apellido1'},
                {data: 'ubicacion', name: 'ubicaciones.descripcion', searchable: false},
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

        $('#table2').on('click', '.confirm-asociar2', function (event) {
            event.preventDefault();
            var codigo_empleado= $(this).data('id');
            var cedula= $(this).data('cedula');
            var name= $(this).data('name');
            var ubicacion= $(this).data('ubicacion');
            Swal.fire({
                title: 'Empleado Otro componente Seleccionado!',
                text: "Esta seguro de asociarlo al usuario?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#codigo_empleado').val(codigo_empleado);
                    $('#componente_aviacion').val(0);
                    $('#div_seleccion').removeClass("d-none");
                    $('#seleccion_cedula').text(cedula);
                    $('#seleccion_nombre').text(name);
                    $('#seleccion_ubicacion').text(ubicacion);
                    $('.nav-tabs a[href="#custom-tabs-form"]').tab('show')
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
    });*/
</script>
@endsection