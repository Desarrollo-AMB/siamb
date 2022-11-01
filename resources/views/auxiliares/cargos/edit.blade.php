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
    <div class="col-10">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar Cargo</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('auxiliares.cargos.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::model($cargo, ['method' => 'PATCH','route' => ['auxiliares.cargos.update', $cargo->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Codigo Cargo:</strong>
                            {!! Form::text('codigo_cargo', $cargo->codigo_cargo, array('placeholder' => 'Codigo','class' => 'form-control','disabled'=>'disabled',  'id'=>'codigo_cargo')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <strong>Nombre del Cargo:</strong>
                            {!! Form::text('nombre_cargo', $cargo->nombre_cargo, array('placeholder' => 'Nombre','class' => 'form-control', 'id'=>'nombre_cargo')) !!}
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Tipo Cargo:</strong>
                            {!! Form::select('tipo_cargo', $clasificacion,$cargo->tipo_cargo, array('id'=>'tipo_cargo','class' => 'form-control select2',)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Situacion:</strong>
                            {!! Form::select('situacion', ['ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO'],$cargo->situacion, array('id'=>'situacion','class' => 'form-control select2',)) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
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
@endsection