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
                        <h5 class="mb-0">Personal Civil Evaluaciones</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="javascript: history.go(-1)">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                        <div class="card">
                            <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                <h5 class="card-title">Datos Personales</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Nombres:</h6>
                                            <input name="nombre1" value="{{$datos->nombre1}} {{$datos->nombre2}}" class = "form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Apellidos:</h6>
                                            <input name="apellido" value="{{$datos->apellido1}} {{$datos->apellido2}}" class = "form-control" disabled>
                                       </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Cédula:</h6>
                                            <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" disabled 
                                                value="{{ $datos->cedula }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>fecha ingreso:</h6>
                                            <input id="cedula" type="date" class="form-control @error('cedula') is-invalid @enderror" name="cedula" disabled 
                                                value="{{ $datos->nomina->fecha_ingreso }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Tipo de Empleado:</h6>
                                                @foreach ($tipos_emp as $row)
                                                    @if ($datos->nomina->tipo_emp == $row->tipo_emp)
                                                        <input type="text" class="form-control @error('cedula') is-invalid @enderror" disabled  value="{{ $row->descripcion }}">
                                                    @endif
                                                @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-5">
                                        <div class="form-group">
                                            <h6>Unidad:</h6>
                                            @foreach ($ubicaciones as $row)
                                                @if ($datos->nomina->codigo_ubicacion == $row->codigo_ubicacion)
                                                    <input type="text" class="form-control @error('cedula') is-invalid @enderror" disabled  value="{{ $row->descripcion }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <h6>Cargo:</h6>
                                            @foreach ($cargos as $row)
                                                @if ($datos->nomina->codigo_cargo == $row->codigo_cargo)
                                                    <input type="text" class="form-control @error('cedula') is-invalid @enderror" disabled  value="{{ $row->nombre_cargo }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 pt-3">
                        <div class="card-header pb-0 mb-2">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Lista de Evaluaciones</h5>
                                </div>
                                @role('administrador')
                                    <button type="button" class="btn btn-success evaluar">
                                        Agregar Evaluación
                                    </button>
                                @endrole
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap" data-order='[[2, "asc"]]'>
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Datos Evaluador</th>
                                        <th>Nota</th>
                                        <th>Rango de Actuacion</th>
                                        <th>Observaciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluaciones as $data)
                                    <tr>
                                        <th class="font-weight-normal">{{$data->fecha_evaluacion}}</th>
                                        <th class="font-weight-normal">CI-{{$data->cedula_evaluador}} - {{$data->nombre_evaluador}}</th>
                                        <th class="font-weight-normal">{{$data->nota}}</th>
                                        <th class="font-weight-normal">{{$data->rango_actuacion}}</th>
                                        <th class="font-weight-normal">{{$data->obervaciones}}</th>
                                        <th class="font-weight-normal">
                                            <button value="{{$data->id}}" class="btn btn-info mx-3 editar">Editar</button>
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @role('administrador')
                    {{-- Modal Registrar Evaluacion --}}
                    <div class="modal fade" id="evaluar" tabindex="-1" role="dialog" aria-labelledby="EvaluarTitle" aria-hidden="true">
                        <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Evaluación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form>
                                    <div class="modal-body">
                                        <input class="codigo_empleado" name="codigo_empleado" id="codigo_empleado" type="hidden" value="{{$datos->codigo_empleado}}">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">fecha de evaluacion:</label>
                                                    <input  type="date" class="form-control fecha_evaluacion" value="" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Cedula del Evaluador:</label>
                                                    <input  type="number" class="form-control cedula_evaluador" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nombres y Apellidos del Evaluador:</label>
                                                    <input  type="text" class="form-control nombre_evaluador" value="" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nota:</label>
                                                    <input  type="number" class="form-control nota" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Rango de Actuacion:</label>
                                                    <input  type="text" class="form-control rango_actuacion" value="" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Observaciones:</label>
                                                    <input  type="text" class="form-control obervaciones" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn bg-gradient-danger" data-bs-dismiss="modal" disabled="false">Atras</a>
                                        <a class="btn bg-gradient-success enviar_evaluacion" disabled="false">Confirmar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Modal editar Evaluacion --}}
                    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="EvaluarTitle" aria-hidden="true">
                        <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Evaluación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form>
                                    <div class="modal-body">
                                        <input class="intelectual_id" name="intelectual_id" id="intelectual_id" type="hidden" value="{{$datos->id}}">
                                        <input class="codigo_empleado" name="codigo_empleado" id="codigo_empleado" type="hidden" value="{{$datos->codigo_empleado}}">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">fecha de evaluacion:</label>
                                                    <input  type="date" class="form-control fecha_evaluacion_load" value="" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Cedula del Evaluador:</label>
                                                    <input  type="number" class="form-control cedula_evaluador_load" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nombres y Apellidos del Evaluador:</label>
                                                    <input  type="text" class="form-control nombre_evaluador_load" value="" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nota:</label>
                                                    <input  type="number" class="form-control nota_load" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Rango de Actuacion:</label>
                                                    <input  type="text" class="form-control rango_actuacion_load" value="" id="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Observaciones:</label>
                                                    <input  type="text" class="form-control obervaciones_load" value="" id="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn bg-gradient-danger" data-bs-dismiss="modal" disabled="false">Atras</a>
                                        <a class="btn bg-gradient-success update_evaluacion" disabled="false">Actualizar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endrole
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

        $(".evaluar").click(function(e){
            $('#evaluar').modal("show");  
        });
        $(".enviar_evaluacion").click(function(e){
            e.preventDefault();
            var cedula_evaluador = $('.cedula_evaluador').val();
            if(cedula_evaluador===""){
                Swal.fire({
                    title: 'Atención!',
                    text: 'Debes Ingresar un motivo de Egreso.',
                    icon: 'warning',
                    timer: 3000,
                    showConfirmButton: true,
                }); 
            }else{
                //ENVIAR
                $.ajax({
                url:"{{ route('sireh.personal-civil.storeEvaluar') }}",
                method:'POST',
                data:{
                        codigo_empleado:  $('.codigo_empleado').val(),
                        fecha_evaluacion: $('.fecha_evaluacion').val(),
                        cedula_evaluador: $('.cedula_evaluador').val(),
                        nombre_evaluador: $('.nombre_evaluador').val().toUpperCase(),
                        nota: $('.nota').val().toUpperCase(),
                        rango_actuacion: $('.rango_actuacion').val(),
                        obervaciones: $('.obervaciones').val().toUpperCase(),
                    },
                    success:function(response){
                        if(response.success){
                            $('#evaluar').modal('hide');
                            Swal.fire({
                                title: 'LISTO!',
                                text: 'Evaluación Registrada Correctamente!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 1200);
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
        });

        $(".editar").click(function(e){
            var id_edit = $(this).val();
            $.ajax({
                url:"{{ route('sireh.personal-civil.editEvaluar') }}",
                method:'POST',
                data:{id:id_edit},
                cache: false,
                dataType: 'json',
                success: function(response){
                    if(response){
                        let res = response.data[0]
                        $('.intelectual_id').val(res.id)
                        $('.codigo_empleado_load').val(res.codigo_empleado)
                        $('.fecha_evaluacion_load').val(res.fecha_evaluacion)
                        $('.cedula_evaluador_load').val(res.cedula_evaluador)
                        $('.nombre_evaluador_load').val(res.nombre_evaluador)
                        $('.nota_load').val(res.nota)
                        $('.rango_actuacion_load').val(res.rango_actuacion)
                        $('.obervaciones_load').val(res.obervaciones)
                        $('#editar').modal("show")
                    }
                    else{
                        alert('Fallo en la peticion con el servidor')
                    }
                }
            }); 
        });
        $(".update_evaluacion").click(function() {
                $.ajax({
                    url:"{{ route('sireh.personal-civil.updateEvaluar') }}",
                    method:'POST',
                    data:{
                        id:$('.intelectual_id').val(),
                        codigo_empleado:  $('.codigo_empleado_load').val(),
                        fecha_evaluacion: $('.fecha_evaluacion_load').val(),
                        cedula_evaluador: $('.cedula_evaluador_load').val(),
                        nombre_evaluador: $('.nombre_evaluador_load').val().toUpperCase(),
                        nota: $('.nota_load').val().toUpperCase(),
                        rango_actuacion: $('.rango_actuacion_load_load').val(),
                        obervaciones: $('.obervaciones_load').val().toUpperCase(),
                    }, 
                    cache: false,
                    dataType: 'json',
                    success: function(response){
                        if(response){
                            Swal.fire({
                                title:'Actualizado!',
                                text: 'Datos Actualizados Correctamente.',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 1200);
                        }
                    }
                });
            });

    });
</script>
@endsection