@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
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
                        <h5 class="mb-0">Personal Extra Componente</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            @include('extra_component._barra_auxiliar')
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="table" class="table table-striped table-bordered nowrap" data-order='[[2, "asc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Cedula</th>
                                            <th>Nombre </th>
                                            <th>Apellido</th>
                                            <th>Grado Militar</th>
                                            <th>Ubicacion</th>
                                            <th>Acciones</th>
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

{{-- Modal para Suspender Profesional --}}
<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Suspención del Profesional</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                @csrf
                <input type="hidden" value="" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha de Suspención</label>
                                <input style="height: 35px" type="date" class="form-control" value="" name="fechaSuspencion" id="fechaSuspencion">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Motivo de Suspención</label>
                                <select class="form-control motivo" id="motivo" name="motivo" required>
                                    <option value="">Seleccione...</option>
                                    <option value="DESERTOR">DESERTOR</option>
                                    <option value="PRESUNTO DESERTOR">PRESUNTO DESERTOR</option>
                                    <option value="RETARDADO SIN CAUSA JUSTIFICADA">RETARDADO SIN CAUSA JUSTIFICADA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Observaciones</label>
                                <textarea style="text-transform: uppercase; height: 100px" class="form-control" name="observaciones" id="observaciones" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Atras</button>
                    <button type="submit" class="btn bg-gradient-success" id="btn-suspender_militar">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- /.modal --}}

