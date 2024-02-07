@extends('layouts.user_type.auth')
@section('title', 'Personal Civil')
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
                        <h5 class="mb-0">Personal no Militar</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="row justify-content-end">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('sireh.personal-civil.noActive')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Personal  No Activo
                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#cc886f,#ee1505)" class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                    <i class="fas fa-user-times text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{route('sireh.personal-civil.evaluaciones.index')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Reporte Evaluaciones
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
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <a href="{{ route('sireh.personal-civil-jubilables.index')}}">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                            <p class="font-weight-bolder mb-0">
                                                Modulo Jubilacion
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div style="background-image:linear-gradient(310deg,#3a9c9b,#087904)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa fa-house-user text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                {{--<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="#">
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
                </div>--}}
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
                                            <th>Codigo_Rac</th>
                                            <th>Tipo de Empleado</th>
                                            <th>Cargo</th>
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
{{-- Modal para suspender --}}
<div class="col-md-4">
    <!-- Modal -->
    <div class="modal fade" id="modal-view-suspender" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
      <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambio de Situación del Profesional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input class="codigo_empleado_suspender" name="id_empleado_suspender" id="id_empleado_suspender" type="hidden" value="">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha de Suspención</label>
                                <input style="height: 35px" type="date" class="form-control fechaSuspencion" value="" id="fechaSuspencion">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Motivo de Suspención</label>
                                <select class="form-control motivo select2" id="motivo" name="motivo" required>
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
                                <textarea style="text-transform: uppercase; height: 100px" class="form-control observaciones" name="" id="" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Atras</button>
                    <button type="submit" class="btn bg-gradient-success enviar_suspencion">Confirmar</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

{{-- Modal para egresar --}}
<div class="modal fade" id="modal-view-egresar">
    <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambio de Situación del Profesional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input class="codigo_empleado_egresar" name="codigo_empleado_egresar" id="codigo_empleado_egresar" type="hidden" value="">
                    <div class="row">
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha de Ingreso</label>
                                <input  type="date" class="form-control fecha_ingreso" value="{{$datos->nomina->fecha_ingreso}}" id="" disabled="true">
                            </div>
                        </div> --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha de Egreso</label>
                                <input  type="date" class="form-control fecha_egreso" value="" id="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Motivo de Egreso</label>
                                <select class="form-control egreso select2" id="egreso" name="egreso" required>
                                    <option value="">Seleccione...</option>
                                    <option value="PRIVADO DE LIBERTAD">PRIVADO DE LIBERTAD</option>
                                    <option value="RENUNCIA">RENUNCIA</option>
                                    <option value="DESPIDO">DESPIDO</option>
                                    <option value="DESPIDO">FALLECIDO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Observaciones</label>
                                <textarea style="height: 100px" class="form-control observaciones_egreso" name="" id="" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Atras</button>
                    <button type="button" class="btn bg-gradient-success enviar_egreso">Confirmar</button>
                </div>
            </form>
        </div>
      </div>
</div>

