@extends('layouts.user_type.auth')
@section('title', 'Personal Militar No Profesional')
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
                            <h5 class="mb-0">Personal Militar No Profesional</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.personal-militar-noprof.index') }}">Volver</a>
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
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="avatar-wrapper">
                                <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" />
                                <div class="upload-button">
                                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">  
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
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
                    </div>
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
                                                <select class="select2 form-control registrar" name="nacionalidad" id="nacionalidad" disabled>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($nacionalidades as $key=>$value)
                                                        <option value="{{$key}}" {{$datos->nacionalidad == $key ? 'selected': '' }}>{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Cédula:</h6>
                                                <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" disabled 
                                                    value="{{ $datos->cedula }}"
                                                >
                                            </div>
                                        </div>     
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Primer Nombre:</h6>
                                                <input name="nombre1" value="{{$datos->nombre1}}" class = "form-control" disabled>                                        </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Segundo Nombre:</h6>
                                                {!! Form::text('nombre2', $datos->nombre2, array('placeholder' => 'Segundo Nombre','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Primer Apellido:</h6>
                                                {!! Form::text('apellido1', $datos->apellido1, array('placeholder' => 'Primer Apellido','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Segundo Apellido:</h6>
                                                {!! Form::text('apellido2', $datos->apellido2, array('placeholder' => 'Segundo Apellido','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">      
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha Nacimiento: <small></small></h6>
                                                <input name="fecha_nacim" type="date" class="form-control fecha" required value="{{$datos->fecha_nacim}}">
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Sexo:</h6>
                                                <select class="select2 form-control registrar" name="genero" id="genero" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($generos as $key=>$value)
                                                        <option value="{{$key}}" {{$datos->sexo == $key? 'selected': '' }}>{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado Civil:</h6>
                                                <select class="select2 form-control registrar" name="edo_civil" id="edo_civil" required>
                                                    <option value="">Seleccione ...</option>
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
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Correo:</h6>
                                                {!! Form::text('correo', $datos->correo, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado:</h6>
                                                <select class="select2 form-control registrar" name="estado" id="estado" >
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($estados as $row)
                                                        <option value="{{$row->id_estado}}" {{$datos->estado == $row->id_estado ? 'selected': '' }} >{{ $row->estado }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Ciudad:</h6>
                                                <select class="select2 form-control registrar" name="ciudad" id="ciudad">
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($ciudades as $row)
                                                        <option value="{{$row->id}}" {{$datos->ciudad == $row->id ? 'selected': '' }} >{{ $row->ciudad }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Direccion:</h6>
                                                {!! Form::text('direccion', $datos->direccion, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
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
                                    <h5 class="card-title">Datos Académicos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Nivel Instrucción:</h6>
                                                <select class="select2 form-control registrar" name="nivel" id="nivel" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($niveles as $row)
                                                        <option value="{{$row->codigo}}" data-nivel="{{$row->nivel_instruccion}}" {{ $datos->nivel_instruccion == $row->codigo ? 'selected': '' }}>{{ $row->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 nivel_instruccion" >
                                            <div class="form-group">
                                                <h6>Universidad:</h6>
                                                <select class="select2 form-control registrar" name="universidad" id="universidad" >
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($universidades as $row)
                                                        <option value="{{$row->codigo_universidad}}" {{$datos->estudios_realizados ? ($datos->estudios_realizados->universidad == $row->codigo_universidad ? 'selected': '' ) : '' }}>{{ $row->nombre }} ({{$row->tipo_universidad}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 nivel_instruccion" >
                                            <div class="form-group">
                                                <h6>Profesiones:</h6>
                                                <select class="select2 form-control registrar" name="profesion" id="profesion" >
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($profesiones as $row)
                                                        <option value="{{$row->codigo_profesion}}" {{$datos->profesion == $row->codigo_profesion ? 'selected': '' }} >{{ $row->descripcion }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 nivel_instruccion">
                                            <div class="form-group">
                                                <h6>Fecha Graduacion: <small></small></h6>
                                                <input name="fecha_graduacion"  id="fecha_graduacion" type="date" class="form-control fecha" 
                                                    value="{{ $datos->fecha_graduacion }}"
                                                >
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
                                    <h5 class="card-title">Datos Laborales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                <h6>Fecha Ingreso: <small></small></h6>
                                                <input name="fecha_ingreso"  id="fecha_ingreso" type="date" class="form-control fecha" required
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
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="form-group">
                                                <h6>Ubicacion Detallada:</h6>
                                                <select class="select2 form-control registrar" name="ubicacion_det" id="ubicacion_det">
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($ubicaciones_det as $row)
                                                        <option value="{{$row->codigo_ubicacion}}" {{$datos->nomina->cod_ubicacion_detallada == $row->codigo_ubicacion ?  'selected': '' }}>{{ $row->descripcion }} ({{ $row->codigo_ubicacion}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">    
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
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 cargo">
                                            <div class="form-group">
                                                <h6>Código RAC/RAPO:</h6>
                                                <input type="text" class="form-control" name="cod_rac" value="{{ $datos->cod_rac ?: null }}">
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 obrero">
                                            <div class="form-group">
                                                <h6>Grado Obrero:</h6>
                                                <select class="select2 form-control" name="grado_obr" id="grado_obr" >
                                                    <option value="">Seleccione</option>
                                                    <option value="1" >1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 obrero">
                                            <div class="form-group">
                                                <h6>Clasificacion Obrero:</h6>
                                                <select class="select2 form-control" name="clasificacion" id="clasificacion" >
                                                <option value="">Seleccione...</option>
                                                <option value="C" >CLASIFICADO</option>
                                                <option value="NC">NO CLASIFICADO</option>
                                                <option value="S">SUPERVISOR</option>
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
                            <div class="card " id="div-militar">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Militares</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">    
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
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
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Contingente:</h6>
                                                {!! Form::text('contingente', $datos->nomina->datos_militares ? $datos->nomina->datos_militares->contingente : null, array('id'=>'contingente', 'placeholder' => '','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                {!! Form::text('persona_contacto', $datos->persona_contacto, array('placeholder' => '','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Telefono (contacto de emergencia):</h6>
                                                {!! Form::text('telefono_e', $datos->telefono_e, array('placeholder' => '','class' => 'form-control')) !!}
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

@section('scripts')
<script>
    $(function (){
        $('.nivel_instruccion').hide();
        $('.obrero').hide();
        $('.cargo').hide();
        $("input").prop( "disabled", true );
        $("select.registrar").prop( "disabled", true );
        $("#btn-registrar").prop( "disabled", true );

        //////////////////////////////////
        $('.select2').select2();

        inicializar();
    });

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
            $( "input" ).prop( "disabled", true );
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
</script>
@endsection