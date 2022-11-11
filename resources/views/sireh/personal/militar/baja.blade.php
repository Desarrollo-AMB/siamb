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
                    <form class="row g-3 requires-validation" name="militar" id="militar" method="post" action="{{route('sireh.personal-militar.dar.baja')}}" enctype="multipart/form-data" >
                        @csrf
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
                                        <h5 class="card-title">Datos del Profesional</h5>
                                    </div>

                                    <input type="hidden" class="form-control" name="codigo_empleado" value="{{ $datos->codigo_empleado }}">

                                    <div class="card-body">
                                        <div class="row">
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
                                                                {!! Form::text('grado_militar', $row->descripcion, array('placeholder' => 'No Posee Grado','class' => 'form-control','readonly')) !!}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {!! Form::text('grado_militar', '', array('placeholder' => 'No Posee Grado','class' => 'form-control','readonly')) !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Nombres:</h6>
                                                    {!! Form::text('nombres', $datos->nombre1." ".$datos->nombre2, array('placeholder' => 'No Posee Nombres','class' => 'form-control','readonly')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Apellidos:</h6>
                                                    {!! Form::text('apellidos', $datos->apellido1." ".$datos->apellido2, array('placeholder' => 'No Posee Apellidos','class' => 'form-control','readonly')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Situación:</h6>
                                                    @if($datos->situacion != '')
                                                        @foreach ($situaciones as $key=>$value)
                                                            @if($datos->situacion == $key)
                                                                {!! Form::text('situacion', $value, array('placeholder' => 'No Posee Situación','class' => 'form-control','readonly')) !!}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {!! Form::text('situacion', '', array('placeholder' => 'No Posee Situación','class' => 'form-control','readonly')) !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <h6>Ubicación:</h6>
                                                    @if($datos->nomina->codigo_ubicacion != "")
                                                        @foreach ($ubicaciones as $row)
                                                            @if($row->codigo_ubicacion == $datos->nomina->codigo_ubicacion)
                                                                {!! Form::text('ubicacion', $row->descripcion, array('placeholder' => 'No Posee Ubicacion','class' => 'form-control','readonly')) !!}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {!! Form::text('ubicacion', '', array('placeholder' => 'No Posee Ubicacion','class' => 'form-control','readonly')) !!}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- DATOS DE EGRESO -->
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card ">
                                    <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                        <h5 class="card-title">Datos del Egreso</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Tipo de Egreso:</h6>
                                                    <select class="select2 form-control" name="causa_egreso" id="causa_egreso">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($tipo_de_baja as $row)
                                                            <option value="{{$row->codigo_egreso}}">{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Fecha de Ingreso:</h6>
                                                    {!! Form::date('fecha_ingreso', $datos->nomina->fecha_ingreso, array('placeholder' => 'No Posee Fecha de Ingreso','class' => 'form-control','readonly','id' => 'fecha_ingreso')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Fecha de Egreso:</h6>
                                                    {!! Form::date('fecha_salida', $datos->fecha_salida, array('placeholder' => 'Ingrese Fecha de Egreso','class' => 'form-control','id' => 'fecha_salida')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Años de Antiguedad:</h6>
                                                    {!! Form::text('año_antiguedad', '', array('class' => 'form-control','readonly','id' => 'año_antiguedad')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Meses de Antiguedad:</h6>
                                                    {!! Form::text('meses_antiguedad', '', array('class' => 'form-control','readonly','id' => 'meses_antiguedad')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Numero de Resuelto:</h6>
                                                    {!! Form::text('nro_resuelto', '', array('placeholder' => 'Ingrese Numero de Resuelto','class' => 'form-control','id' => 'nro_resuelto')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Fecha de Resuelto:</h6>
                                                    {!! Form::date('fecha_resuelto', '', array('placeholder' => 'Ingrese Fecha de Resuelto','class' => 'form-control','id' => 'fecha_resuelto')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BOTON PARA DAR DE BAJA -->
                        <div class="row">    
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" id="btn-egresar">Egresar</button>
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

        $('#causa_egreso').on('change', function(e){
            var causa_egreso = e.target.value;
            if (causa_egreso === "") {
                $('#fecha_salida').prop('disabled',true);
                $('#nro_resuelto').prop('disabled',true);
                $('#fecha_resuelto').prop('disabled',true);
            }
            else {
                $('#fecha_salida').prop('disabled',false);
                $('#nro_resuelto').prop('disabled',false);
                $('#fecha_resuelto').prop('disabled',false);
            }
        });

        $('#fecha_salida').on('change', function(e){
            var fecha_inicio = $('#fecha_ingreso').val();
            var fecha_salida = e.target.value;

            if (fecha_salida < fecha_inicio) {
                alert('La Fecha De Egreso No Puede Ser Mayor A La De Graduación, Por Favor Verifique!');
                $('#fecha_ingreso').val();
                $('#fecha_salida').val();
            }
            else {
                var añoinicio = new Date(fecha_inicio) / 31557600000;
                var añoegreso = new Date(fecha_salida) / 31557600000;

                var final = Math.trunc(añoegreso - añoinicio);//año
                $('#año_antiguedad').val(final);

                var mes_inicio = new Date(fecha_inicio).getMonth()+1;
                var mes_egreso = new Date(fecha_salida).getMonth()+1;

                var dia_ini = new Date(fecha_inicio).getDate();
                var dia_fin = new Date(fecha_salida).getDate();

                if (dia_fin >= dia_ini) {
                    if (mes_egreso >= mes_inicio) {
                        var final = mes_egreso - mes_inicio;
                    }
                    else {
                        var final = (12 - mes_inicio) + mes_egreso;
                    }
                }
                else {
                    if (mes_egreso >= mes_inicio) {
                        var final = mes_egreso - mes_inicio - 1;
                    }
                    else {
                        var final = (12 - mes_inicio) + mes_egreso - 1;
                    }
                }

                $('#meses_antiguedad').val(final);
                return final;
            }
        })

        inicializar();
    });

    function inicializar() {
        var causa_egreso = $('#causa_egreso').val();
        if(causa_egreso == '') {
            $('#fecha_salida').prop('disabled',true);
            $('#nro_resuelto').prop('disabled',true);
            $('#fecha_resuelto').prop('disabled',true);
        }
    }
</script>
@endsection