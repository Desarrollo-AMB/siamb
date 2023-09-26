@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
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
            <br>
            <a class="btn btn-secondary btn-sm mb-0" style="position: absolute; top: 10px; right: 10px; font-size: 12px; padding: 7px 30px;" href="{{ route('sireh.nomina.no_profesional') }}">Volver</a>
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar porcentaje de la Racion por jerarquia</h5>
                    </div>
                </div>
                <hr class="horizontal dark my-4"> 
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'sireh.nomina.noProf.editSueldosNoProf','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @php
                            $salariosCount = count($salarios);
                            $halfSalariosCount = ceil($salariosCount / 2);
                        @endphp
                        @foreach ($salarios->take($halfSalariosCount) as $salario)
                            <div class="form-group">
                                <label for="porcentaje_{{ $salario->id }}">{{ $salario->descripcion }}</label>
                                <input type="text" name="porcentaje_{{ $salario->id }}" value="{{ $salario->porcentaje }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @foreach ($salarios->slice($halfSalariosCount) as $salario)
                            <div class="form-group">
                                <label for="porcentaje_{{ $salario->id }}"> {{ $salario->descripcion }}</label>
                                <input type="text" name="porcentaje_{{ $salario->id }}" value="{{ $salario->porcentaje }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary w-30">Actualizar</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        $('#roles').select2({
            allowClear: true,
            minimumResultsForSearch: -1,
            width: 300
        });
    });
</script>
@endsection
