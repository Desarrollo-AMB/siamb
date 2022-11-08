@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
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
                            <h5 class="mb-0">Personal Militar</h5>
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
                    <form class="row g-3 requires-validation" name="militar" id="militar" 
                        method="post" action="{{route('sireh.personal-militar.update', $datos->id)}}" 
                        enctype="multipart/form-data" >
                        @csrf
                        <!-- FOTO DE PERFIL -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="avatar-wrapper">
                                    <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" />
                                    <div class="upload-button">
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                    </div>
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
                                                    <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" value="{{ $datos->cedula }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Primer Nombre:</h6>
                                                    {!! Form::text('nombre1', $datos->nombre1, array('placeholder' => 'No Posee Primer Nombre','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Segundo Nombre:</h6>
                                                    {!! Form::text('nombre2', $datos->nombre2, array('placeholder' => 'No Posee Segundo Nombre','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Primer Apellido:</h6>
                                                    {!! Form::text('apellido1', $datos->apellido1, array('placeholder' => 'No Posee Primer Apellido','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Segundo Apellido:</h6>
                                                    {!! Form::text('apellido2', $datos->apellido2, array('placeholder' => 'No Posee Segundo Apellido','class' => 'form-control')) !!}
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
                                                    {!! Form::text('telefono_cel', $datos->telefono_cel, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Telefono Casa:</h6>
                                                    {!! Form::text('telefono', $datos->telefono, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Telefono Oficina:</h6>
                                                    {!! Form::text('telefono_ofi', $datos->telefono_ofi, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
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
                                                    {!! Form::text('direccion', $datos->direccion, array('placeholder' => 'No Posee Dirección','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Correo:</h6>
                                                    {!! Form::text('correo', $datos->correo, array('placeholder' => 'No Posee Correo','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Peso:</h6>
                                                    {!! Form::text('peso', $datos->peso, array('placeholder' => 'No Posee Peso','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Estatura:</h6>
                                                    {!! Form::text('estatura', $datos->estatura, array('placeholder' => 'No Posee Estatura','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Lateralidad:</h6>
                                                    {!! Form::text('zur_der_amb', $datos->zur_der_amb, array('placeholder' => 'No Posee Lateralidad','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Color de Ojos:</h6>
                                                    {!! Form::text('ojos', $datos->ojos, array('placeholder' => 'No Posee Color de Ojos','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Color de Cabello:</h6>
                                                    {!! Form::text('cabellos', $datos->cabellos, array('placeholder' => 'No Posee Color de Cabello','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Color de Piel:</h6>
                                                    {!! Form::text('color', $datos->color, array('placeholder' => 'No Posee Color de Piel','class' => 'form-control')) !!}
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
                                                    {!! Form::text('talla_calzado', $datos->talla_calzado, array('placeholder' => 'No Posee Talla de Calzado','class' => 'form-control')) !!}
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
                                                                <option value="{{$row->codigo_categoria}}" {{$datos->datos_militares->codigo_categoria == $row->codigo_categoria ? 'selected': '' }}>{{ $row->descripcion }} </option>
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
                                                            <option value="{{$row->codigo_promocion}}" {{$datos->datos_militares->codigo_promocion == $row->codigo_promocion ? 'selected': '' }}>{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DATOS LABORALES -->
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card">
                                    <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                        <h5 class="card-title">Datos Laborales</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">    
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <h6>Ubicación:</h6>
                                                    <select class="select2 form-control" name="ubicacion" id="ubicacion">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($ubicaciones as $row)
                                                            <option value="{{$row->codigo_ubicacion}}" {{$datos->nomina->codigo_ubicacion == $row->codigo_ubicacion ? 'selected': '' }}>{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <h6>Ubicacion Detallada:</h6>
                                                    <select class="select2 form-control" name="ubicacion_detallada" id="ubicacion_detallada">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($ubicaciones_det as $row)
                                                            <option value="{{$row->codigo_ubicacion}}" {{$datos->nomina->cod_ubicacion_detallada == $row->codigo_ubicacion ? 'selected': '' }}>{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <h6>Cargo:</h6>
                                                    <select class="select2 form-control" name="cargo" id="cargo">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($cargos as $row)
                                                            <option value="{{$row->codigo_cargo}}" {{$datos->nomina->codigo_cargo == $row->codigo_cargo ? 'selected': '' }}>{{ $row->nombre_cargo }} </option>
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
                                                    {!! Form::text('persona_contacto', $datos->persona_contacto, array('placeholder' => 'No Posee Contacto de Emergencia','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <h6>Telefono (contacto de emergencia):</h6>
                                                    {!! Form::text('telefono_e', $datos->telefono_e, array('placeholder' => 'No Posee Telefono de Contacto de Emergencia','class' => 'form-control')) !!}
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
                    $('#ciudad').empty();
                    $('#ciudad').append('<option value="">SELECCIONE...</option>');
                    $.each(data, function(fetch, ciudad){          
                        $('#ciudad').append('<option value="'+ ciudad.id +'">'+ ciudad.ciudad +'</option>');
                    });
                });
            }
        });

        $('#tipo_emp').on('change', function(e){
            var tipo_emp = e.target.value;
            if (tipo_emp == "") {
                $('#categoria').prop('disabled',true);
            }
            else {
                $('#categoria').prop('disabled',false);
                $.get('/api/categoria/' + tipo_emp,function(data) {
                    $('#categoria').empty();
                    $('#categoria').append('<option value="">SELECCIONE...</option>');
                    $.each(data, function(fetch, categoria){
                        $('#categoria').append('<option value="'+ categoria.codigo_categoria +'">'+ categoria.descripcion +'</option>');
                    });
                });
            }
        });

        $('#categoria').on('change', function(e){
            var tipo_emp = $('#tipo_emp').val();
            var categoria = e.target.value;
            if (categoria == "") {
                $('#grado_militar').prop('disabled',true);
                $('#promocion').prop('disabled',true);
            }
            else {
                $('#grado_militar').prop('disabled',false);

                $.get('/api/grados-militares/' + tipo_emp,function(data) {
                    $('#grado_militar').empty();
                    $('#grado_militar').append('<option value="">SELECCIONE...</option>');
                    $.each(data, function(fetch, grados){
                        $('#grado_militar').append('<option value="'+ grados.codigo_categoria +'">'+ grados.descripcion +'</option>');
                    });
                });

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

        $('#ubicacion').on('change', function(e){
            var ubicacion = e.target.value;
            if (ubicacion == "") {
                $('#ubicacion_detallada').prop('disabled',true);
                $('#cargo').prop('disabled',true);
            }
            else {
                $('#ubicacion_detallada').prop('disabled',false);
                $('#cargo').prop('disabled',false);

                $.get('/api/ubicaciones-detalladas/' + ubicacion,function(data) {
                    console.log(data);
                    $('#ubicacion_detallada').empty();
                    $('#ubicacion_detallada').append('<option value="">SELECCIONE...</option>');
                    $.each(data, function(fetch, ubicaciones_detalladas){
                        $('#ubicacion_detallada').append('<option value="'+ ubicaciones_detalladas.codigo_ubicacion +'">'+ ubicaciones_detalladas.descripcion +'</option>');
                    });
                });
            }
        });        

        inicializar();
    });

    function inicializar() {
        var sexo = $('#sexo').val();
        if(sexo == 'M') {
            $('.falda').hide();
            $('input:text[name=talla_falda]').prop('disabled',true);
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
        }
        else {
            $('#categoria').prop('disabled',false);
        }

        var categoria = $('#categoria').val();
        if (categoria == "") {
            $('#grado_militar').prop('disabled',true);
            $('#promocion').prop('disabled',true);
        }
        else {
            $('#grado_militar').prop('disabled',false);
            $('#promocion').prop('disabled',false);
        }

        var ubicacion = $('#ubicacion').val();
        if (ubicacion == "") {
            $('#ubicacion_detallada').prop('disabled',true);
            $('#cargo').prop('disabled',true);
        }
        else {
            $('#ubicacion_detallada').prop('disabled',false);
            $('#cargo').prop('disabled',false);
        }
    }
</script>
@endsection