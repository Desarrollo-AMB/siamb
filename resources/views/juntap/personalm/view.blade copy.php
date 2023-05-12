@extends('layouts.user_type.auth')
@section('title', 'Bienestar Social')
@section('content')

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
                            <h5 class="mb-0">Carga Familiar</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ URL::previous() }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
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
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">{{ $datos->cedula }} - {{$datos->nombre1 .' '. $datos->nombre2.', '. $datos->apellido1.' '.$datos->apellido2}}</h5>
                                </div>
                                <div class="card-body datos">
                                    <div class="row">  
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Tipo Empleado:</h6>
                                                <select class="select2 form-control" name="tipo_emp" id="tipo_emp" disabled>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($tipos_emp as $row)
                                                        <option value="{{$row->tipo_emp}}" {{$datos->nomina->tipo_emp == $row->tipo_emp? 'selected': '' }}>{{ $row->descripcion }} ({{ $row->tipo_emp}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="div-militar">
                                            <div class="form-group">
                                                <h6>Grado Militar:</h6>
                                                <select class="select2 form-control" name="grado_militar" id="grado_militar" >
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($grados_militares as $row)
                                                        <option value="{{$row->codigo_grado}}" {{$datos->nomina->grado_militar == $row->codigo_grado ?  'selected': '' }}>{{ $row->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>     
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado Civil:</h6>
                                                <select class="select2 form-control registrar" name="edo_civil" id="edo_civil" >
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($edos_civil as $key=>$value)
                                                        <option value="{{$key}}" {{$datos->edo_civil == $key ? 'selected': '' }}>{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha Ingreso: <small></small></h6>
                                                <input name="fecha_ingreso"  id="fecha_ingreso" type="date" class="form-control fecha" 
                                                value="{{ $datos->nomina->fecha_ingreso }}"
                                                >
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="form-group">
                                                <h6>Ubicación:</h6>
                                                <select class="select2 form-control registrar" name="ubicacion" id="ubicacion" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($ubicaciones as $row)
                                                        <option value="{{$row->codigo_ubicacion}}" {{$datos->nomina->codigo_ubicacion == $row->codigo_ubicacion? 'selected' : '' }}>{{ $row->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 cargo">
                                            <div class="form-group">
                                                <h6>Cargo:</h6>
                                                <select class="select2 form-control" name="cargo" id="cargo">
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($cargos as $row)
                                                        <option value="{{$row->codigo_cargo}}" {{$datos->nomina->codigo_cargo == $row->codigo_cargo ?  'selected': '' }}>{{ $row->nombre_cargo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    
                                   
                                    <div class="d-flex flex-row justify-content-between">
                                        <div></div>
                                        <div>
                                            <h5 class="card-title">FAMILIARES</h5>
                                        </div>
                                        <boton class="btn btn-success btn-sm mb-0" id="btn-nuevo"><i class="fas fa-plus" aria-hidden="true"></i> Agregar</boton>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="table" class="table table-sm table-bordered table-hover w-100 nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombres y Apellidos </th>
                                                <th>Cedula</th>
                                                <th>Fecha Nac.</th>
                                                <th>Edad</th>
                                                <th>Sexo</th>
                                                <th>Parentesco</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    
                                    <div class="row">    
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ">
                                            
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 ">
                                           
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 ">
                                            
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
    {{-- Modal para carga familiar --}}
    <div class="modal fade" id="modal-carga">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form>
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal">Agregar Carga Familiar</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="id_empleado" id="id_empleado" type="hidden" value="">   
                    <input name="id" id="id" type="hidden" value="">             
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Parentesco:</h6>
                                <select class="select2 form-control" name="parentesco" id="parentesco" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach ($parentescos as $key=>$value)
                                        <option value="{{$key}}">{{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Cédula:</h6>
                                <input id="cedula_familiar"  type="text" class="form-control" name="cedula_familiar" 
                                    value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Primer Nombre:</h6>
                                <input id="nombre1"  type="text" class="form-control" name="nombre1" 
                                    value="">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Segundo Nombre:</h6>
                                <input id="nombre2"  type="text" class="form-control" name="nombre2" 
                                    value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Primer Apellido:</h6>
                                <input id="apellido1"  type="text" class="form-control" name="apellido1" 
                                    value="">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Segundo Apellido:</h6>
                                <input id="apellido2"  type="text" class="form-control" name="apellido2" 
                                    value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Fecha Nacimiento: <small></small></h6>
                                <input name="fecha_nacimiento" id="fecha_nacimiento" type="date" class="form-control fecha" required value="">
                            </div>
                        </div>  
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Sexo:</h6>
                                <select class="select2 form-control" name="genero" id="genero" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach ($generos as $key=>$value)
                                        <option value="{{$key}}" {{$datos->sexo == $key? 'selected': '' }}>{{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Nivel Instrucción:</h6>
                                <select class="select2 form-control" name="nivel" id="nivel" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach ($niveles as $row)
                                        <option value="{{$row->codigo}}" data-nivel="{{$row->nivel_instruccion}}">{{ $row->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <h6>Discapacidad:</h6>
                                <select class="select2 form-control" name="discapacidad" id="discapacidad" required>
                                    <option value="">Seleccione ...</option>
                                    <option value="NINGUNA">NINGUNA</option>
                                    <option value="MOTORA">MOTORA</option>
                                    <option value="VISUAL">VISUAL</option>
                                    <option value="AUDITIVA">AUDITIVA</option>
                                </select>
                            </div>
                        </div> 

                    </div>
                </div>
                <div class="modal-footer justify-content-rigth">
                    <button type="button" class="btn btn-primary" id="btn-guardar">Guardar</button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cerrar</button> 
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- /.modal --}}
@endsection

@section('scripts')
<script>
    var parentescos = @json($parentescos);
    var generos = Object.values(@json($generos));
   
    $(function (){
        var valor=buscarParentesco('P');
     
        
        $('.nivel_instruccion').hide();
        $('.obrero').hide();
        $('.cargo').hide();
        $(".datos input").prop( "disabled", true );
        $("select.registrar").prop( "disabled", true );
        $("#btn-registrar").prop( "disabled", true );

        //////////////////////////////////
        $('.select2').select2();

        inicializar();
        var codigo_empleado = "{{ $datos->codigo_empleado }}";  
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax:{
                        url : "{{ route('api.sireh.carga-familiar.data') }}",
                        type: "GET",
                        data: {"codigo_empleado": codigo_empleado}
                    },
            columns: [
                {data: 'numero_familiar',},
                {data: null,
                    render: function ( data, type, row, meta ) {
                        return row.nombre1 + ' ' + row.apellido1;  
                    }
                },
                {data: 'cedula_familiar', },
                {data: 'fecha_nacimiento'},
                {data: null,  render: function ( data, type, row ) {
                    var respuesta=calcularEdad(row.fecha_nacimiento);
                    return respuesta;  
                    }},
                {data: 'sexo'},
                {data: 'parentesco', render: function ( data, type, row ) {
                    var respuesta=buscarParentesco(row.parentesco);
                    return respuesta;  
                    }
                },
                {data: 'actions', name: 'action', orderable: false, searchable: false},
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

        $('#btn-nuevo').on('click', function() {
           
            $('#modal-carga').on('shown.bs.modal', function(e) {
                $('#modal-carga #title-modal').text('Agregar');
                $('#modal-carga #id_empleado').val(codigo_empleado);
                $('#modal-carga #id').val('');
                limpiarModal();
                
            })
            $('#modal-carga').modal("show");  
        });

        table.on('click', '.editar', function() {
           
            var id = $(this).data("id");
            var url = '{{ route("sireh.carga-familiar.edit", ":id") }}';
            url = url.replace(':id',id);
            $.ajax({
                type:'GET',
                url: url,
                processData: false,
                contentType: false,
                success:function(res){
                    $('#modal-carga').on('shown.bs.modal', function(e) {
                        $('#modal-carga #title-modal').text('Editar');
                        limpiarModal();
                        $('#modal-carga #id_empleado').val(codigo_empleado);
                        $('#modal-carga #id').val(id);
                        $('#modal-carga #parentesco').val(res.parentesco).trigger('change');
                        $('#modal-carga #genero').val(res.sexo).trigger('change');
                        $('#modal-carga #nivel').val(res.nivel_instruccion).trigger('change');
                        $('#modal-carga #discapacidad').val(res.discapacidad).trigger('change');
                        $('#modal-carga #cedula_familiar').val(res.cedula_familiar);
                        $('#modal-carga #nombre1').val(res.nombre1);
                        $('#modal-carga #nombre2').val(res.nombre2);
                        $('#modal-carga #apellido1').val(res.apellido1);
                        $('#modal-carga #apellido2').val(res.apellido2);
                        $('#modal-carga #fecha_nacimiento').val(res.fecha_nacimiento);
                    })
                    $('#modal-carga').modal("show");  
                }
            });
        });

        $('#table').on('click', '.confirm-delete' ,function (e) { 
            e.preventDefault(); 
            var url =$(this).data('target') ;
            Swal.fire({
                title: 'Eliminar Carga Familiar',
                text: "Esta seguro???",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => { 
                if(result.isConfirmed){
                    $.ajax({ 
                        url: url, 
                        type: 'DELETE', 
                        dataType: 'json', 
                        data: {method: '_DELETE'}, 
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} 
                    }).done(function (data) { 
                        $('#table').DataTable().ajax.reload(); 
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'caraga Familiar eliminada satisfactoriamente',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                    }); 
                }
            });
        });

        $('#btn-guardar').on('click', function(){
            var fd = new FormData();
            var form = $(this).parents('form:first');
            var validator= form.validate({
                rules: {
                    parentesco : {
                        required: true,
                    },
                },
                messages : {
                    parentesco: {
                        required: "El Parentesco es requerido"
                    },
                }
            });
            if(validator.form()){
                var other_data = form.serializeArray();
                ///Obtener inputs
                $.each(other_data,function(key,input){
                    fd.append(input.name,input.value);
                });

                $.ajax({
                    type:'POST',
                    url:'{{ route("sireh.cargar-familiar.store") }}',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success:function(res){                        
                        Swal.fire({
                            title: 'Carga Familiar!',
                            text: 'Familiar agregado satisfactoriamente...',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                        if(res.success){
                            table.ajax.reload();
                            $('#modal-carga').modal("hide");  
                        }
                    }
                }); 
            }
        });
    });

    function limpiarModal(){
        $('#modal-carga').on('hidden.bs.modal', function(){ 
            $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
            $("label.error").remove();  //lo utilice para borrar la etiqueta de error del jquery validate
        });
        $('#modal-carga #id').val('');
        $('#modal-carga #parentesco').val('').trigger('change');
        $('#modal-carga #genero').val('').trigger('change');
        $('#modal-carga #nivel').val('').trigger('change');
        $('#modal-carga #discapacidad').val('').trigger('change');
        $('#modal-carga #cedula_familiar').val('');
        $('#modal-carga #nombre1').val('');
        $('#modal-carga #nombre2').val('');
        $('#modal-carga #apellido1').val('');
        $('#modal-carga #fecha_nacimiento').val('');
    } 

    function inicializar(){
        var tipo_emp = $('#tipo_emp').val();
        var nivel_instruccion = $('#nivel').find(':selected').attr('data-nivel');
        if (tipo_emp == 'MEF' || tipo_emp == 'ALI' || tipo_emp == 'MIL' || tipo_emp == 'TRP'){
            $('#div-militar').removeClass('d-none');
            //$('#div-militar #grado_militar').attr('required');
            $( "#grado_militar" ).prop( "disabled", true );
            /*$.get('/api/grados-militares/' + tipo_emp,function(data) {
                $('#grado_militar').empty();
                $.each(data, function(fetch, grado){          
                    $('#grado_militar').append('<option value="'+ grado.codigo_grado +'">'+ grado.descripcion +'</option>');
                });
            });
            contingente(tipo_emp, $('#fecha_ingreso').val());*/
            $('.cargo').hide();
        }else{
            $('.cargo').show();
            $('#div-militar').addClass('d-none');
            $('#div-militar #grado_militar').removeAttr('required');
            if (tipo_emp == 'OBR'){

                $('.obrero #grado_obr').attr('required');
                $('.obrero #clasificacion').attr('required');
                $('.obrero').show();
            }else{
                $('.obrero').hide();
                $('.obrero #grado_obr').removeAttr('required');
                $('.obrero #clasificacion').removeAttr('required');
            }
        }
        if(tipo_emp!=''){
            $( ".datos input" ).prop( "disabled", true );
            $( "select.registrar" ).prop( "disabled", true);
        }else{
            $( "input" ).prop( "disabled", true );
            $( "select.registrar" ).prop( "disabled", true );
            $("#btn-registrar").prop( "disabled", true );
        }
        
        if (nivel_instruccion>=5){
            $('.nivel_instruccion').show();
        }else{
            $('.nivel_instruccion').hide();
        }
        if (tipo_emp == 'MEF' || tipo_emp == 'ALI' || tipo_emp == 'MIL' || tipo_emp == 'TRP'){
            contingente(tipo_emp, this.value);
        }
    }

    function contingente(tipo_emp, fecha_ingreso=null) {
        var contingente= $('#contingente').val();
        if (tipo_emp == 'ALI') {
            if (fecha_ingreso){
                var mes = new Date(fecha_ingreso).getMonth()+1;
                if (mes<5) {
                    var mes2 = '1';
                }
                else if (mes>4 && mes<9) {
                    var mes2 = '2';
                }
                else if (mes>8 && mes<=12) {
                    var mes2 = '3';
                }
                var año = new Date(fecha_ingreso).getFullYear().toString();
                var final = año.slice(-2);
                var valor2 = mes2+""+final;            
                $('#contingente').val(valor2);
            }else {
                $('#contingente').val(contingente);
            }
        }else {
            $('#contingente').val(contingente);
        }
    }

    function buscarParentesco(buscar){
        var valor = $.map(parentescos, function( value, key) {
            if (key==buscar){
                return value;
            }
        });
        return  valor[0];
    }

    function calcularEdad(fecha) {
        var hoy = new Date();
        var cumpleanos = new Date(fecha);
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();

        if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
            edad--;
        }

        return edad;
    }
</script>
@endsection