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
            <hr class="horizontal dark my-0">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Parte de Aeronaves: <span id="fecha_cabecera" class="mb-0"></span></h5>
                    </div>
                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <table id="aeronaves" class="table align-items-center mb-0 table-sm w-100 nowrap" data-order='[[2, "asc"]]'>
                                    <thead>
                                        <tr>
                                            @role('aviacion_dao|administrador')
                                            <th>UNIDAD</th>
                                            @endrole
                                            <th>AERONAVE</th>
                                            <th>MATRICULA</th>
                                            <th>SERIAL</th>
                                            <th>ESTATUS</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aeronaves as $data)
                                            <tr>
                                                @role('aviacion_dao|administrador')
                                                <th  class="font-weight-normal">{{$data->codigo_unidad}}</th>
                                                @endrole
                                                <th  class="font-weight-normal">{{$data->aeronave}}</th>
                                                <th class="font-weight-normal">{{$data->matricula}}</th>
                                                <th class="font-weight-normal">{{$data->serial}}</th>
                                                <th class="font-weight-normal">
                                                    @if($data->estatus == 'DISPONIBLE')
                                                        <label class="badge bg-gradient-success">DISPONIBLE</label>
                                                    @elseif($data->estatus == 'DISPONIBLE PARA EL COMBATE')
                                                        <label class="badge bg-gradient-success">DISPONIBLE PARA EL COMBATE</label>
                                                    @elseif($data->estatus == 'INDISPONIBLE')
                                                        <label class="badge bg-gradient-warning">NO DISPONIBLE</label>
                                                    @elseif($data->estatus == 'SINIESTRADA')
                                                        <label class="badge bg-gradient-danger">SINIESTRADA</label>
                                                    @endif
                                                </th>
                                                <th class="font-weight-normal">
                                                    @role('aviacion_grupo_aereo|administrador|aviacion_dao')
                                                    <a href="{{route('dao.editDisponAeronaves', $data->id)}}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar disponibilidad">
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>

    $(document).ready(function() {
        var fechaActual = new Date().toISOString().slice(0, 10);
        var fecha_inv = fechaActual.split('-').reverse().join('-');
        $('#fecha_cabecera').text(fecha_inv);
    });

    $(function () {
        $('#aeronaves').DataTable({
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
