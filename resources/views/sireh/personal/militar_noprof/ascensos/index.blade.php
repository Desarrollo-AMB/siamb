@extends('layouts.user_type.auth')
@section('title', 'Personal Militar No Profesional')
@section('content')
@push('plugins-css')
<link href="{{ asset('vendor/datatables/dataTables.checkboxes.css') }}" rel="stylesheet">
<style>
    label.error {
        color: red;
        font-size: 1rem;
        display: block;
        margin-top: 5px;
    }

    input.error {
        border: 1px dashed red;
        font-weight: 300;
        color: red;
    }
</style>
@endpush
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
                        <h5 class="mb-0">Personal a Ascender</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card-body">
                            <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                De Alferez de 5to Año a Alferez de 6to Año Medicina
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="ascender"  id="ascender_1" class="form-ascender"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.ascender')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                       
                                                        <input type="hidden" name="ascenso" value="A6">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-ascender">Ascender</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="1">
                                                    </div>
                                                    <table id="table1" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                De Alferez de 4to Año a Alferez de 5to Año Medicina 
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="ascender"  id="ascender_2" class="form-ascender"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.ascender')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="ascenso" value="A5">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-ascender">Ascender</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="2">
                                                    </div>
                                                    <table id="table2" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                De Alferez de 4to Año a Alferez de 5to Año de Ciencias de la Salud
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="ascender"  id="ascender_3" class="form-ascender"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.ascender')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="ascenso" value="5T">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-ascender">Ascender</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="3">
                                                    </div>
                                                    <table id="table3" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                De Cadete de 3er Año a Alferez
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="ascender"  id="ascender_4" class="form-ascender"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.ascender')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="ascenso" value="AL">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-ascender">Ascender</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="4">
                                                    </div>
                                                    <table id="table4" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingFive">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                                De Cadete de 2do Año a Cadete de 3er Año
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="ascender"  id="ascender_5" class="form-ascender"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.ascender')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="ascenso" value="C3">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-ascender">Ascender</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="5">
                                                    </div>
                                                    <table id="table5" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSix">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                                De Cadete de 1er Año a Cadete de 2do Año
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="ascender"  id="ascender_6" class="form-ascender"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.ascender')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="ascenso" value="C2">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-ascender">Ascender</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="6">
                                                    </div>
                                                    <table id="table6" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugins-js')
    <script src="{{ asset('vendor/datatables/dataTables.checkboxes.min.js') }}" ></script> 
