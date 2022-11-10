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
                        <h5 class="mb-0">Editar Universidad</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('auxiliares.universidades.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::model($universidades, ['method' => 'PATCH','route' => ['auxiliares.universidades.update', $universidades->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Codigo Universidad:</strong>
                            {!! Form::text('codigo_universidad', $universidades->codigo_universidad, array('placeholder' => 'Codigo','class' => 'form-control','disabled'=>'disabled',  'id'=>'codigo_universidad')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <strong>Nombre de la Universidad:</strong>
                            {!! Form::text('nombre', $universidades->nombre, array('placeholder' => 'Nombre','class' => 'form-control', 'id'=>'nombre')) !!}
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Tipo Universidad:</strong>
                            {!! Form::select('tipo_universidad', $tipo_universidad,$universidades->tipo_universidad, array('id'=>'tipo_universidad','class' => 'form-control select2',)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Adscrita a la Aviación:</strong>
                            {!! Form::select('adscrita_aviacion', ['S'=>'SI','N'=>'NO'], $universidades->adscrita_aviacion, array('id'=>'adscrita_aviacion','class' => 'form-control select2',)) !!}
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
