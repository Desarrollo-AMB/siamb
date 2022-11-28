@extends('layouts.user_type.auth')
@section('title', 'Personal Civil - Jubilados')
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
        <div class="row mb-4 mx-4 justify-content-end">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <a href="{{route('sireh.personal-civil.jubilados.fecha-jubilados')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Reporte Jubilados
                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#a7e9b0,#087904)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fa fa-file-excel text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="horizontal dark my-0">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Personal Civil por Jubilar</h5>
                    </div>
                </div>
            </div>
            
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap" data-order='[[2, "asc"]]'>
                                    <thead>
                                        <tr>
                                            <th>Tipo Empleado</th>
                                            <th>Nombre y Apellido</th>
                                            <th>Cedula</th>
                                            <th>Fecha Ingreso </th>
                                            <th>Años de Servicio</th>
                                            <th>Edad</th>
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

{{-- Modal jubilar empleados --}}
<div class="modal fade" id="modal-view-jubilar" tabindex="-1" role="dialog" aria-labelledby="jubilarTitle" aria-hidden="true">
    <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Jubilar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input class="id_empleado_jubilar" name="id_empleado_jubilar" id="id_empleado_jubilar" type="hidden" value="">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tipo de Empleado</label>
                                <input  type="text" class="form-control" value="" id="tipo_empleado" disabled>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre y Apellido</label>
                                <input  type="text" class="form-control" value="" id="nombre_jubi" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="cedula_jubi" class="col-form-label">Cedula</label>
                                <input  type="text" class="form-control " value="" id="cedula_jubi" disabled>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="fecha_ingreso_jubi" class="col-form-label">Fecha Ingreso</label>
                                <input  type="date" class="form-control " value="" id="fecha_ingreso_jubi" disabled>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="antiguedad" class="col-form-label">Antiguedad</label>
                                <input  type="text" class="form-control " value="" id="antiguedad" disabled>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="edad" class="col-form-label">Edad</label>
                                <input  type="text" class="form-control " value="" id="edad" disabled>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha de Jubilación</label>
                                <input  type="date" class="form-control" value="" id="fecha_jubilacion" name="fecha_jubilacion" required>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Observaciones</label>
                                <input  type="text" class="form-control " value="" id="observaciones" name="observaciones">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn bg-gradient-danger" data-bs-dismiss="modal" disabled="false">Atras</a>
                    <button type="submit" class="btn bg-gradient-success enviar_jubilado">Jubilar</button>
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
            ajax: "{{ route('api.sireh.personal-civil-jubilables.data') }}",
            columns: [
                {data: 'tipo_empleado', name: 'tipos_empleados.descripcion'},
                {data: null, render: function ( data, type, row ) {
                    return data.nombre1 +' '+data.nombre2 +', '+data.apellido1 + ' '+data.apellido2; 
                    }
                },
                {data: 'cedula',},
                {data: 'fecha_ingreso', name: 'nomina.fecha_ingreso',
                    render: function ( data, type, row ) {
                        return moment(data,'YYYY-MM-DD').format("DD-MM-YYYY"); 
                    }
                },
                {data: 'antiguedad'},
                {data: 'edad',},
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //JUBILAR
        table.on('click', '.jubilar', function() {
            var id = $(this).data("id");
            $('#modal-view-jubilar').on('shown.bs.modal', function(e) {
                $('#modal-view-jubilar #id_empleado_jubilar').val(id);
            })
            $.ajax({
                url:"{{ route('sireh.personal-civil.showJubilado') }}",
                method:'POST',
                data:{id:id},
                cache: false,
                dataType: 'json',
                success: function(response){
                    if(response){
                        let res = response.data[0];
                        console.log(res);
                        $('#id_empleado_jubilar').val(res.codigo_empleado);
                        $('#tipo_empleado').val(res.tipo_empleado);
                        $('#nombre_jubi').val(res.nombre1 +' '+ res.apellido1);
                        $('#cedula_jubi').val(res.cedula);
                        $('#fecha_ingreso_jubi').val(res.fecha_ingreso);
                        $('#edad').val(res.edad);
                        $('#antiguedad').val(res.antiguedad);
                        $('#modal-view-jubilar').modal("show");
                    }
                    else{
                        alert('Fallo en la peticion con el servidor')
                    }
                }
            });
        });

        $(".enviar_jubilado").click(function(e){
            e.preventDefault();
            //ENVIAR
            $.ajax({
            url:"{{ route('sireh.personal-civil.storeJubilado') }}",
            method:'POST',
            data:{
                    codigo_empleado:$('#id_empleado_jubilar').val(),
                    /*tipo_jubilar:$('.tipo_jubilar').val(),
                    nombre_jubi:$('.nombre_jubi').val(),
                    cedula_jubi:$('.cedula_jubi').val(),
                    fecha_ingreso_jubi:$('.fecha_ingreso_jubi').val(),
                    edad_jubi:$('.edad_jubi').val(),*/
                    fecha_jubilacion:$('#fecha_jubilacion').val(),
                    observaciones:$('#observaciones').val(),
                },
                success:function(response){
                    if(response.success){
                        $('#modal-view-jubilar').modal('hide');
                        $('#table').DataTable().ajax.reload(); 
                        Swal.fire({
                            title: 'LISTO!',
                            text: 'Empleado Jubilado Correctamente!',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                        //setTimeout(function () {
                            //window.location.reload();
                        //}, 1200);
                    }
                },
                error:function(error){
                    console.log(error)
                }
            });
        });
    });
</script>
@endsection
