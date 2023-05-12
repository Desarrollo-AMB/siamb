@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
@section('content')

    @if ($message = Session::get('success'))
    <div class="alert alert-success mx-4" role="alert">
        <span class="text-white">{{ $message }}</span>
    </div>
    @endif
    @php
        if ($datos->nomina->fecha_inic_cargo != "") {
            $fecha_inic_cargo = date("d/m/Y", strtotime($datos->nomina->fecha_inic_cargo));
        }
        else {
            $fecha_inic_cargo = "";
        }
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Ver y Asignar Ubicaciones al Profesional</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('juntap.personalm.index') }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger mx-4" role="alert">
                        <ul>
                            @foreach ($errors ->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form class="row g-3 requires-validation" name="updateubicacion" id="updateubicacion" method="post" action="{{route('sireh.personal-militar.update.ubicacion')}}" enctype="multipart/form-data" >
                        @csrf
                        <!-- DATOS PERSONALES Y MILITARES -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card">
                                    <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                        <h5 class="card-title">Datos Personales</h5>
                                    </div>
                                    <input id="codigo_empleado" type="hidden" class="form-control" name="codigo_empleado" value="{{ $datos->codigo_empleado }}">
                                    <input id="id" type="hidden" class="form-control" name="id" value="{{ $datos->id }}">
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
                                                    <h6>Fecha Inicio de Cargo:</h6>
                                                    {!! Form::text('fecha_inicio_cargo', $fecha_inic_cargo, array('placeholder' => 'No Posee Fecha de Inicio de Cargo','class' => 'form-control','disabled')) !!}
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

                        <!-- HISTORICO DE UBICACION -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card">
                                    <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                        <h5 class="card-title">Historico de Ubicaciones</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Grado</th>
                                                                <th>Ubicacion</th>
                                                                <th>Ubicacion<br>Detallada</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($movimientos as $row)
                                                                @if ($row->codigo_empleado == $datos->codigo_empleado && $row->tipo_movimiento == 'Actualizacion de la Ubicacion')
                                                                    <tr>
                                                                        @foreach ($grados_militares as $grados)
                                                                            @if ($grados->codigo_grado == $row->codigo_grado)
                                                                                <td>{{$grados->siglas}}</td>
                                                                            @endif
                                                                        @endforeach

                                                                        @foreach ($ubicaciones as $ubic)
                                                                            @if ($ubic->codigo_ubicacion == $row->codigo_ubicacion)
                                                                                <td>{{$ubic->descripcion}}</td>
                                                                            @endif
                                                                        @endforeach

                                                                        @foreach ($ubicaciones_det as $ubic_det)
                                                                            @if ($ubic_det->codigo_ubicacion == $row->ubicacion_detallada)
                                                                                <td>{{$ubic_det->descripcion}}</td>
                                                                            @endif
                                                                        @endforeach
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INGRESO DE UBICACIÓN -->
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
                                                            <option value="{{$row->codigo_ubicacion}}">{{ $row->descripcion }} </option>
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
                                                            <option value="{{$row->codigo_ubicacion}}">{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <h6>Fecha de Cambio de Ubicación:</h6>
                                                    {!! Form::date('fecha_inic_ubicacion', '', array('id' => 'fecha_inic_ubicacion','placeholder' => 'No Posee Fecha de Ubicación','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <h6>Número de Resuelto:</h6>
                                                    {!! Form::text('nro_resolucion_ubicacion', '', array('id' => 'nro_resolucion_ubicacion','placeholder' => 'No Posee Resolución de la Ubicación','class' => 'form-control')) !!}
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

        $('#ubicacion').on('change', function(e){
            var ubicacion = e.target.value;
            if (ubicacion == "") {
                $('#ubicacion_detallada').prop('disabled',true);
                $('#fecha_inic_ubicacion').prop('disabled',true);
                $('#nro_resolucion_ubicacion').prop('disabled',true);
            }
            else {
                $('#ubicacion_detallada').prop('disabled',false);
                $('#fecha_inic_ubicacion').prop('disabled',false);
                $('#nro_resolucion_ubicacion').prop('disabled',false);

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
        var ubicacion = $('#ubicacion').val();
        if (ubicacion == "") {
            $('#ubicacion_detallada').prop('disabled',true);
            $('#fecha_inic_ubicacion').prop('disabled',true);
            $('#nro_resolucion_ubicacion').prop('disabled',true);
        }
        else {
            $('#ubicacion_detallada').prop('disabled',false);
            $('#fecha_inic_ubicacion').prop('disabled',false);
            $('#nro_resolucion_ubicacion').prop('disabled',false);
        }
    }
</script>
@endsection
