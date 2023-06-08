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
                            <h5 class="mb-0">Ver Datos del Profesional</h5>
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

                    <!-- FOTO DE PERFIL -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="avatar-wrapper">
                                <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" />
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
                                                @if($datos->nacionalidad != "")
                                                    @foreach ($nacionalidades as $key=>$value)
                                                        @if($datos->nacionalidad == $key)
                                                            {!! Form::text('nacionalidad', $value, array('placeholder' => 'No Posee Nacionalidad', 'class' => 'form-control')) !!}
                                                        @else
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('nacionalidad', '', array('placeholder' => 'No Posee Nacionalidad','class' => 'form-control')) !!}
                                                @endif
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
                                                @if($datos->sexo != '')
                                                    @foreach ($generos as $key=>$value)
                                                        @if($datos->sexo == $key)
                                                            {!! Form::text('sexo', $value, array('id'=>'sexo','placeholder' => 'No Posee Sexo','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('sexo', '', array('placeholder' => 'No Posee Sexo','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado Civil:</h6>
                                                @if($datos->edo_civil != '')
                                                    @foreach ($edos_civil as $key=>$value)
                                                        @if($datos->edo_civil == $value)
                                                            {!! Form::text('edo_civil', $value, array('placeholder' => 'No Posee Estado Civil','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('edo_civil', '', array('placeholder' => 'No Posee Estado Civil','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha Nacimiento:</h6>
                                                {!! Form::text('fecha_nacim', $datos->fecha_nacim, array('placeholder' => 'No Posee Fecha de Nacimiento','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Telefono:</h6>
                                                {!! Form::text('telefono_cel', $datos->telefono, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Telefono Casa:</h6>
                                                {!! Form::text('telefono', $datos->telefono_casa, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado:</h6>
                                                @if($datos->estado != "")
                                                    @foreach ($estados as $row)
                                                        @if($row->id_estado == $datos->estado)
                                                            {!! Form::text('estado', $row->estado, array('placeholder' => 'Estado','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('estado', '', array('placeholder' => 'No Posee Estado','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Ciudad:</h6>
                                                <select class="select2 form-control registrar" name="ciudad" id="ciudad" disabled>
                                                    <option value="">Seleccione...</option>
                                                    @foreach ($ciudades as $row)
                                                        <option value="{{$row->ciudad}}" {{$datos->ciudad == $row->ciudad ? 'selected': '' }} >{{ $row->ciudad }} </option>
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
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Tipo Empleado:</h6>
                                                @if($datos->tipo_emp != "")
                                                    @foreach ($tipos_emp as $row)
                                                        @if($row->tipo_emp == $datos->tipo_emp)
                                                            {!! Form::text('tipo_emp', $row->descripcion.' '.'('.$datos->tipo_emp.')' , array('placeholder' => 'No Posee Tipo de Empleado','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('tipo_emp', '', array('placeholder' => 'No Posee Tipo de Empleado','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Grado Militar:</h6>
                                                @if($datos->codigo_grado != "")
                                                    @foreach ($grados_militares as $row)
                                                        @if($row->codigo_grado == $datos->codigo_grado)
                                                            {!! Form::text('codigo_grado',  $row->descripcion.' '.'('.$datos->codigo_grado.')', array('placeholder' => 'No Posee Grado','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('codigo_grado', '', array('placeholder' => 'No Posee Grado','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Componete:</h6>
                                                @if($datos->componente != '')
                                                    @foreach ($componente as $key=>$value)
                                                        @if($datos->componente == $key)
                                                            {!! Form::text('situacion', $value, array('placeholder' => 'No Posee Situación','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('situacion', '', array('placeholder' => 'No Posee Situación','class' => 'form-control')) !!}
                                                @endif
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
                                                @if($datos->codigo_ubicacion != "")
                                                    @foreach ($ubicaciones as $row)
                                                        @if($row->codigo_ubicacion == $datos->codigo_ubicacion)
                                                            {!! Form::text('ubicacion', $row->descripcion, array('placeholder' => 'No Posee Ubicacion','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('ubicacion', '', array('placeholder' => 'No Posee Ubicacion','class' => 'form-control')) !!}
                                                @endif
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
                                                {!! Form::text('persona_contacto', $datos->contacto_emergencia, array('placeholder' => 'No Posee Contacto de Emergencia','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Telefono (contacto de emergencia):</h6>
                                                {!! Form::text('telefono_e', $datos->telefono_emergencia, array('placeholder' => 'No Posee Telefono de Contacto de Emergencia','class' => 'form-control')) !!}
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
        $('.select2').select2();
        $("input").prop( "disabled", true );

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

        inicializar();
    });

    function inicializar() {
        var sexo = $('#sexo').val();
        if(sexo == 'MASCULINO') {
            $('.falda').hide();
        }
    }
</script>
@endsection
