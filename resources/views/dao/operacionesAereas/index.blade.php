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
            @include('dao.operacionesAereas._barra_auxiliar')
            <hr class="horizontal dark my-0">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Operaciones Aéreas del día: <span id="fecha_cabecera" class="mb-0"></span></h5>
                    </div>
                </div>
            </div>
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
                                                <div id="flush-collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$key}}" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <table name="table" id="table{{$key}}" class="table table-sm table-bordered table-hover w-100 nowrap" >
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
                                                                            {{$datamision->base_estacion}}
                                                                        </th>
                                                                        <th  class="font-weight-normal">{{$datamision->ov_ota_om}}</th>
                                                                        <th  class="font-weight-normal">{{$datamision->fecha}}</th>
                                                                        <th class="font-weight-normal">
                                                                            @if($datamision->completado == 'completado')
                                                                                <label class="badge bg-gradient-success">{{$datamision->completado}}</label>
                                                                            @elseif ($datamision->completado == 'paso1')
                                                                                <label class="badge bg-gradient-warning">PENDIENTE</label>
                                                                            @elseif ($datamision->completado == 'paso2')
                                                                                <label class="badge bg-gradient-warning">PENDIENTE</label>
                                                                            @elseif ($datamision->completado == 'paso3')
                                                                                <label class="badge bg-gradient-warning">PENDIENTE</label>
                                                                            @elseif ($datamision->completado == 'paso4')
                                                                                <label class="badge bg-gradient-warning">PENDIENTE</label>
                                                                            @endif
                                                                        </th>
                                                                        <th class="font-weight-normal">
                                                                            @role('aviacion_dao|administrador')
                                                                            <a href="{{route('FormaFAM.status', $datamision->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Ver Vuelo">
                                                                                <i class="fas fa-eye text-secondary" aria-hidden="true"></i>
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
                                                        {{$data->base_estacion}}
                                                    </th>
                                                    <th  class="font-weight-normal">{{$data->ov_ota_om}}</th>
                                                    <th  class="font-weight-normal">{{$data->fecha}}</th>
                                                    <th class="font-weight-normal">
                                                        @if($data->completado == 'completado')
                                                            <label class="badge bg-gradient-success">{{$data->completado}}</label>
                                                        @elseif ($data->completado == 'paso1')
                                                            <label class="badge bg-gradient-warning">PENDIENTE</label>
                                                        @endif
                                                    </th>
                                                    <th class="font-weight-normal">
                                                        @role('aviacion_grupo_aereo|administrador')
                                                        <a href="{{route('FormaFAM.status', $data->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar Vuelo">
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
    $('#vuelos').DataTable({
        responsive: true
    });
}
$(document).ready(function() {
    $('#vuelos').DataTable({
        responsive: true
    });
}



    $(document).ready(function() {

        var fechaActual = new Date().toISOString().slice(0, 10);
        var fecha_inv = fechaActual.split('-').reverse().join('-');
        $('#fecha_cabecera').text(fecha_inv);



        /*$('.accordion-button').on('click', function() {
            var idCollapse = $(this).attr('id'); // Obtener el valor del atributo data-bs-target
            alert(idCollapse); // Imprimir el valor en la consola

        });*/

    });

</script>
@endsection
