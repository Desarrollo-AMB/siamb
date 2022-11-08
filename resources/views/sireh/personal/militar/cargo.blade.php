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

                    <!-- DATOS PERSONALES Y MILITARES -->
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
                                                <h6>Tipo Empleado:</h6>
                                                @if($datos->nomina->tipo_emp != "")
                                                    @foreach ($tipos_emp as $row)
                                                        @if($row->tipo_emp == $datos->nomina->tipo_emp)
                                                            {!! Form::text('tipo_emp', $row->descripcion.' '.'('.$datos->nomina->tipo_emp.')' , array('placeholder' => 'No Posee Tipo de Empleado','class' => 'form-control','disabled')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('tipo_emp', '', array('placeholder' => 'No Posee Tipo de Empleado','class' => 'form-control','disabled')) !!}
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
                                                <h6>Grado Militar:</h6>
                                                @if($datos->nomina->grado_militar != "")
                                                    @foreach ($grados_militares as $row)
                                                        @if($row->codigo_grado == $datos->nomina->grado_militar)
                                                            {!! Form::text('grado_militar', $row->descripcion, array('placeholder' => 'No Posee Grado','class' => 'form-control','disabled')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('grado_militar', '', array('placeholder' => 'No Posee Grado','class' => 'form-control','disabled')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Nombres:</h6>
                                                {!! Form::text('nombre1', $datos->nombre1.' '.$datos->nombre2, array('placeholder' => 'No Posee Nombres','class' => 'form-control','disabled')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Apellidos:</h6>
                                                {!! Form::text('nombre2', $datos->apellido1.' '.$datos->apellido2, array('placeholder' => 'No Posee Apellidos','class' => 'form-control','disabled')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Cargo:</h6>
                                                @if($datos->nomina->codigo_cargo != "")
                                                    @foreach ($cargos as $row)
                                                        @if($row->codigo_cargo == $datos->nomina->codigo_cargo)
                                                            {!! Form::text('cargo', $row->nombre_cargo.' '.'('.$row->codigo_cargo.')' , array('placeholder' => 'No Posee Cargo','class' => 'form-control','disabled')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('cargo', '', array('placeholder' => 'No Posee Cargo','class' => 'form-control','disabled')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha de Inicio de Cargo:</h6>
                                                {!! Form::text('fecha_inicio_cargo', $datos->nomina->fecha_inic_cargo, array('placeholder' => 'No Posee Fecha de Inicio de Cargo','class' => 'form-control','disabled')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Resuelto Cargo:</h6>
                                                {!! Form::text('resolucion_cargo', $datos->nomina->nro_resolucion_cargo, array('placeholder' => 'No Posee Resuelto','class' => 'form-control','disabled')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Ubicación:</h6>
                                                @if($datos->nomina->codigo_ubicacion != "")
                                                    @foreach ($ubicaciones as $row)
                                                        @if($row->codigo_ubicacion == $datos->nomina->codigo_ubicacion)
                                                            {!! Form::text('ubicacion', $row->descripcion, array('placeholder' => 'No Posee Ubicacion','class' => 'form-control','disabled')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('ubicacion', '', array('placeholder' => 'No Posee Ubicacion','class' => 'form-control','disabled')) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Ubicacion Detallada:</h6>
                                                @if($datos->nomina->cod_ubicacion_detallada != "")
                                                    @foreach ($ubicaciones_det as $row)
                                                        @if($row->codigo_ubicacion == $datos->nomina->cod_ubicacion_detallada)
                                                            {!! Form::text('ubicacion_detallada', $row->descripcion.' '.'('.$row->codigo_ubicacion.')' , array('placeholder' => 'No Posee Ubicacion Detallada','class' => 'form-control','disabled')) !!}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {!! Form::text('ubicacion_detallada', '', array('placeholder' => 'No Posee Ubicacion Detallada','class' => 'form-control','disabled')) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Resuelto Ubicación:</h6>
                                                {!! Form::text('resolucion_ubicacion', $datos->nomina->nro_resolucion_ubicacion, array('placeholder' => 'No Posee Resuelto','class' => 'form-control','disabled')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- INGRESO DE CARGOS -->
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Ingreso de Cargos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Nuevo Cargo:</h6>
                                                <select class="select2 form-control" name="cargo" id="cargo">
                                                    <option value="">SELECCIONE...</option>
                                                    @foreach ($cargos as $row)
                                                        <option value="{{$row->codigo_cargo}}"> {{ $row->nombre_cargo }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha de Inicio del Cargo:</h6>
                                                {!! Form::date('fecha_inic_cargo', '', array('placeholder' => 'No Posee Fecha de Cargo','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Número de Resuelto:</h6>
                                                {!! Form::text('nro_resolucion_cargo', '', array('placeholder' => 'No Posee Resolución del Cargo','class' => 'form-control')) !!}
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
    });
</script>
@endsection