@endpush
@section('scripts')
@parent
<script>
    var gradosData= [];
    $(window).on('load', function() {
        
    });
    $(document).ready(function() {
        grados();
        var table1 = $('#table1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('api.sireh.militar-noprof.ascensos.dataAlferez6toMedicina') }}",
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }
            ],
            select: {
                style: 'multi'
            },
            columns: [
                {
                    data: 'codigo_empleado',
                    orderable: false, searchable: false,
                },
                {data: 'cedula',},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: null, render: function ( data, type, row ) {
                    return data.nombre1 +' '+data.nombre2 +', '+data.apellido1; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    var grado=buscarGrado('A6');
                    return grado.descripcion; 
                    }
                },
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

        var table2 = $('#table2').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('api.sireh.militar-noprof.ascensos.dataAlferez5toMedicina') }}",
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }
            ],
            select: {
                style: 'multi'
            },
            columns: [
                {
                    data: 'codigo_empleado',
                    orderable: false, searchable: false,
                },
                {data: 'cedula',},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: null, render: function ( data, type, row ) {
                    return data.nombre1 +' '+data.nombre2 +', '+data.apellido1; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    var grado=buscarGrado('A5');
                    return grado.descripcion; 
                    }
                },
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

        var table3 = $('#table3').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('api.sireh.militar-noprof.ascensos.dataAlferez5toSalud') }}",
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }
            ],
            select: {
                style: 'multi'
            },
            columns: [
                {
                    data: 'codigo_empleado',
                    orderable: false, searchable: false,
                },
                {data: 'cedula',},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: null, render: function ( data, type, row ) {
                    return data.nombre1 +' '+data.nombre2 +', '+data.apellido1; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    var grado=buscarGrado('5T');
                    return grado.descripcion; 
                    }
                },
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

        var table4 = $('#table4').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('api.sireh.militar-noprof.ascensos.dataAlferez') }}",
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }
            ],
            select: {
                style: 'multi'
            },
            columns: [
                {
                    data: 'codigo_empleado',
                    orderable: false, searchable: false,
                },
                {data: 'cedula',},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: null, render: function ( data, type, row ) {
                    return data.nombre1 +' '+data.nombre2 +', '+data.apellido1; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    var grado=buscarGrado('AL');
                    return grado.descripcion;  
                    }
                },
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

        var table5 = $('#table5').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('api.sireh.militar-noprof.ascensos.dataCadete3er') }}",
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }
            ],
            select: {
                style: 'multi'
            },
            columns: [
                {
                    data: 'codigo_empleado',
                    orderable: false, searchable: false,
                },
                {data: 'cedula',},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: null, render: function ( data, type, row ) {
                    return data.nombre1 +' '+data.nombre2 +', '+data.apellido1; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    var grado=buscarGrado('C3');
                    return grado.descripcion; 
                    }
                },
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

        var table6 = $('#table6').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('api.sireh.militar-noprof.ascensos.dataCadete2do') }}",
            columnDefs: [
                {
                    targets: 0,
                    checkboxes: {
                        selectRow: true
                    }
                }
            ],
            select: {
                style: 'multi'
            },
            columns: [
                {
                    data: 'codigo_empleado',
                    orderable: false, searchable: false,
                },
                {data: 'cedula',},
                {data: 'grado_militar', name: 'grados_militares.descripcion'},
                {data: null, render: function ( data, type, row ) {
                    return data.nombre1 +' '+data.nombre2 +', '+data.apellido1; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    var grado=buscarGrado('C2');
                    return grado.descripcion;  
                    }
                },
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

        $('.btn-ascender').on('click', function(e){
            e.preventDefault();
            var fd = new FormData();
            var form = $(this).parents('form:first');
            var numThis =$("#tabla",form).val();
            var rows_selected = $( eval('table'+$("#tabla",form).val()).$('input[type="checkbox"]').map(function () {
                return $(this).prop("checked") ? eval('table'+$("#tabla",form).val()).row($(this).closest('tr')).data() : null;
            } ) );

            if ( rows_selected.length > 0 ){
                var validator= form.validate({
                    rules: {
                        fecha_ascenso : {
                            required: true,
                        },
                    },
                    messages : {
                        fecha_ascenso: {
                            required: "Fecha de Ascenso es requerida"
                        },
                    }
                });
                if(validator.form()){
                    var other_data = form.serializeArray();
                    ///Obtener inputs
                    $.each(other_data,function(key,input){
                        fd.append(input.name,input.value);
                    });

                    ///Obtener los checkeds
                    var ids_selected = new Array();
                    $.each(rows_selected,function(key,value){
                        ids_selected.push(value.codigo_empleado);
                    });
                    fd.append('ids',JSON.parse(JSON.stringify(ids_selected)));
                    //console.log(...fd);

                    $.ajax({
                        type:'POST',
                        url:'{{ route("sireh.personal-militar-noprof.ascender") }}',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success:function(res){
                            $("#fecha_ascenso",form).val('');
                           
                            $('#table'+numThis).DataTable().ajax.reload(); 
                            Swal.fire({
                                title: 'Ascensos!',
                                text: 'Proceso realizado satisfactoriamente...',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                        }
                    }); 
                }                
            }else {
                Swal.fire(
                    {
                        title: 'Información!',
                        text: 'Debe seleccionar como minimo un (1) Alferez o Cadete.',
                        icon: 'info',
                        timer: 5000,
                        showConfirmButton: true,
                    }
                );   
            }
        });      
    });

    function grados(){
        $.get('/api/grados-militares/MEF'  ,function(data) {
            $.each(data, function(fetch, grado){ 
                var objeto =   {
                    'codigo': grado.codigo_grado,
                    'siglas': grado.siglas,
                    'descripcion': grado.descripcion,
                };       
                gradosData.push(objeto);
            });
        }); 
    }

    function buscarGrado(nuevoGrado){
        var results = gradosData.filter(function (grados) { return grados.siglas == nuevoGrado; });
        var firstObj = (results.length > 0) ? results[0] : null;
        return firstObj;
    }
</script>
@endsection