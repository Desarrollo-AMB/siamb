@extends('layouts.user_type.auth')
@section('title', 'Personal Militar No Profesional')
@push('plugins-css')
<link href="{{ asset('vendor/datatables/select.dataTables.min.css') }}" rel="stylesheet">
@endpush
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
                        <h5 class="mb-0">Egreso de Alistados</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <form name="egresar"  id="egresar" class="form-egresar"
                                    method="post" action="" 
                                    >
                                    @csrf
                                    <div class="row align-items-center justify-content-end">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <h6 for="fecha_egreso">Fecha de Egreso: <small></small></h6>
                                                <input name="fecha_egreso" id="fecha_egreso" type="date" class="form-control" required value="">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <h6 for="resolucion">Nro. de Acta Temporanea:</h6>
                                                <input type="text" class="form-control" name="resolucion" id="resolucion" value="" required>
                                            </div>
                                        </div>
    
                                        <div class="col-2 text-center">
                                            <button type="button" class="btn btn-primary btn-sm btn-egresar">Egresar</button>
                                        </div>
                                        <input type="hidden" id="tabla" value="7">
                                    </div>
                                    <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap" data-order='[[1, "asc"]]'>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Contingente</th>
                                                <th>Cantidad de Alistados</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contingentes as $row)
                                            <tr>
                                                <td></td>
                                                <td>{{$row->contingente}}</td>
                                                <td>{{$row->total}}</td>
                                                <td> 
                                                    <a href="#" class="mx-3 view_egresar" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Ver" title="Ver" data-contingente="{{ $row->contingente }}">
                                                        <i class="fas fa-list-ul text-primary" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
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
{{-- Modal de militares a egresar --}}
<div class="modal fade" id="modal-view">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal">Militares A Egresar</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="egresos" class="table table-sm table-bordered table-hover w-100 nowrap">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombre </th>
                            <th>Apellido</th>
                            <th>Grado Militar</th>
                            <th>Ubicacion</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer justify-content-rigth">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button> 
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- /.modal --}}
@endsection
@push('plugins-js')
    <script src="{{ asset('vendor/datatables/dataTables.select.min.js') }}" ></script> 
@endpush
@section('scripts')
@parent
<script>
    $(function () {
        
        var table = $('#table').DataTable({
            responsive: true,
            pageLength: 10,
            search: {
                return: true,
            },
            columnDefs: [ 
                { targets:0, orderable: false, className: 'select-checkbox', } ,
                { targets:1, data: 'contingente', orderable: true },
                { targets:2, data: 'cantidad_alistados', orderable: true },
                { targets:3, orderable: false }
            ],
            select: {
                style:    'single',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]],
            language: {
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
    
        $('.btn-egresar').on('click', function(e){
            e.preventDefault();
            var fd = new FormData();
            var form = $(this).parents('form:first');
           
            var rows_selected = $(table.$('.selected').map(function () {
                //console.log(table.row($(this).closest('tr')).data());
                return table.row($(this).closest('tr')).data();
            } ) );
            //console.log(rows_selected, rows_selected.length)
            if ( rows_selected.length > 0 ){
                var validator= form.validate({
                    rules: {
                        fecha_egreso : {
                            required: true,
                        },
                        resolucion : {
                            required: true,
                        },
                    },
                    messages : {
                        fecha_egreso: {
                            required: "Fecha de Egreso es requerida"
                        },
                        resolucion: {
                            required: "Numero de Resuelto es requerido"
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
                    var contingente_selected = new Array();
                    $.each(rows_selected,function(key,value){
                        contingente_selected.push(value.contingente);
                    });
                    fd.append('contingente',JSON.parse(JSON.stringify(contingente_selected)));
                    
                    //console.log(...fd);

                    $.ajax({
                        type:'POST',
                        url:'{{ route("sireh.personal-militar-noprof.egresar-alistados") }}',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success:function(res){
                            console.log(res);
                          
                            Swal.fire({
                                title: 'Egreso de Alistados!',
                                text: 'Proceso realizado satisfactoriamente...',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            if(res.success){
                                window.location.reload();
                            }
                        }
                    }); 
                }               
            }else {
                Swal.fire(
                    {
                        title: 'Información!',
                        text: 'Debe seleccionar un (1) contingente.',
                        icon: 'info',
                        timer: 5000,
                        showConfirmButton: true,
                    }
                );   
            }
        });

        table.on('click', '.view_egresar', function() {
            var contingente = $(this).data("contingente");                    
            // I have tried this to draw datatable but this isn't working
            $('#modal-view').on('shown.bs.modal', function(e) {
                $('#modal-view #egresos tbody').empty();
                if ( $.fn.dataTable.isDataTable( '#modal-view #egresos' ) ) {
                    $('#modal-view #egresos').DataTable().destroy();
                }
                
                // this is my datatable id
                $('#modal-view #egresos').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: true,
                    pageLength: 10,
                    ajax:{
                        url : "{{ route('sireh.personal.militar-noprof.egresoContingente') }}",
                        type: "GET",
                        data: {"contingente": contingente}
                    },
                    columns: [
                        {data: 'cedula',},
                        {data: 'nombre1'},
                        {data: 'apellido1'},
                        {data: 'grado_militar', name: 'grados_militares.descripcion'},
                        {data: 'ubicacion', name: 'ubicaciones.descripcion', searchable: false},
                    ],
                    search: {
                        return: true,
                    },
                    order: [[ 0, 'asc' ]],
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
                }).ajax.reload();
            })
            $('#modal-view').modal("show");  // showing the modal after success fetch data
        });

        $("#modal-view").on("hidden.bs.modal", function () {
            console.log('Cerrando Modal');
            $('#egresos').DataTable().destroy();
            $('#egresos tbody').empty();
        });
    });
</script>
@endsection