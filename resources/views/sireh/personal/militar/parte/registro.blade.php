@extends('layouts.user_type.auth')
@section('title', 'Registro de Parte')
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
                        <h5 class="mb-0">Estatus</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <h5 class="mb-0">Unidades con Parte Registrado</h5>
                                <table id="ubicaciones-con-registro" class="table align-items-center mb-0 table-sm w-100 nowrap" >
                                    <thead>
                                        <tr>
                                            <th>Unidad</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ubicacionesConRegistro as $ubicacion)
                                            <tr>
                                                <td>{{ $ubicacion->descripcion }}</td>
                                                <td style="background-color: #21f31a; color: #fff; font-weight: bold; text-align: center; opacity: 0.6; box-shadow: 0px 0px 10px #000; transform: rotate(-360deg); width: 15px; height: 15px;">Parte registrado</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <h5 class="mb-0" style="margin: center">Unidades Sin Parte Registrado</h5>
                                <table id="ubicaciones-sin-registro" class="table align-items-center mb-0 table-sm w-100 nowrap" >
                                    <thead>
                                        <tr>
                                            <th>Código de ubicación</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ubicacionesSinRegistro as $ubicacion)
                                            <tr>
                                                <td>{{ $ubicacion->descripcion }}</td>

                                                <td style="background-color: #f3221a; color: #fff; font-weight: bold; text-align: center; opacity: 0.5; box-shadow: 0px 0px 10px #000; transform: rotate(-360deg); width: 15px; height: 15px;">No ha Registrado Parte</td>
                                            </tr>
                                        @endforeach
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
        $('#ubicaciones-con-registro,#ubicaciones-sin-registro').DataTable({
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
