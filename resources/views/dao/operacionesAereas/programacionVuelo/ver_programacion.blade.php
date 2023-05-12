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
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div class="col-2">
                        <h5 class="mb-0">
                            <a class="btn-sm btn-dark btn-sm mb-0" href="{{ route('dao.index') }}">
                                <i class="ti-arrow-left" aria-hidden="true"><title>Volver</title></i> &nbsp; Volver
                            </a>
                        </h5>
                    </div>
                    <div class="col-4">
                        <h5 class="mb-0">Programación de vuelo del día: <span id="fecha_cabecera" class="mb-0"></span></h5>
                    </div>
                    <div class="col-2">
                        @role('aviacion_grupo_aereo|administrador')
                        <a class="btn btn-bg-gradient-primary btn-sm new_fly_bt" href="{{ route('dao.nuevaProgramacion') }}">+&nbsp;Agregar Programación</a>
                        @endrole
                        <a class="btn btn-bg-gradient-primary btn-sm new_fly_bt" href="{{ route('dao.nuevaProgramacion') }}">+&nbsp;Descargar Programación</a>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            @role('aviacion_dao|administrador')
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
                                                        <table id="table{{$key}}" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                            <thead>
                                                                <tr>
                                                                    <th>UNIDAD</th>
                                                                    <th>MATRICULA</th>
                                                                    <th>AERONAVE</th>
                                                                    <th>BASE</th>
                                                                    <th>OV/OTA/OM</th>
                                                                    <th>FECHA</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data as $datamision)
                                                                    <tr>
                                                                        @role('aviacion_dao|administrador')
                                                                        <th  class="font-weight-normal">{{$datamision->unidad}}</th>
                                                                        @endrole
                                                                        <th class="font-weight-normal">{{$datamision->matricula}}</th>
                                                                        <th  class="font-weight-normal">{{$datamision->aeronaves->aeronave}}</th>
                                                                        <th class="font-weight-normal">
                                                                            {{$datamision->base->siglas}}
                                                                        </th>
                                                                        <th  class="font-weight-normal">{{$datamision->ov_ota_om}}</th>
                                                                        <th  class="font-weight-normal">{{$datamision->fecha}}</th>
                                                                        <th class="font-weight-normal">
                                                                            @if($datamision->completado == 'actualizado')
                                                                                <label class="badge bg-gradient-info">{{$datamision->completado}}</label>
                                                                            @elseif ($datamision->completado == 'enviado')
                                                                                <label class="badge bg-gradient-primary">ENVIADO</label>
                                                                            @endif
                                                                        </th>
                                                                        <th class="font-weight-normal">
                                                                            @role('aviacion_dao|administrador')
                                                                            <a href="{{route('dao.editProgramacion', $datamision->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Ver Vuelo">
                                                                                <i class="fas fa-edit text-secondary" aria-hidden="true"></i>
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
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endrole
            @role('aviacion_grupo_aereo')
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                                <div class="card-body">
                                    <table id="vuelos" class="table align-items-center mb-0 table-sm w-100 nowrap" data-order='[[2, "asc"]]'>
                                        <thead>
                                            <tr>
                                                <th>MATRICULA</th>
                                                <th>AERONAVE</th>
                                                <th>BASE</th>
                                                <th>OV/OTA/OM</th>
                                                <th>FECHA</th>
                                                <th>ESTATUS</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fam0001 as $data)
                                                <tr>
                                                    <th class="font-weight-normal">{{$data->matricula}}</th>
                                                    <th  class="font-weight-normal">{{$data->aeronaves->aeronave}}</th>
                                                    <th class="font-weight-normal">
                                                        {{$data->base->siglas}}
                                                    </th>
                                                    <th  class="font-weight-normal">{{$data->ov_ota_om}}</th>
                                                    <th  class="font-weight-normal">{{$data->fecha}}</th>
                                                    <th class="font-weight-normal">
                                                        @if($data->completado == 'programando')
                                                            <label class="badge bg-gradient-danger status-programacion">PROGRAMANDO</label>
                                                        @elseif ($data->completado == 'enviado')
                                                            <label class="badge bg-gradient-primary status-programacion">ENVIADO</label>
                                                        @elseif ($data->completado == 'actualizado')
                                                            <label class="badge bg-gradient-info status-programacion">ACTUALIZADO</label>
                                                        @endif
                                                    </th>
                                                    <th class="font-weight-normal">
                                                        @role('aviacion_grupo_aereo|administrador')
                                                        <a href="{{route('dao.editProgramacion', $data->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar Vuelo">
                                                            <i class="fas fa-edit text-secondary" aria-hidden="true"></i>
                                                        </a>
                                                        @endrole
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align: center;">
                                    <button id="enviarProgramacionDao" class="btn btn-info" value="{{ $unidad }}">Enviar Programación</button>
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
        var fechaActual = new Date();
        var fechaManana = new Date(fechaActual.getTime() + 24 * 60 * 60 * 1000).toISOString().slice(0, 10);
        var fecha_inv = fechaManana.split('-').reverse().join('-');
        $('#fecha_cabecera').text(fecha_inv);


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
            if ($(this).text() !== "ENVIADO") {
                completadoEnviado = false;
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
                        fecha: fechaManana,
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

    });

    $(function () {
        $('#vuelos').DataTable({
            processing: true,
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

    });
</script>
@endsection
