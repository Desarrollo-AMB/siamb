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
                        <h5 class="mb-0">Periodo de Ascenso</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="row justify-content-end">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('juntap.ascenso.julio')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Julio
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
                        <a href="{{route('juntap.ascenso.diciembre')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                      Diciembre
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
            
            
        </div>
    </div>
</div>
{{-- Modal para suspender --}}

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
