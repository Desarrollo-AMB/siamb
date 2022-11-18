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
                    <div>
                        <h5 class="mb-0">Registros de Vuelo</h5>
                    </div>
                    <a class="btn btn-bg-gradient-primary btn-sm mb-0 new_fly_bt" href="{{ route('FormaFAM') }}">+&nbsp;Nuevo Vuelo</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="vuelos" class="table align-items-center mb-0 table-sm w-100 nowrap" data-order='[[2, "asc"]]'>
                                    <thead>
                                        <tr>
                                            <th>FECHA</th>
                                            <th>OV/OTA/OM</th>
                                            <th>AERONAVE</th>
                                            @role('administrador')
                                            <th>UNIDAD</th>
                                            @endrole 
                                            <th>BASE</th>
                                            <th>ESTATUS</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fam0001 as $data)
                                            <tr>
                                                <th  class="font-weight-normal">{{$data->fecha}}</th>
                                                <th  class="font-weight-normal">{{$data->ov_ota_om}}</th>
                                                <th  class="font-weight-normal">{{$data->aeronaves->aeronave}}</th>
                                                @role('administrador')
                                                <th  class="font-weight-normal">{{$data->unidad}}</th>
                                                @endrole  
                                                <th class="font-weight-normal">
                                                    {{$data->base->siglas}}
                                                </th>
                                                <th class="font-weight-normal">
                                                    @if($data->completado == 'completado') 
                                                        <label class="badge bg-gradient-success">{{$data->completado}}</label>
                                                    @else
                                                        <label class="badge bg-gradient-warning">PENDIENTE</label>       
                                                    @endif
                                                </th>
                                                <th class="font-weight-normal">
                                                    <a href="{{route('FormaFAM.status', $data->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar Vuelo">
                                                        <i class="fas fa-edit text-secondary" aria-hidden="true"></i>
                                                    </a>
                                                    @if($data->completado == 'completado') 
                                                        {{-- <a href="#"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Ver Vuelo">
                                                            <i class="fas fa-eye  text-info" aria-hidden="true"></i>
                                                        </a> --}}
                                                        <a href="#"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Imprimir">
                                                            <i class="fas fa-solid fa-file-pdf text" aria-hidden="true" style="color: #ff0000b3;"></i>
                                                        </a>
                                                    @endif
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
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