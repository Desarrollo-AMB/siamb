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
                        <h5 class="mb-0">Personal Militar</h5>
                    </div>
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
{{-- Modal para Suspender o Activar Profesional --}}
<div class="modal fade" id="modal-view">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form>
            @csrf
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal">Cambio de Situación</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input name="id_empleado" id="id_empleado" type="hidden" value="">
                    <input name="codigo_ubicacion" id="codigo_ubicacion" type="hidden" value="">
                    <input name="codigo_cargo" id="codigo_cargo" type="hidden" value="">

                    <div class="form-group">
                        <h6>Situación Actual: </h6>
                        <input name="situacion" type="text" class="form-control" value="" disabled>
                    </div>

                    <div class="form-group">
                        <h6>Fecha de Cambio de Situación: </h6>
                        <input name="fecha_movimiento" type="date" class="form-control" required value="">
                    </div>

                    <div class="form-group">
                        <h6>Tipo de Movimiento: </h6>
                        <input name="fecha_movimiento" type="date" class="form-control" required value="">
                    </div>
                
                    <div class="form-group">
                        <h6>Exposicion de Motivo de la Situación:</h6>
                        <textarea name="observaciones" class="form-control" rows="5" required></textarea>
                    </div>
                
            </div>
            <div class="modal-footer justify-content-rigth">
                <button type="button" class="btn btn-primary" id="btn-situacion">Cambiar Situación</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button> 
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- /.modal --}}
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 25,
            ajax: "{{ route('sireh.personal.militar.data') }}",
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
        table.on('click', '.suspender', function() {
            var id = $(this).data("id");
            console.log(id);    
   
            $('#modal-view').on('shown.bs.modal', function(e) {
                $('#modal-view #id_empleado').val(id);
            })
            $('#modal-view').modal("show");  
        });

        $('#btn-situacion').on('click', function(){
            console.log('Egresar');
            var fd = new FormData();
            var form = $(this).parents('form:first');
            var validator= form.validate({
                rules: {
                    fecha_movimiento : {
                        required: true,
                    },
                    observaciones : {
                        required: true,
                    },
                },
                messages : {
                    fecha_movimiento: {
                        required: "Fecha de Cambio de Situación es requerida"
                    },
                    observaciones: {
                        required: "El motivo de Cambio de Situación es requerido"
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
                        url:'{{ route("sireh.personal-militar.situacion") }}',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success:function(res){
                            console.log(res);
                          
                            Swal.fire({
                                title: 'Cambio de Situacion!',
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

            //$('#modal-view').modal("hide"); 
        });

    });
</script>
@endsection