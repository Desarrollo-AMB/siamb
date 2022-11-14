@extends('layouts.user_type.auth')
@section('title', 'Personal Civil')
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
                        <h5 class="mb-0">Personal Civil No Activo</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="javascript: history.go(-1)">Volver</a>
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
                                        <th>Tipo de Empleado</th>
                                        <th>Cargo</th>
                                        {{-- <th>Situacion</th> --}}
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($noActive as $data)
                                        <tr>
                                            <th  class="font-weight-normal">{{$data->cedula}}</th>
                                            <th  class="font-weight-normal">{{$data->nombre1}} {{$data->apellido1}}</th>
                                            <th  class="font-weight-normal">{{$data->tipo_emp}}</th>
                                            <th  class="font-weight-normal">{{$data->nombre_cargo}}</th>
                                            {{-- <th  class="font-weight-normal">{{$data->situacion}}</th> --}}
                                            <th>
                                                <input class="codigo_empleado_activar" name="codigo_empleado_activar" id="codigo_empleado_activar" type="hidden" value="">
                                                <a href="{{ route('sireh.personal-civil.view', $data->id) }}" class="mx-3" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Ver" title="Ver">
                                                    <i class="fas fa-eye text-info" aria-hidden="true"></i>
                                                </a>
                                                @role('administrador')
                                                    <a href="#" class="mx-3 activar activar_empleado" data-id="{{$data->codigo_empleado}}" data-bs-toggle="tooltip" data-bs-original-title="Activar" title="Activar Empleado">
                                                        <i class="fas fa-power-off text-success" aria-hidden="true"></i>
                                                    </a>
                                                @endrole
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            responsive: true,
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        table.on('click', '.activar_empleado', function() {
            var id = $(this).data("id");
            $('#codigo_empleado_activar').val(id);
            Swal.fire({
                title: 'ACTIVACION DE EMPLEADO',
                text: "Estas Seguro de Activar este Empleado?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('sireh.personal-civil.activar') }}",
                        method:'POST',
                        data:{
                            codigo_empleado: $('.codigo_empleado_activar').val(),
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(response){
                            if(response){
                                console.log(response)
                            }
                        }
                    });
                    Swal.fire({
                        title: 'ACTIVADO!',
                        text: 'Empleado Activado Correctamente.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: true,
                    }); 
                    setTimeout(function () {
                        window.location.href = "{{ route('sireh.personal-civil.index') }}";
                    }, 1200);  
                }
            });
        });
    });
</script>
@endsection