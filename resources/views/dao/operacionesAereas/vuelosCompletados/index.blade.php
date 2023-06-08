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
                <div class="col-sm-2 mb-2 mb-sm-0">
                    <h5 class="mb-0">
                        <a class="btn btn-dark btn-block my-2" href="{{ route('dao.index') }}">
                            <i class="ti-arrow-left" aria-hidden="true"><title>Volver</title></i> &nbsp; Volver
                        </a>
                    </h5>
                </div>
                <div class="col-lg-12 col-sm-12 d-flex flex-row justify-content-between text-center">
                    <div class="col-lg-12 col-sm-12 d-flex flex-row justify-content-between mx-auto">
                        <h5 class="mb-0">Lista de Vuelos Realizados</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            {{-- @include('dao.operacionesAereas.vuelosCompletados._barra_auxiliar') --}}
            <hr class="horizontal dark my-0">
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
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$key}}" aria-expanded="false" aria-controls="flush-collapse{{$key}}" id="{{$key}}" data-table-id="table{{$key}}">
                                                        {{$key}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$key}}" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <table name="table" id="table{{$key}}" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">UNID.</th>
                                                                    <th class="text-center">FECHA.</th>
                                                                    <th class="text-center">MAT.</th>
                                                                    <th class="text-center">AERONAVE</th>
                                                                    <th class="text-center">BASE</th>
                                                                    <th class="text-center">OV/OTA/OM</th>
                                                                    <th class="text-center">ESTATUS</th>
                                                                    <th class="text-center">ACCIONES</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data as $datamision)
                                                                    <tr>
                                                                        @role('aviacion_dao|administrador|cmd_general')
                                                                        <td  class="font-weight-normal text-center">{{$datamision->unidad}}</td>
                                                                        @endrole
                                                                        <td  class="font-weight-normal text-center">{{ date('d/m/Y', strtotime($datamision->fecha)) }}</td>
                                                                        <td class="font-weight-normal text-center">{{$datamision->matricula}}</td>
                                                                        <td  class="font-weight-normal text-center">{{$datamision->aeronaves->aeronave}}</td>
                                                                        <td class="font-weight-normal text-center">
                                                                            {{$datamision->base_estacion}}
                                                                        </td>
                                                                        <td  class="font-weight-normal text-center">{{$datamision->ov_ota_om}}</td>
                                                                        <td class="font-weight-normal text-center">
                                                                            @if($datamision->completado == 'completado')
                                                                                <label class="badge bg-gradient-success">{{$datamision->completado}}</label>
                                                                            @endif
                                                                        </td>
                                                                        <td class="font-weight-normal text-center">
                                                                            @role('aviacion_dao|administrador|cmd_general')
                                                                            <a href="{{route('FormaFAM.status', $datamision->id)}}"     class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Ver Vuelo">
                                                                                <i class="fas fa-eye text-info" aria-hidden="true"></i>
                                                                            </a>
                                                                            @endrole
                                                                        </td>
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
                                                <th class="text-center">FECHA</th>
                                                <th class="text-center">MAT.</th>
                                                <th class="text-center">AERONAVE</th>
                                                <th class="text-center">BASE</th>
                                                <th class="text-center">OV/OTA/OM</th>
                                                <th class="text-center">ESTATUS</th>
                                                <th class="text-center">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fam0001 as $data)
                                                <tr>
                                                    <td  class="font-weight-normal text-center">{{ date('d/m/Y', strtotime($data->fecha)) }}</td>
                                                    <td class="font-weight-normal text-center">{{$data->matricula}}</td>
                                                    <td class="font-weight-normal text-center">{{$data->aeronaves->aeronave}}</td>
                                                    <td class="font-weight-normal text-center">
                                                        {{$data->base_estacion}}
                                                    </td>
                                                    <td  class="font-weight-normal text-center">{{$data->ov_ota_om}}</td>
                                                    <td class="font-weight-normal text-center">
                                                        @if($data->completado == 'completado')
                                                            <label class="badge bg-gradient-success">{{$data->completado}}</label>
                                                        @endif
                                                    </td>
                                                    <td class="font-weight-normal text-center">
                                                        @role('aviacion_grupo_aereo|administrador')
                                                        <a href="{{route('FormaFAM.status', $data->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Ver Vuelo">
                                                            <i class="fas fa-eye text-info" aria-hidden="true"></i>
                                                        </a>
                                                        @endrole
                                                    </td>
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
            processing: true,
            //serverSide: true,
            responsive: true,
            pageLength: 25,
            "order": [[8, "asc" ]],  // 0 representa la columna "matricula"
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

        var fechaActual = new Date().toISOString().slice(0, 10);
        var fecha_inv = fechaActual.split('-').reverse().join('-');
        $('#fecha_cabecera').text(fecha_inv);



        /*$('.accordion-button').on('click', function() {
            var idCollapse = $(this).attr('id'); // Obtener el valor del atributo data-bs-target
            alert(idCollapse); // Imprimir el valor en la consola

        });*/

        $(document).on('click', '.accordion-button', function() {
            var target = $(e.target);
            var tableId = $(this).data('table-id');
            var table = $('#' + tableId);

            if (!table.hasClass('dataTable')) {
                table.DataTable({
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
        });

    });

</script>
@endsection
