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
            <div class="card-header pb-0 mb-2 d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <div class="col-sm-2 mb-2 mb-sm-0">
                    <h5 class="mb-0">
                        <a class="btn btn-dark btn-block my-2" href="{{ route('dao.index') }}">
                            <i class="ti-arrow-left" aria-hidden="true"><title>Volver</title></i> &nbsp; Volver
                        </a>
                    </h5>
                </div>
                <div class="col-sm-4 text-center mb-2 mb-sm-0">
                    <h5 class="mb-0">Programación de vuelo del día: <span id="fecha_cabecera" class="mb-0"></span></h5>
                </div>
                <div class="col-sm-2 mb-2 mb-sm-0">
                    @role('aviacion_grupo_aereo|administrador')
                        @if ( $programacion == 0 )
                            <button class="btn btn-bg-gradient-primary btn-block my-2 new_fly_bt" href="{{ route('dao.nuevaProgramacion') }}" disabled>+&nbsp;Agregar Programación</button>
                            <a class="btn btn-bg-gradient-primary btn-block my-2 new_fly_bt" href="{{ route('dao.imprimirProgramacionGrupoAereo', ['unidad' => $unidad]) }}">+&nbsp;Descargar Programación</a>
                        @elseif ( $programacion == 1 )
                            <a class="btn btn-bg-gradient-primary btn-block my-2 new_fly_bt" href="{{ route('dao.nuevaProgramacion') }}">+&nbsp;Agregar Programación</a>
                            <a class="btn btn-bg-gradient-primary btn-block my-2 new_fly_bt" href="{{ route('dao.imprimirProgramacionGrupoAereo', ['unidad' => $unidad]) }}">+&nbsp;Descargar Programación</a>
                        @endif
                    @endrole
                    @role('aviacion_dao|administrador')
                    <a class="btn btn-bg-gradient-primary btn-block my-2 new_fly_bt" href="{{ route('dao.imprimirProgramacion') }}">+&nbsp;Descargar Programación</a>
                    @endrole
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
                                                                            <th  class="font-weight-normal">{{$datamision->codigos}}</th>
                                                                            @endrole
                                                                            <th class="font-weight-normal">{{$datamision->matricula}}</th>
                                                                            <th  class="font-weight-normal">{{$datamision->aeronaves->aeronave}}</th>
                                                                            <th class="font-weight-normal">
                                                                                {{$datamision->base_estacion}}
                                                                            </th>
                                                                            <th  class="font-weight-normal">{{$datamision->ov_ota_om}}</th>
                                                                            <th  class="font-weight-normal">{{$datamision->fecha}}</th>
                                                                            <th class="font-weight-normal">
                                                                                @if($datamision->completado == 'revisado')
                                                                                    <label class="badge bg-gradient-info status-programacion-ceo">REVISADO</label>
                                                                                @elseif ($datamision->completado == 'enviado')
                                                                                    <label class="badge bg-gradient-primary status-programacion-ceo">ENVIADO</label>
                                                                                @endif
                                                                            </th>
                                                                            <th class="font-weight-normal">
                                                                                @role('aviacion_dao|administrador')
                                                                                <a href="{{route('dao.editProgramacion', $datamision->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Revisar">
                                                                                    <i class="fas fa-edit text-secondary" aria-hidden="true"></i> Revisar
                                                                                </a>
                                                                                @endrole
                                                                            </th>
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
                                                        {{$data->base_estacion}}
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
                                                        @elseif ($data->completado == 'revisado')
                                                            <label class="badge bg-gradient-success status-programacion">REVISADO</label>
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
        responsive: true
    });
}
});

    $(document).ready(function() {


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

    });

</script>
@endsection
