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
                        <h5 class="mb-0">Personal A Graduarse por Categoria</h5>
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
                                                Oficiales de Comando
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_1" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="comando">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
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
                                                                <th>Nuevo Tipo Empleado</th>
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
                                                Oficiales Técnicos Medicina 
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_2" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tecnico">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
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
                                                                <th>Nuevo Tipo Empleado</th>
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
                                                Oficiales Técnicos de Salud
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_3" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tecnico">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
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
                                                                <th>Nuevo Tipo Empleado</th>
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
                                                Oficiales Técnicos
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_4" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tecnico">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
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
                                                                <th>Nuevo Tipo Empleado</th>
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
                                                Oficiales de Tropa
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_5" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="tropa">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
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
                                                                <th>Nuevo Tipo Empleado</th>
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
                                                Oficiales Asimilados
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_6" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="asimilado">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
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
                                                                <th>Nuevo Tipo Empleado</th>
                                                                <th>Grado a Ascender</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSeven">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                                Tropa Profesional
                                            </button>
                                        </h2>
                                        <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <form name="graduar"  id="graduar_7" class="form-graduar"
                                                    method="post" action="{{route('sireh.personal-militar-noprof.graduar')}}" 
                                                    >
                                                    @csrf
                                                    <div class="row align-items-center">
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_ascenso">Fecha de Ascenso: <small></small></h6>
                                                                <input name="fecha_ascenso" id="fecha_ascenso" type="date" class="form-control" required value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="numero_resuelto">Numero de Resuelto:</h6>
                                                                <input type="text" class="form-control" name="numero_resuelto" id="numero_resuelto" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <h6 for="fecha_resuelto">Fecha de Resuelto: <small></small></h6>
                                                                <input name="fecha_resuelto" id="fecha_resuelto" type="date" class="form-control fecha" required value="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="categoria" value="trop_prof">
                                                        <div class="col-3 text-center">
                                                            <button type="button" class="btn btn-primary btn-sm btn-graduar">Graduar</button>
                                                        </div>
                                                        <input type="hidden" id="tabla" value="7">
                                                    </div>
                                                    <table id="table7" class="table table-sm table-bordered table-hover w-100 nowrap" >
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Cedula</th>
                                                                <th>Jerarquia</th>
                                                                <th>Nombres y Apellidos </th>
                                                                <th>Nuevo Tipo Empleado</th>
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

    $(document).ready(function() {
        

        var table1 = $('#table1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('sireh.militar-noprof.graduacion.dataOficialesComando') }}",
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
                    return `MIL`; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    return `TE`; 
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
            ajax: "{{ route('sireh.militar-noprof.graduacion.dataOficialesTecnicosMedicina') }}",
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
                    return `MIL`; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    return `TE`; 
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
            ajax: "{{ route('sireh.militar-noprof.graduacion.dataOficialesTecnicosSalud') }}",
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
                    return `MIL`; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    return `TE`; 
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
            ajax: "{{ route('sireh.militar-noprof.graduacion.dataOficialesTecnicos') }}",
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
                    return `MIL`; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    return `TE`; 
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
            ajax: "{{ route('sireh.militar-noprof.graduacion.dataOficialesTropa') }}",
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
                    return `MIL`; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    return `TE`; 
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
            ajax: "{{ route('sireh.militar-noprof.graduacion.dataOficialesAsimilados') }}",
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
                    return `MIL`; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    return `TE`; 
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

        var table7 = $('#table7').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('sireh.militar-noprof.graduacion.dataOficialesTropaProfesional') }}",
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
                    return `MIL`; 
                    }
                },
                {data: null, render: function ( data, type, row ) {
                    return `TE`; 
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

        $('.btn-graduar').on('click', function(e){
            e.preventDefault();
            var fd = new FormData();
            var form = $(this).parents('form:first');
            var numThis =$("#tabla",form).val();
            var rows_selected = $( eval('table'+$("#tabla",form).val()).$('input[type="checkbox"]').map(function () {
                return $(this).prop("checked") ? eval('table'+$("#tabla",form).val()).row($(this).closest('tr')).data() : null;
            } ) );
            console.log(rows_selected, rows_selected.length)
            if ( rows_selected.length > 0 ){
                var validator= form.validate({
                    rules: {
                        fecha_ascenso : {
                            required: true,
                        },
                        numero_resuelto : {
                            required: true,
                        },
                        fecha_resuelto : {
                            required: true,
                        },
                    },
                    messages : {
                        fecha_resuelto: {
                            required: "Fecha de Ascenso es requerida"
                        },
                        numero_resuelto: {
                            required: "Numero de Resuelto es requerido"
                        },
                        fecha_resuelto: {
                            required: "Fecha de Resuelto es requerida"
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
                        url:'{{ route("sireh.personal-militar-noprof.graduar") }}',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success:function(res){

                            console.log(res);
                            $("#fecha_ascenso",form).val('');
                            $("#fecha_resuelto",form).val('');
                            $("#numero_resuelto",form).val('');
                            $('#table'+numThis).DataTable().ajax.reload(); 
                            Swal.fire({
                                title: 'Graduacion!',
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
                        text: 'Debe seleccionar un Graduando.',
                        icon: 'info',
                        timer: 5000,
                        showConfirmButton: true,
                    }
                );   
            }
        });

      
    });
</script>
@endsection