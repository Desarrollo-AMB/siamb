@extends('layouts.user_type.auth')
@section('title', 'FAM0001')
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
            <hr class="horizontal dark my-0">
            <div class="card-header pb-0 mb-2 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <div class="col-sm-2 mb-2 mb-sm-0">
                    <h5 class="mb-0">
                        <a class="btn btn-dark btn-block my-2" href="{{ route('dao.index') }}">
                            <i class="ti-arrow-left" aria-hidden="true"><title>Volver</title></i> &nbsp; Volver
                        </a>
                    </h5>
                </div>
                <div class="col-sm-5 text-center mb-2 mb-sm-0">
                    <h4 class="mb-0">Programación de vuelo del día: <span id="fecha_cabecera" class="mb-0"></span></h4>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            @include('dao.operacionesAereas.programacionVuelo._barra_auxiliar')
            @role('aviacion_dao|administrador|cmd_general')
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        @foreach ($fam0001 as $key => $data)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-heading{{$key}}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$key}}" aria-expanded="false" aria-controls="flush-collapse{{$key}}" id="{{$key}}">
                                                        {{$key}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse{{$key}}" class="accordion-collapse" aria-labelledby="flush-heading{{$key}}" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        @php $unidadprogramo = 'si'; @endphp
                                                        @foreach ($data as $dataunidad)
                                                            @if ($dataunidad->completado == 'sinProg')
                                                                @php $unidadprogramo = 'no' @endphp
                                                            @endif
                                                        @endforeach
                                                        @if ($unidadprogramo == 'no')
                                                            <div class="alert alert-warning mx-4" role="alert">
                                                                <ul>
                                                                    <li><h5>No se ha programado vuelos para esta unidad</h5></li>
                                                                </ul>
                                                            </div>
                                                        @else
                                                            <table name="table" id="table{{$key}}" class="table table-sm table-bordered table-hover table-striped dt-responsive w-100 nowrap" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="tex-center">UNIDAD</th>
                                                                        <th class="tex-center">MAT.</th>
                                                                        <th class="tex-center">AERONAVE</th>
                                                                        <th class="tex-center">BASE</th>
                                                                        <th class="tex-center">OV/OTA/OM</th>
                                                                        <th class="tex-center">ESTATUS</th>
                                                                        <th class="text-center">ACCIONES</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($data as $datamision)
                                                                        <tr>
                                                                            @role('aviacion_dao|administrador|cmd_general')
                                                                            <td  class="font-weight-normal text-center">{{$datamision->codigos}}</td>
                                                                            @endrole
                                                                            <td class="font-weight-normal text-center">{{$datamision->matricula}}</td>
                                                                            <td  class="font-weight-normal text-center">{{$datamision->aeronaves->aeronave}}</td>
                                                                            <td class="font-weight-normal text-center">
                                                                                {{$datamision->base_estacion}}
                                                                            </td>
                                                                            <td  class="font-weight-normal text-center"> {{$datamision->ov_ota_om}} </td>
                                                                            <td class="font-weight-normal">
                                                                                @if($datamision->completado == 'revisado')
                                                                                    <label class="badge bg-gradient-info status-programacion-ceo">REVISADO</label>
                                                                                @elseif ($datamision->completado == 'enviado')
                                                                                    <label class="badge bg-gradient-primary status-programacion-ceo">ENVIADO</label>
                                                                                @endif
                                                                            </td>
                                                                            <td class="font-weight-normal text-center">
                                                                                @role('aviacion_dao|administrador|cmd_general')
                                                                                <a href="{{route('dao.editProgramacion', $datamision->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Revisar">
                                                                                    <i class="fas fa-eye text-info" aria-hidden="true"></i> Revisar
                                                                                </a>
                                                                                @endrole
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <button id="enviarReporteCeo" disabled class="btn btn-info" value="">Enviar y Generar Reporte</button>
                        </div>
                    </div>
                </div>
            @endrole
            @role('aviacion_grupo_aereo')
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            @if ( $programacion == 0 )
                                <div class="card-body">
                                    <table style="margin: 0 auto;">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;"><h3>Sin Programación de Vuelo</h3></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            @elseif ( $programacion == 1 )
                                <div class="card-body">
                                    <table id="vuelos" class="table table-sm table-bordered table-hover table-striped dt-responsive w-100 nowrap" data-order='[[2, "asc"]]'>
                                        <thead>
                                            <tr>
                                                <th class="text-center">MAT.</th>
                                                <th class="text-center">AERONAVE</th>
                                                <th class="text-center">BASE</th>
                                                <th class="text-center">OV/OTA/OM</th>
                                                <th class="text-center">ALERTA</th>
                                                <th class="text-center">ESTATUS</th>
                                                <th class="text-center">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fam0001 as $data)
                                                <tr>
                                                    <td class="font-weight-normal text-center">{{$data->matricula}}</td>
                                                    <td  class="font-weight-normal text-center">{{$data->aeronaves->aeronave}}</td>
                                                    <td class="font-weight-normal text-center">
                                                        {{$data->base_estacion}}
                                                    </td>
                                                    <td  class="font-weight-normal text-center">{{$data->ov_ota_om}}</td>
                                                    <td  class="font-weight-normal text-center text-center">
                                                        @if ($data->alerta == 1)
                                                            <small>SI</small>
                                                        @else
                                                            <small>NO</small>
                                                        @endif
                                                    </td>
                                                    <td class="font-weight-normal">
                                                        @if($data->completado == 'programando')
                                                            <label class="badge bg-gradient-danger status-programacion">PROGRAMANDO</label>
                                                        @elseif ($data->completado == 'enviado')
                                                            <label class="badge bg-gradient-primary status-programacion">ENVIADO</label>
                                                        @elseif ($data->completado == 'actualizado')
                                                            <label class="badge bg-gradient-info status-programacion">ACTUALIZADO</label>
                                                        @elseif ($data->completado == 'revisado')
                                                            <label class="badge bg-gradient-success status-programacion">REVISADO</label>
                                                        @endif
                                                    </td>
                                                    <td class="font-weight-normal text-center">
                                                        @role('aviacion_grupo_aereo|administrador')
                                                        <a href="{{route('dao.editProgramacion', $data->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar Vuelo">
                                                            <i class="fas fa-edit  text-primary" aria-hidden="true"></i> Editar
                                                        </a>
                                                        <a href="#" class="eliminarProgramacion mx-3" data-id="{{ $data->id }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Eliminar Vuelo">
                                                            <i class="fas fa-trash text-danger" aria-hidden="true"></i> Eliminar
                                                        </a>
                                                        @endrole
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                                <div style="text-align: center;">
                                    <button id="enviarProgramacionDao" disabled class="btn btn-info" value="{{ $unidad }}">Enviar Programación</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>

    $(document).ready(function() {

        $('table[name="table"]').DataTable({
            responsive: true
        });
        if (!$('#vuelos').hasClass('dataTable')) {
            $('#vuelos').DataTable({
                processing: true,
                //serverSide: true,
                responsive: true,
                pageLength: 25,
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
        }


        var fechaActual = new Date();
        var fechaManana = new Date(fechaActual.getTime() + 20 * 60 * 60 * 1000).toISOString().slice(0, 10);
        var fecha_inv = fechaManana.split('-').reverse().join('-');
        $('#fecha_cabecera').text(fecha_inv);


        // Comprobar si hay programacion sin enviar o actualizada
        var completadoReporteCeo = true;
        var existe = 0;
        $(".status-programacion-ceo").each(function() {
            existe = 1;
            if ($(this).text() === "ENVIADO") {
                $("#enviarReporteCeo").prop("disabled", true);
                completadoReporteCeo = false;
                return false;
            }
        });
        if (completadoReporteCeo) {
            $("#enviarReporteCeo").prop("disabled", false);
        }

        if (existe == 0) {
            $("#enviarReporteCeo").prop("disabled", true);
        }


        // Comprobar si hay programacion sin enviar o actualizada
        var completadoEnviado = true;
        $(".status-programacion").each(function() {
            if ($(this).text() === "PROGRAMANDO") {
                $("#enviarProgramacionDao").prop("disabled", false);
                completadoEnviado = false;
                return false;
            }
            if ($(this).text() === "ACTUALIZADO") {
                $("#enviarProgramacionDao").prop("disabled", false);
                completadoEnviado = false;
                return false;
            }
        });
        if (completadoEnviado) {
            $("#enviarProgramacionDao").prop("disabled", true);
        }



        //FORMULARIO GUARDAR
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //PASO #1 - Enviar Programacion a la DAO
        $("#enviarProgramacionDao").click(function(e) {
            e.preventDefault();
            var unidad = $("#enviarProgramacionDao").val();

            //VALIDAR PASO UNO HEADER
            if (unidad === "") {
                Swal.fire({
                    title: 'Atención!',
                    text: 'Debes Tener un usuario para la unidad.',
                    icon: 'warning',
                    timer: 3000,
                    showConfirmButton: true,
                });
                console.log('no puedes guardar datos vacios')
            } else {
                //ENVIAR

                $.ajax({
                    url: "{{ route('enviarProgramacionDao') }}",
                    method: 'POST',
                    data: {
                        unidad: unidad,
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response)

                            Swal.fire({
                                title: 'Programación Enviada con éxito!',
                                text: 'Se Creo Correctamente.',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });

                            window.location.href = "{{URL::to('/dao/ver-programacion')}}";
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        });

        $("#enviarReporteCeo").click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('enviarReporteCeo') }}",
                method: 'POST',
                data: {
                    fecha: fechaManana
                },
                success: function(response) {
                    if (response.success) {
                        console.log(response)

                        Swal.fire({
                            title: 'Programación Enviada con éxito!',
                            text: 'Se Creo Correctamente.',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });

                        window.location.href = "{{URL::to('/dao/ver-programacion')}}";
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        });


        $('#vuelos').on('click', '.eliminarProgramacion', function(e) {
            e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

            var fam_id = $(this).data('id');

            Swal.fire({
                title: '¿Estas Seguro de eliminar esta programación?',
                text: "¡Atención.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).prop('disabled', true);

                    $.ajax({
                        url: "{{ route('dao.deleteProgramacion') }}",
                        method: 'POST',
                        data: {
                            fam_id: fam_id
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log(response)

                                Swal.fire({
                                    title: 'Programación Eliminada con éxito!',
                                    text: 'Se Creo Correctamente.',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });

                                window.location.href = "{{URL::to('/dao/ver-programacion')}}";
                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });

                }
            });
        });

        //PASO #5 - GUARDAR SIN PROGRAMACION
        $("#enviarSinProgramacion").click(function(e) {
                e.preventDefault();
                var unidad = $('#unidadEnv').val();

                Swal.fire({
                title: '¿Estas Seguro de no enviar programación?',
                text: "¡Atención.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).prop('disabled', true);
                        //ENVIAR
                        $.ajax({
                            url: "{{ route('store_programacion') }}",
                            method: 'POST',
                            data: {
                                ov_ota_om: '',
                                componente_organismo: '',
                                unidad: unidad,
                                aeronave_modelo: 9999,
                                serial: '',
                                matricula: '',
                                base_estacion: '',
                                completado: "sinProg",
                                matriculas_alternas: '',
                                alerta: 0
                            },
                            success: function(response) {
                                if (response.success) {
                                    console.log(response)

                                    //ENVIAR
                                    $.ajax({
                                    url:"{{ route('store_a1_sinProgramacion') }}",
                                    method:'POST',
                                    data:{
                                        unidad: unidad,
                                        ov_ota_om: '',
                                        fam0001_id: response.data.id,
                                        completado: "sinProg",
                                        fecha: fechaManana,
                                        },
                                        success:function(response){
                                            if(response.success){

                                                Swal.fire({
                                                    title: '¡Sin Programación!',
                                                    text: 'Se ha reportado sin programación de vuelo.',
                                                    icon: 'warning',
                                                    timer: 3000,
                                                    showConfirmButton: true,
                                                });

                                                setTimeout(function () {
                                                    window.location = "{{ route('dao.ver_programacion') }}"
                                                }, 2000);

                                            }
                                        },
                                        error:function(error){
                                            console.log(error)
                                        }
                                    });

                                }
                            },
                            error: function(error) {
                                console.log(error)
                            }
                        });
                    }
                });


            });

    });

</script>
@endsection
