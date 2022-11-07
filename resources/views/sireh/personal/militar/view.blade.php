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
                                                        @if($datos->edo_civil == $key)
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
                                                @if($datos->ciudad != "")
                                                    @foreach ($ciudades as $row)
                                                        @if($row->ciudad == $datos->ciudad)
                                                            {!! Form::text('ciudad', $row->ciudad, array('placeholder' => 'No Posee Ciudad','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('ciudad', '', array('placeholder' => 'No Posee Ciudad','class' => 'form-control')) !!}
                                                @endif
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
                                                {!! Form::text('talla_falda', $datos->talla_falda, array('placeholder' => 'No Posee Talla de Falda','class' => 'form-control')) !!}
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
                                                @if($datos->nomina->tipo_emp != "")
                                                    @foreach ($tipos_emp as $row)
                                                        @if($row->tipo_emp == $datos->nomina->tipo_emp)
                                                            {!! Form::text('tipo_emp', $row->descripcion.' '.'('.$datos->nomina->tipo_emp.')' , array('placeholder' => 'No Posee Tipo de Empleado','class' => 'form-control')) !!}
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
                                                @if($datos->nomina->grado_militar != "")
                                                    @foreach ($grados_militares as $row)
                                                        @if($row->codigo_grado == $datos->nomina->grado_militar)
                                                            {!! Form::text('grado_militar', $row->descripcion, array('placeholder' => 'No Posee Grado','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('grado_militar', '', array('placeholder' => 'No Posee Grado','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Categoria:</h6>
                                                @if($datos->datos_militares->codigo_categoria != "" && $datos->datos_militares->codigo_categoria != 1)
                                                    @foreach ($categorias_militares as $row)
                                                        @if($datos->datos_militares->codigo_categoria == $row->codigo_categoria)
                                                            {!! Form::text('categoria', $row->descripcion, array('placeholder' => 'No Posee Categoria','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('categoria', '', array('placeholder' => 'No Posee Categoria','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Situación:</h6>
                                                @if($datos->situacion != '')
                                                    @foreach ($situaciones as $key=>$value)
                                                        @if($datos->situacion == $key)
                                                            {!! Form::text('situacion', $value, array('placeholder' => 'No Posee Situación','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('situacion', '', array('placeholder' => 'No Posee Situación','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha de Graduación:</h6>
                                                {!! Form::text('fecha_graduacion', $datos->datos_militares->fecha_graduacion, array('placeholder' => 'No Posee Fecha de Graduación','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Promoción:</h6>
                                                @if($datos->datos_militares->codigo_promocion != "")
                                                    @foreach ($promociones_militares as $row)
                                                        @if($row->codigo_promocion == $datos->datos_militares->codigo_promocion)
                                                            {!! Form::text('promocion', $row->descripcion, array('placeholder' => 'No Posee Promoción','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('promocion', '', array('placeholder' => 'No Posee Promoción','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha de Ultimo Ascenso:</h6>
                                                {!! Form::text('fecha_ultimo_ascenso', $datos->datos_militares->fecha_ultimo_ascenso, array('placeholder' => 'No Posee Fecha de Ultimo Ascenso','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha de Retiro:</h6>
                                                {!! Form::text('fecha_retiro', $datos->datos_militares->fecha_retiro, array('placeholder' => 'No Posee Fecha de Retiro','class' => 'form-control')) !!}
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
                                                @if($datos->nomina->codigo_ubicacion != "")
                                                    @foreach ($ubicaciones as $row)
                                                        @if($row->codigo_ubicacion == $datos->nomina->codigo_ubicacion)
                                                            {!! Form::text('ubicacion', $row->descripcion, array('placeholder' => 'No Posee Ubicacion','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('ubicacion', '', array('placeholder' => 'No Posee Ubicacion','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div> 
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Ubicacion Detallada:</h6>
                                                @if($datos->nomina->cod_ubicacion_detallada != "")
                                                    @foreach ($ubicaciones_det as $row)
                                                        @if($row->codigo_ubicacion == $datos->nomina->cod_ubicacion_detallada)
                                                            {!! Form::text('ubicacion_detallada', $row->descripcion.' '.'('.$row->codigo_ubicacion.')' , array('placeholder' => 'No Posee Ubicacion Detallada','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('ubicacion_detallada', '', array('placeholder' => 'No Posee Ubicacion Detallada','class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Cargo:</h6>
                                                @if($datos->nomina->codigo_cargo != "")
                                                    @foreach ($cargos as $row)
                                                        @if($row->codigo_cargo == $datos->nomina->codigo_cargo)
                                                            {!! Form::text('cargo', $row->nombre_cargo.' '.'('.$row->codigo_cargo.')' , array('placeholder' => 'No Posee Tipo de Empleado','class' => 'form-control')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('cargo', '', array('placeholder' => 'No Posee Tipo de Empleado','class' => 'form-control')) !!}
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