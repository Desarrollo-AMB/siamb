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
                        <h5 class="mb-0">Personal Militar Activo</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            @include('sireh.personal.militar._barra_auxiliar')
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

{{-- Modal para Dar de Baja Profesional --}}
{{--<div class="modal fade" id="modal-view-baja-militar" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dar de Baja al Profesional</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                @csrf
                <input type="hidden" value="" name="id" id="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Motivo de Suspención</label>
                                <select class="form-control motivo" id="motivo" name="motivo" required>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha de Ingreso</label>
                                <input style="height: 35px" type="date" class="form-control" value="" name="fechaSuspencion" id="fechaSuspencion">
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
                    <button type="submit" class="btn bg-gradient-success" id="btn-baja_militar">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>--}}
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
            ajax: "{{ route('api.sireh.personal.militar.data') }}",
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
            console.log(id);    
   
            $('#modal-view').on('shown.bs.modal', function(e) {
                $('#modal-view #id_empleado').val(id);
            })
            $('#modal-view').modal("show");

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
                    url:'{{ route("sireh.personal-militar.suspender") }}',
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
    });
</script>
@endsection