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
                        <h5 class="mb-0">Nueva Ubicacion Detallada</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('auxiliares.ubicacionesDetalladas.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'auxiliares.ubicacionesDetalladas.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Codigo Ubicacion:</strong>
                            {!! Form::text('codigo_ubicacion', null, array('placeholder' => 'Codigo','class' => 'codigo_ubicacion form-control','maxlength' =>'12' ,  'id'=>'codigo_ubicacion')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <strong>Nombre de la Ubicacion detallada:</strong>
                            {!! Form::text('descripcion', null, array('placeholder' => 'Nombre','class' => 'form-control', 'id'=>'descripcion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>ubicacion Macro:</strong>
                            <select class="select2 form-control" name="codigo_ubc_nomina" id="codigo_ubc_nomina" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($ubicaciones as $value )
                                <option value="{{$value['codigo_ubicacion'] }}" >{{ $value['descripcion'] }} </option>
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
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Fecha de Creación</strong>
                            {!! Form::Date('fecha_creacion', null, array('placeholder' => 'fecha','class' => 'form-control', 'id'=>'fecha_creacion')) !!}
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
