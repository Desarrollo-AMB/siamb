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
                        <h5 class="mb-0">Editar Ubicacion</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('auxiliares.ubicaciones.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::model($ubicaciones, ['method' => 'PATCH','route' => ['auxiliares.ubicaciones.update', $ubicaciones->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Codigo Ubicacion:</strong>
                            {!! Form::text('codigo_ubicacion', $ubicaciones->codigo_ubicacion, array('placeholder' => 'Codigo','class' => 'form-control','disabled'=>'disabled',  'id'=>'codigo_cargo')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <strong>Nombre de la Ubicacion:</strong>
                            {!! Form::text('descripcion', $ubicaciones->descripcion, array('placeholder' => 'Nombre','class' => 'form-control', 'id'=>'descripcion')) !!}
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Tipo Unidad:</strong>
                            {!! Form::select('tipo_unidad', $tipo_unidad,$ubicaciones->tipo_unidad, array('id'=>'tipo_unidad','class' => 'form-control select2',)) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Base:</strong>
                            <select class="form-control select2" name="base" id="base" >
                                @foreach ($bases as $row)
                                    <option value="{{$row->codigo_base}}" {{$ubicaciones->base == $row->codigo_base ? 'selected': '' }} >{{ $row->descripcion }} </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Estado:</strong>
                            <select class="form-control select2" name="codigo_estado" id="codigo_estado" >
                                @foreach ($estados as $row)
                                    <option value="{{$row->id_estado}}" {{$ubicaciones->codigo_estado == $row->id_estado ? 'selected': '' }} >{{ $row->estado }} </option>
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
                                    <option value="{{$value}}" {{$ubicaciones->redi==$value? 'selected': '' }} >{{ $value }} </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>ZODI:</strong>
                            <select class="form-control select2" name="zodi" id="zodi" >

                                @foreach ($estados as $row)
                                    <option value="{{$row->estado}}" {{$ubicaciones->zodi == $row->estado ? 'selected': '' }} >{{ $row->estado }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Situacion:</strong>
                            {!! Form::select('situacion', ['ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO'],$ubicaciones->situacion, array('id'=>'situacion','class' => 'form-control select2',)) !!}
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
