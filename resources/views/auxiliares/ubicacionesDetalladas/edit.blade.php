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
                            <h5 class="mb-0">Editar Ubicacion Detallada</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('auxiliares.ubicaciones.index') }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    {!! Form::model($ubicacion_detallada, [
                        'method' => 'PATCH',
                        'route' => ['auxiliares.ubicacionesDetalladas.update', $ubicacion_detallada->id],
                    ]) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Codigo Ubicacion:</strong>
                                {!! Form::text('codigo_ubicacion', $ubicacion_detallada->codigo_ubicacion, [
                                    'placeholder' => 'Codigo',
                                    'class' => 'form-control',
                                    'disabled' => 'disabled',
                                    'id' => 'codigo_ubicacion',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <strong>Nombre de la Ubicacion:</strong>
                                {!! Form::text('descripcion', $ubicacion_detallada->descripcion, [
                                    'placeholder' => 'Nombre',
                                    'class' => 'form-control',
                                    'id' => 'descripcion',
                                ]) !!}
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Codigo ubicacion Macro:</strong>
                                <select class="form-control select2" name="codigo_ubic_nomina" id="codigo_ubic_nomina">
                                    @foreach ($ubicaciones as $row)
                                        <option value="{{ $row->codigo_ubicacion }}"
                                            {{ $ubicacion_detallada->codigo_ubic_nomina == $row->codigo_ubicacion ? 'selected' : '' }}>
                                            {{ $row->descripcion }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Situacion:</strong>
                                {!! Form::select(
                                    'situacion',
                                    ['ACTIVO' => 'ACTIVO', 'INACTIVO' => 'INACTIVO'],
                                    $ubicacion_detallada->situacion,
                                    ['id' => 'situacion', 'class' => 'form-control select2'],
                                ) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong>Fecha de Creacion</strong>
                                {!! Form::Date('fecha_creacion', null, [
                                    'placeholder' => 'Nombre',
                                    'class' => 'form-control',
                                    'id' => 'fecha_creacion',
                                ]) !!}
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
        $(function() {
            $('.select2').select2();

        });
    </script>
@endsection