{{-- MODAL FUNCION EMPLEADO --}}
<div class="modal fade" id="modal-view-funcion_empleado" tabindex="-1" role="dialog" aria-labelledby="egresarTitle" aria-hidden="true">
    <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar Función</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input class="codigo_empleado_funcion" name="codigo_empleado_funcion" id="codigo_empleado_funcion" type="hidden" value="">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre y Apellido</label>
                                <input  type="text" class="form-control nombre_empleado" value="" id="nombre_empleado" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">cedula</label>
                                <input  type="text" class="form-control cedula_empleado" value="" id="cedula_empleado" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Seleccionar Función</label>
                                <select class="form-control funcion select2" id="funcion" name="funcion[]" multiple="multiple" required>
                                    {{--<option value="">Seleccione...</option>
                                    @foreach($funcionEmpleado as $data)
                                        <option value="{{$data->id}}">{{$data->funcion}}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="haveFuncion">
                        <label class='col-form-label showLabel' hidden="true">Funciones del Empleado</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn bg-gradient-danger close-modal" data-bs-dismiss="modal" disabled="false">Atras</a>
                    <a class="btn bg-gradient-success enviar_funcion" disabled="false">Confirmar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        $('.select2').select2();

        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('api.personal.data') }}",
            columns: [
                {data: 'cedula',},
                {data: 'nombre1'},
                {data: 'apellido1'},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: 'ubicacion', name: 'ubicaciones.descripcion', searchable: false},
                {data: 'actions', name: 'action', orderable: false, searchable: false},
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

        table.on('click', '.suspender_militar', function() {
            var id = $(this).data("id");

            $('#modal-view').modal("show");
            $('#modal-view').on('shown.bs.modal', function(e) {
                $('#modal-view #id_empleado').val(id);
            })
            $("#id").val(id);
        });

        $('#btn-suspender_militar').on('click', function(){
            console.log('Suspender');
            var fd = new FormData();
            var form = $(this).parents('form:first');
            var validator= form.validate({
                rules: {
                    fechaSuspencion : {
                        required: true,
                    },
                    motivo : {
                        required: true,
                    },
                    observaciones : {
                        required: true,
                    },
                },
                messages : {
                    fechaSuspencion: {
                        required: "Fecha de Suspencion es requerida"
                    },
                    motivo : {
                        required: "Motivo de Suspencion es requerido"
                    },
                    observaciones: {
                        required: "Las Observaciones de Suspencion es requerido"
                    },
                }
            });
            if(validator.form()){
                var other_data = form.serializeArray();
                ///Obtener inputs
                $.each(other_data,function(key,input){
                    fd.append(input.name,input.value);
                });

                $.ajax({
                    type:'POST',
                    url:'{{ route("egresar.personal") }}',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success:function(res){
                        Swal.fire({
                            title: 'Egreso!',
                            text: 'Proceso realizado satisfactoriamente...',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                        if(res.success){
                            window.location.reload();
                        }
                    }
                });
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //FUNCIONES PARA LOS EMPLEADOS
        table.on('click', '.funcion_empleado', function() {
            var id = $(this).data("id");
            $("#haveFuncion").empty();
            $.ajax({
                url:"{{ route('personal.showData') }}",
                method:'POST',
                data:{id:id},
                cache: false,
                dataType: 'json',
                success: function(response){
                    if(response){
                        let res = response.data[0]
                        $('#modal-view-funcion_empleado #nombre_empleado').val(res.nombre1 + ' ' +res.apellido1)
                        $('#modal-view-funcion_empleado #cedula_empleado').val(res.cedula);
                        $('#modal-view-funcion_empleado #codigo_empleado_funcion').val(res.codigo_empleado);
                        /*$('#modal-view-funcion_empleado').on('shown.bs.modal', function(e) {
                            $('#modal-view-funcion_empleado #codigo_empleado_funcion').val(res.codigo_empleado);
                        })*/

                        $("#funcion").empty();
                        $("#funcion").select2({ placeholder: "Seleccione la Funcion"});
                        $.each(response.funcionTripulante, function (key, value){
                            $("#funcion").append("<option value=\""+value.id+"\">"+value.funcion+"</option>");
                        });

                        $('#funcion').val(response.idsFuncion);

                        $('#funcion').trigger('change');

                        /*if (response.haveFuncion.length > 0) {
                            $('.showLabel').prop('hidden', false);
                            $("#haveFuncion").empty();
                            $.each(response.haveFuncion, function (key, value){
                                $('#haveFuncion').append(
                                    "<div id='row'>\
                                        <div style='margin-bottom: 0;' class='input-group'>\
                                            <div class='col-sm'>\
                                                <p style='padding-left: 20px;'>- "+value.funcion+"</p>\
                                            </div>\
                                            <div class='col-sm-1'>\
                                                <div style='margin-bottom: 0;' class='form-group'>\
                                                    <a class='eliminar_funcion' id='"+value.id+"' type='button'>\
                                                    <i style='color:red;' class='fas fa-times'></i>\
                                                    </a>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                    "
                                );
                            })
                        }*/
                    }
                    else{
                        alert('Fallo en la peticion con el servidor')
                    }
                }
            });
            $('#modal-view-funcion_empleado').modal("show");
        });
        $(".enviar_funcion").click(function(e){
            e.preventDefault();
            var funcion = $('.funcion').val();
            if(funcion===""){
                Swal.fire({
                    title: 'Atención!',
                    text: 'Debes Ingresar una Funcion.',
                    icon: 'warning',
                    timer: 3000,
                    showConfirmButton: true,
                });
            }else{
                //ENVIAR
                $.ajax({
                url:"{{ route('personal.storeFuncion') }}",
                method:'POST',
                data:{
                        codigo_empleado: $('#codigo_empleado_funcion').val(),
                        funcion_id: $('.funcion').val()
                    },
                    success:function(response){
                        if(response.success){
                            $('#modal-view-funcion_empleado').modal('hide');
                            Swal.fire({
                                title: 'LISTO!',
                                text: 'Funcion Registrada Correctamente!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
        });

        $("body").on("click", ".eliminar_funcion", function () {
            var id = $(this).attr('id')
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
                    $.ajax({
                        url:"{{ route('personal.deleteFuncion') }}",
                        method:'POST',
                        data:{id:id},
                        cache: false,
                        dataType: 'json',
                        success: function(response){
                            if(response){
                                window.location.reload();
                            }
                        }
                    });
                    Swal.fire({
                        title: 'Eliminado!',
                        text: 'La Función ha sido eliminada.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                }
            });
        })
    });
</script>
@endsection