{{-- Modal Cursos Realizados --}}
<div class="modal fade" id="modal-view-cursos" tabindex="-1" role="dialog" aria-labelledby="egresarTitle" aria-hidden="true">
    <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <input class="id_empleado_cursos" name="id_empleado_cursos" id="id_empleado_cursos" type="hidden" value="">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Seleccionar Curso</label>
                                <select class="form-control cursos_select select2" id="cursos_select" name="cursos_select" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($cursos as $data)
                                        <option value="{{$data->codigo_curso}}">{{$data->descripcion_curso}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Desde</label>
                                <input  type="date" class="form-control desde_curso" value="" id="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Hasta</label>
                                <input  type="date" class="form-control hasta_curso" value="" id="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn bg-gradient-danger" data-bs-dismiss="modal" disabled="false">Atras</a>
                    <a class="btn bg-gradient-success enviar_curso" disabled="false">Confirmar</a>
                </div>
            </form>
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
                                <input  type="text" class="form-control tipo_jubilar" value="" id="" disabled>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre y Apellido</label>
                                <input  type="text" class="form-control nombre_jubi" value="" id="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Cedula</label>
                                <input  type="text" class="form-control cedula_jubi" value="" id="" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha Ingreso</label>
                                <input  type="date" class="form-control fecha_ingreso_jubi" value="" id="" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Edad</label>
                                <input  type="text" class="form-control edad_jubi" value="" id="" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Fecha de Jubilación</label>
                                <input  type="date" class="form-control fecha_jubi" value="" id="" required>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Observaciones</label>
                                <input  type="text" class="form-control observaciones_jubi" value="" id="">
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
            ajax: "{{ route('api.sireh.personal.civil.data') }}",
            columns: [
                {data: 'cedula',},
                {data: 'nombre1'},
                {data: 'apellido1'},
                {data: 'codigo_rac', name: 'nomina.cod_rac', searchable: false},
                {data: 'tipo_empleado', name: 'tipos_empleados.descripcion', searchable: false},
                {data: 'cargo', name: 'cargos.nombre_cargo'},
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //SUSPENDER
        table.on('click', '.suspender', function() {
            var id = $(this).data("id");
            $('#modal-view-suspender').on('shown.bs.modal', function(e) {
                $('#modal-view-suspender #id_empleado_suspender').val(id);
            })
            $('#modal-view-suspender').modal("show");
        });
        $(".enviar_suspencion").click(function(e){
            e.preventDefault();
            var motivo = $('.motivo').val();
            if(motivo===""){
                Swal.fire({
                    title: 'Atención!',
                    text: 'Debes Ingresar un Motivo.',
                    icon: 'warning',
                    timer: 3000,
                    showConfirmButton: true,
                });
            }else{
                //ENVIAR
                $.ajax({
                url:"{{ route('sireh.personal-civil.suspender') }}",
                method:'POST',
                data:{
                    fecha: $('.fechaSuspencion').val(),
                    motivo: motivo,
                    observaciones: $('.observaciones').val().toUpperCase(),
                    codigo_empleado: $('.codigo_empleado_suspender').val(),
                    },
                    success:function(response){
                        if(response.success){
                            $('#exampleModalMessage').modal('hide');
                            Swal.fire({
                                title: 'LISTO!',
                                text: 'Empleado Suspendido Correctamente!',
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

        //EGRESAR
        table.on('click', '.egresar', function() {
            var id = $(this).data("id");
            $('#modal-view-egresar').on('shown.bs.modal', function(e) {
                $('#modal-view-egresar #codigo_empleado_egresar').val(id);
            })
            $('#modal-view-egresar').modal("show");
        });
        $(".enviar_egreso").click(function(e){
            e.preventDefault();
            var egreso = $('.egreso').val();
            if(egreso===""){
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
                url:"{{ route('sireh.personal-civil.egreso') }}",
                method:'POST',
                data:{
                        egreso: egreso,
                        fecha_ingreso: $('.fecha_ingreso').val(),
                        fecha_egreso: $('.fecha_egreso').val(),
                        observaciones: $('.observaciones_egreso').val().toUpperCase(),
                        codigo_empleado: $('.codigo_empleado_egresar').val(),
                    },
                    success:function(response){
                        if(response.success){
                            $('#egresar').modal('hide');
                            Swal.fire({
                                title: 'LISTO!',
                                text: 'Empleado Egresado Correctamente!',
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

        //CURSOS
        table.on('click', '.cursos', function() {
            var id = $(this).data("id");
            $('#modal-view-cursos').on('shown.bs.modal', function(e) {
                $('#modal-view-cursos #id_empleado_cursos').val(id);
            })
            $('#modal-view-cursos').modal("show");
        });
        $(".enviar_curso").click(function(e){
            e.preventDefault();
            var curso = $('.cursos_select').val();
            if(curso===""){
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
                url:"{{ route('sireh.personal-civil.agregarCurso') }}",
                method:'POST',
                data:{
                        curso: curso,
                        desde_curso: $('.desde_curso').val(),
                        hasta_curso: $('.hasta_curso').val(),
                        codigo_empleado: $('.id_empleado_cursos').val(),
                    },
                    success:function(response){
                        if(response.success){
                            $('#modal-view-cursos').modal('hide');
                            Swal.fire({
                                title: 'LISTO!',
                                text: 'Curso Agregado Correctamente!',
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

    });
</script>
@endsection
