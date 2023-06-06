@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
@section('content')

    @if ($message = Session::get('success'))
    <div class="alert alert-success mx-4" role="alert">
        <span class="text-white">{{ $message }}</span>
    </div>
    @endif
    @php
        if ($datos->fecha_nacim != "") {
            $fecha_nacim = date("d/m/Y", strtotime($datos->fecha_nacim));
        }
        else {
            $fecha_nacim = "";
        }
        
        if ($datos->datos_militares->fecha_graduacion != "") {
            $fecha_graduacion = date("d/m/Y", strtotime($datos->datos_militares->fecha_graduacion));
        }
        else {
            $fecha_graduacion = "";
        }

        if ($datos->datos_militares->fecha_ultimo_ascenso != "") {
            $fecha_ultimo_ascenso = date("d/m/Y", strtotime($datos->datos_militares->fecha_ultimo_ascenso));
        }
        else {
            $fecha_ultimo_ascenso = "";
        }

        if ($datos->datos_militares->fecha_retiro != "") {
            $fecha_retiro = date("d/m/Y", strtotime($datos->datos_militares->fecha_retiro));
        }
        else {
            $fecha_retiro = "";
        }
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Modificar Datos del Profesional</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.personal-militar.index') }}">Volver</a>
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
                    <form class="row g-3 requires-validation" name="militar" id="militar" method="post" action="{{route('sireh.personal-militar.update.datos')}}" enctype="multipart/form-data" >
                        @csrf
                        <!-- FOTO DE PERFIL -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="avatar-wrapper">
                                    <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" />
                                    <div class="upload-button">
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                    </div>
                                    <input class="file-upload" type="file" accept="image/*" name="foto"  id="foto"/>
                                </div>
                            </div>
                        </div>

                        <!-- DATOS PERSONALES -->
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card">
                                    <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                        <h5 class="card-title">Datos Personales</h5>
                                    </div>

                                    <input type="hidden" class="form-control" name="codigo_empleado" value="{{ $datos->codigo_empleado }}">
                                    <input type="hidden" class="form-control" name="id" value="{{ $datos->id }}">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Nacionalidad:</h6>
                                                    <select class="select2 form-control" name="nacionalidad" id="nacionalidad">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($nacionalidades as $key=>$value)
                                                            <option value="{{$key}}" {{$datos->nacionalidad == $key ? 'selected': '' }}>{{ $value }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Cédula:</h6>
                                                    <input id="cedula" type="text" class="form-control soloNumeros @error('cedula') is-invalid @enderror" name="cedula" value="{{ $datos->cedula }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Primer Nombre:</h6>
                                                    {!! Form::text('nombre1', $datos->nombre1, array('placeholder' => 'No Posee Primer Nombre','class' => 'form-control soloLetras', 'id' => 'nombre1')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Segundo Nombre:</h6>
                                                    {!! Form::text('nombre2', $datos->nombre2, array('placeholder' => 'No Posee Segundo Nombre','class' => 'form-control soloLetras', 'id' => 'nombre2')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Primer Apellido:</h6>
                                                    {!! Form::text('apellido1', $datos->apellido1, array('placeholder' => 'No Posee Primer Apellido','class' => 'form-control soloLetras', 'id' => 'apellido1')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Segundo Apellido:</h6>
                                                    {!! Form::text('apellido2', $datos->apellido2, array('placeholder' => 'No Posee Segundo Apellido','class' => 'form-control soloLetras', 'id' => 'apellido2')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Sexo:</h6>
                                                    <select class="select2 form-control" name="sexo" id="sexo">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($generos as $key=>$value)
                                                            <option value="{{$key}}" {{$datos->sexo == $key ? 'selected': '' }}>{{ $value }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Estado Civil:</h6>
                                                    <select class="select2 form-control" name="edo_civil" id="edo_civil">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($edos_civil as $key=>$value)
                                                            <option value="{{$key}}" {{$datos->edo_civil == $key ? 'selected': '' }}>{{ $value }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">      
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Fecha Nacimiento:</h6>
                                                    {!! Form::date('fecha_nacim', $datos->fecha_nacim, array('placeholder' => 'No Posee Fecha de Nacimiento','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Telefono:</h6>
                                                    {!! Form::text('telefono_cel', $datos->telefono_cel, array('placeholder' => 'Telefono','class' => 'form-control soloNumeros')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Telefono Casa:</h6>
                                                    {!! Form::text('telefono', $datos->telefono, array('placeholder' => 'Telefono','class' => 'form-control soloNumeros')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Telefono Oficina:</h6>
                                                    {!! Form::text('telefono_ofi', $datos->telefono_ofi, array('placeholder' => 'Telefono','class' => 'form-control soloNumeros')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">    
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Estado:</h6>
                                                    <select class="select2 form-control" name="estado" id="estado">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($estados as $row)
                                                            <option value="{{$row->id_estado}}" {{$datos->estado == $row->id_estado ? 'selected': '' }}>{{ $row->estado }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Ciudad:</h6>
                                                    <select class="select2 form-control" name="ciudad" id="ciudad">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($ciudades as $row)
                                                            <option value="{{$row->ciudad}}" {{$datos->ciudad == $row->ciudad ? 'selected': '' }}>{{ $row->ciudad }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <h6>Direccion:</h6>
                                                    {!! Form::text('direccion', $datos->direccion, array('placeholder' => 'No Posee Dirección','class' => 'form-control', 'id' => 'direccion')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Correo:</h6>
                                                    {!! Form::text('correo', $datos->correo, array('placeholder' => 'No Posee Correo','class' => 'form-control', 'id' => 'correo')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Peso:</h6>
                                                    {!! Form::text('peso', $datos->peso, array('placeholder' => 'No Posee Peso','class' => 'form-control soloNumeros')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Estatura:</h6>
                                                    {!! Form::text('estatura', $datos->estatura, array('placeholder' => 'No Posee Estatura','class' => 'form-control soloNumeros')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Lateralidad:</h6>
                                                    <select name="zur_der_amb" id="zur_der_amb" class='form-control select2'>
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($lateralidades as $key=>$value)
                                                            <option value="{{$key}}" {{$datos->zur_der_amb == $key ? 'selected': '' }}>{{ $value }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Color de Ojos:</h6>
                                                    {!! Form::text('ojos', $datos->ojos, array('placeholder' => 'No Posee Color de Ojos','class' => 'form-control soloLetras', 'id' => 'ojos')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Color de Cabello:</h6>
                                                    {!! Form::text('cabellos', $datos->cabellos, array('placeholder' => 'No Posee Color de Cabello','class' => 'form-control soloLetras', 'id' => 'cabellos')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Color de Piel:</h6>
                                                    {!! Form::text('color', $datos->color, array('placeholder' => 'No Posee Color de Piel','class' => 'form-control soloLetras', 'id' => 'color')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Talla de Camisa:</h6>
                                                    {!! Form::text('talla_camisa', $datos->talla_camisa, array('placeholder' => 'No Posee Talla de Camisa','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Talla de Pantalon:</h6>
                                                    {!! Form::text('talla_pant', $datos->talla_pant, array('placeholder' => 'No Posee Talla de Pantalon','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Talla de Chaqueta:</h6>
                                                    {!! Form::text('talla_chaqueta', $datos->talla_chaqueta, array('placeholder' => 'No Posee Talla de Chaqueta','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Talla de Calzado:</h6>
                                                    {!! Form::text('numero_calzado', $datos->numero_calzado, array('placeholder' => 'No Posee Talla de Calzado','class' => 'form-control soloNumeros')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 falda">
                                                <div class="form-group">
                                                    <h6>Talla de Falda:</h6>
                                                    {!! Form::text('talla_falda', $datos->talla_falda, array('placeholder'=>'No Posee Talla de Falda', 'class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- DATOS MILITARES -->
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card ">
                                    <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                        <h5 class="card-title">Datos Militares</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <h6>Tipo Empleado:</h6>
                                                    <select class="select2 form-control" name="tipo_emp" id="tipo_emp">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($tipos_emp as $row)
                                                            @if ($row->aplicacion_nomina == 'M' || $row->aplicacion_nomina == 'X')
                                                                <option value="{{$row->tipo_emp}}" {{$datos->nomina->tipo_emp == $row->tipo_emp ? 'selected': '' }}>{{ $row->descripcion }} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <h6>Categoria:</h6>
                                                    <select class="select2 form-control" name="categoria" id="categoria">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($categorias_militares as $row)
                                                            @if ($row->tipo_emp == 'MIL' || $row->tipo_emp == 'TRP')
                                                                <option value="{{$row->codigo_categoria}}" {{$datos->datos_militares ? ($datos->datos_militares->codigo_categoria == $row->codigo_categoria ? 'selected': '' ) : ''}}>{{ $row->descripcion }} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <h6>Grado Militar:</h6>
                                                    <select class="select2 form-control" name="grado_militar" id="grado_militar">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($grados_militares as $row)
                                                            <option value="{{$row->codigo_grado}}" {{$datos->nomina->grado_militar == $row->codigo_grado ? 'selected': '' }}>{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <h6>Promoción:</h6>
                                                    <select class="select2 form-control" name="promocion" id="promocion">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($promociones_militares as $row)
                                                            <option value="{{$row->codigo_promocion}}" {{$datos->datos_militares ? ($datos->datos_militares->codigo_promocion == $row->codigo_promocion ? 'selected': '') :'' }}>{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OTROS DATOS -->
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card" >
                                    <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                        <h5 class="card-title">Otros Datos</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">    
                                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                <div class="form-group">
                                                    <h6>Nombre y Apellido (contacto de emergencia):</h6>
                                                    {!! Form::text('persona_contacto', $datos->persona_contacto, array('placeholder' => 'No Posee Contacto de Emergencia','class' => 'form-control soloLetras', 'id' => 'persona_contacto')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <h6>Telefono (contacto de emergencia):</h6>
                                                    {!! Form::text('telefono_e', $datos->telefono_e, array('placeholder' => 'No Posee Telefono de Contacto de Emergencia','class' => 'form-control soloNumeros')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BOTON PARA ACTUALIZAR -->
                        <div class="row">    
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" id="btn-actualizar">Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(function (){
        $('.select2').select2();

        $(".soloLetras").on('keypress', function(event) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });

        $(".soloNumeros").on('keypress', function(event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });

        //Para la foto
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
   
        $(".file-upload").on('change', function(){
            readURL(this);
        });
        
        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });

        $('#sexo').on('change', function(e){
            var sexo = e.target.value;
            if (sexo == 'M') {
                $('.falda').hide();
            }
            else {
                $('.falda').show();
            }
        });

        $('#estado').on('change', function(e){
            var estado = e.target.value;
            if (estado == "") {
                $('#ciudad').prop('disabled',true);
            }
            else {
                $('#ciudad').prop('disabled',false);
                $.get('/api/ciudades/' + estado,function(data) {
                    console.log(data);
                    $('#ciudad').empty();
                    $('#ciudad').append('<option value="">SELECCIONE...</option>');
                    $.each(data, function(fetch, ciudad){          
                        $('#ciudad').append('<option value="'+ ciudad.ciudad +'">'+ ciudad.ciudad +'</option>');
                    });
                });
            }
        });

        $('#tipo_emp').on('change', function(e){
            var tipo_emp = e.target.value;
            if (tipo_emp == "") {
                $('#categoria').prop('disabled',true);
                $('#grado_militar').prop('disabled',true);
            }
            else {
                $('#categoria').prop('disabled',false);
                $.get('/api/categoria/' + tipo_emp,function(data) {
                    $('#categoria').empty();
                    if (tipo_emp == 'TRP') {
                        $('#categoria').append('<option value="">SELECCIONE...</option>');
                        $.each(data, function(fetch, categoria){
                            $('#categoria').append('<option value="'+ categoria.codigo_categoria +'">'+ categoria.descripcion +'</option>');
                        });
                    }
                    else {
                        $('#categoria').append('<option value="">SELECCIONE...</option>');
                        $.each(data, function(fetch, categoria){
                            $('#categoria').append('<option value="'+ categoria.codigo_categoria +'">'+ categoria.descripcion +'</option>');
                        });
                    }
                });

                $('#grado_militar').prop('disabled',false);
                $.get('/api/grados-militares-persmil/' + tipo_emp,function(data) {
                    console.log(data);
                    $('#grado_militar').empty();
                    $('#grado_militar').append('<option value="">SELECCIONE...</option>');
                    $.each(data, function(fetch, grados){
                        $('#grado_militar').append('<option value="'+ grados.codigo_grado +'">'+ grados.descripcion +'</option>');
                    });
                });
            }
        });

        $('#categoria').on('change', function(e){
            var categoria = e.target.value;
            if (categoria == "") {
                $('#promocion').prop('disabled',true);
            }
            else {
                $('#promocion').prop('disabled',false);
                $.get('/api/promociones-militares/' + categoria,function(data) {
                    $('#promocion').empty();
                    $('#promocion').append('<option value="">SELECCIONE...</option>');
                    $.each(data, function(fetch, promociones){
                        $('#promocion').append('<option value="'+ promociones.codigo_promocion +'">'+ promociones.descripcion +'</option>');
                    });
                });
            }
        });

        $('#sexo').on('change', function(e){
            var sexo = e.target.value;
            if (sexo == "M") {
                $('.falda').hide();
                $('input:text[name=talla_falda]').prop('disabled',true);
            }
            else {
                $('.falda').show();
                $('input:text[name=talla_falda]').prop('disabled',false);
            }
        });

        $('#btn-actualizar').click(function(){
            $('#nombre1').val($('#nombre1').val().toUpperCase());
            $('#nombre2').val($('#nombre2').val().toUpperCase());
            $('#apellido1').val($('#apellido1').val().toUpperCase());
            $('#apellido2').val($('#apellido2').val().toUpperCase());
            $('#correo').val($('#correo').val().toUpperCase());
            $('#ojos').val($('#ojos').val().toUpperCase());
            $('#cabellos').val($('#cabellos').val().toUpperCase());
            $('#color').val($('#color').val().toUpperCase());
            $('#persona_contacto').val($('#persona_contacto').val().toUpperCase());
        });

        inicializar();
    });

    function inicializar() {
        var sexo = $('#sexo').val();
        if(sexo == 'M') {
            $('.falda').hide();
            $('input:text[name=talla_falda]').prop('disabled',true);
        }
        else {
            $('.falda').show();
            $('input:text[name=talla_falda]').prop('disabled',false);
        }

        var estado = $('#estado').val();
        if (estado == "") {
            $('#ciudad').prop('disabled',true);
        }
        else {
            $('#ciudad').prop('disabled',false);
        }

        var tipo_emp = $('#tipo_emp').val();
        if (tipo_emp == "") {
            $('#categoria').prop('disabled',true);
            $('#grado_militar').prop('disabled',true);
        }
        else {
            $('#categoria').prop('disabled',false);
            $('#grado_militar').prop('disabled',false);
        }

        var categoria = $('#categoria').val();
        if (categoria == "") {
            $('#promocion').prop('disabled',true);
        }
        else {
            $('#promocion').prop('disabled',false);
        }
    }
</script>
@endsection