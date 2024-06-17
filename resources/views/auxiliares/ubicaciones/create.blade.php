@extends('layouts.user_type.auth')

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
<div class="row">
    <div class="col-8">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Nueva Ubicacion</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('auxiliares.ubicaciones.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'auxiliares.ubicaciones.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Codigo Ubicacion:</strong>
                            {!! Form::text('codigo_ubicacion', null, array('placeholder' => 'Codigo','class' => 'codigo_ubicacion form-control','maxlength' =>'6' ,  'id'=>'codigo_ubicacion')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <strong>Nombre de la Ubicacion:</strong>
                            {!! Form::text('descripcion', null, array('placeholder' => 'Nombre','class' => 'form-control', 'id'=>'descripcion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Tipo unidad:</strong>
                            <select class="select2 form-control" name="tipo_unidad" id="tipo_unidad" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($tipo_unidad as $key=>$value)
                                    <option value="{{$key}}" >{{ $value }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Base:</strong>
                            <select class="select2 form-control" name="base" id="base" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($bases as $value )
                                    <option value="{{$value['codigo_base']}}" >{{ $value['descripcion'] }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Estado:</strong>
                            <select class="select2 form-control" name="codigo_estado" id="codigo_estado" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($estados as $value )
                                    <option value="{{$value['id_estado']}}" >{{ $value['estado'] }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>REDI:</strong>
                            <select class="select2 form-control" name="redi" id="redi" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($redi as $value)
                                    <option value="{{$value}}" >{{ $value }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>ZODI:</strong>
                            <select class="select2 form-control" name="zodi" id="zodi" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($estados as $value )
                                <option value="{{$value['estado'] }}" >{{ $value['estado'] }} </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Situacion:</strong>
                            <select class="select2 form-control" name="situacion" id="situacion" required>
                                <option value="ACTIVO" >ACTIVO</option>
                                <option value="INACTIVO" >INACTIVO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
                {!! Form::close() !!}
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
<script>
    jQuery(document).ready(function() {
    jQuery('.codigo_ubicacion').keypress(function(tecla) {
        if(tecla.charCode < 48 || tecla.charCode > 57) return false;
    });
});
</script>
@endsection
