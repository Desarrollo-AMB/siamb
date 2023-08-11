@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
@section('content')
@if (session()->has('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div id="error-message" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">ASIGNAR NUEVA DEDUCCIÓN</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.nomina.personalcivil.nueva-deduccion') }}">Volver</a>

                </div>
                <div class="card-body px-2 pt-2 pb-2" >
                    {!! Form::open(array('route' => 'sireh.nomina.insertardeduccioncivil','method'=>'POST', 'id' => 'asignar-deduccion-form')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                            <div class="form-group">
                                <strong>Deducciones Disponibles:</strong>
                                {!! Form::select('codigo_concepto', $conceptos_nomina->pluck('descripcion', 'codigo_concepto'), null, ['class' => ' form-control', 'placeholder' => 'Seleccione la deducción a asignar']) !!}
                                {!! Form::hidden('cedula', $dataemp['cedula']) !!}
                                {!! Form::hidden('nombre', $dataemp['empleado_nombre']) !!}
                                {!! Form::hidden('apellido', $dataemp['empleado_apellido']) !!}
                                {!! Form::hidden('codigo_empleado', $dataemp['codigo_empleado']) !!}
                                {!! Form::hidden('tipo', 'D') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Asignar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}



                </div>
            </div>
            <hr class="horizontal dark my-0">

        </div>
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">DEDUCCIONES ASIGNADAS A {{$dataemp['empleado_nombre']}} {{$dataemp['empleado_apellido']}}</h5>
                    </div>
                    <!-- boton para crear una nueva prima -->

                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <div id="tabla-prima">
                    <table id="table" class="table align-items-center mb-0" data-order='[[0, "asc"]]'>
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código de prima</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="false">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count = 1)
                            @foreach ($asignaciones as $key => $user)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{$user->conceptoNomina->descripcion}}</td>
                                <td class="text-center">
                                    <a href="#" class="confirmar-delete" form-target="delete-form-{{  $user->id }}"
                                        title="Eliminar" onclick="event.preventDefault();" >
                                        <i class="cursor-pointer fas fa-trash text-danger" aria-hidden="true"></i>
                                    </a>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('sireh.nomina.civil.deletededuccionesAsignadas', ['registro' => $user->id, 'cedula' => $dataemp['cedula']]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    {{--!! $data->render() !!--}}
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    setTimeout(function() {
        var successMessage = document.getElementById("success-message");
        if (successMessage) {
            successMessage.style.display = "none";
        }
    }, 2000); // 3000 milisegundos = 3 segundos
    setTimeout(function() {
        var errorMessage = document.getElementById("error-message");
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    }, 2000); // 3000 milisegundos = 3 segundos
</script>
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
                        text: 'La deducción ha sido eliminada con exito.',
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
