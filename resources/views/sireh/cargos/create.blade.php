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
                        <h5 class="mb-0">Nuevo Cargo</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.cargos') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'sireh.cargos.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Codigo Cargo:</strong>
                            {!! Form::text('codigo_cargo', null, array('placeholder' => 'Codigo','class' => 'form-control',  'id'=>'codigo_cargo')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <strong>Nombre del Cargo:</strong>
                            {!! Form::text('nombre_cargo', null, array('placeholder' => 'Nombre','class' => 'form-control', 'id'=>'nombre_cargo')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Tipo Cargo:</strong>
                            <select class="select2 form-control" name="tipo_cargo" id="tipo_cargo" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($clasificacion as $key=>$value)
                                    <option value="{{$key}}" >{{ $value }} </option>
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
@endsection