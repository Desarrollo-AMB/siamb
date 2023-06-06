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
            <a class="btn btn-secondary btn-sm mb-0" style="position: absolute; top: 10px; right: 10px; font-size: 12px; padding: 7px 30px;" href="{{ route('sireh.nomina.personal_civil.militar') }}">Volver</a>
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar porcentaje del personal OBRERO</h5>
                    </div>
                </div>
                <hr class="horizontal dark my-4"> 
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'sireh.nomina.civil.editSueldoscivil','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @php
                            $salariosCount = count($salarios);
                            $halfSalariosCount = ceil($salariosCount / 2);
                        @endphp
                        @foreach ($salarios->take($halfSalariosCount) as $salario)
                            <div class="form-group">
                                <label for="porcentaje_{{ $salario->id }}">{{ $salario->descripcion }} CON {{ $salario->antiguedad }} AÑOS </label>
                                <input type="number" name="porcentaje_{{ $salario->id }}" value="{{ $salario->porcentaje }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @foreach ($salarios->slice($halfSalariosCount) as $salario)
                            <div class="form-group">
                                <label for="porcentaje_{{ $salario->id }}"> {{ $salario->descripcion }} CON {{ $salario->antiguedad }} AÑOS </label>
                                <input type="number" name="porcentaje_{{ $salario->id }}" value="{{ $salario->porcentaje }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar porcentaje del personal DOCENTE</h5>
                    </div>
                </div>
                <hr class="horizontal dark my-4"> 
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'sireh.nomina.noProf.editSueldosNoProf','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @php
                            $docentesCount = count($docentes);
                            $halfDocentesCount = ceil($docentesCount / 2);
                        @endphp
                        @foreach ($docentes->take($halfDocentesCount) as $docente)
                            <div class="form-group">
                                <label for="porcentaje_{{ $docente->id }}">{{ $docente->descripcion }}  </label>
                                <input type="number" name="porcentaje_{{ $docente->id }}" value="{{ $docente->porcentaje }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @foreach ($docentes->slice($halfDocentesCount) as $docente)
                            <div class="form-group">
                                <label for="porcentaje_{{ $docente->id }}"> {{ $docente->descripcion }}  </label>
                                <input type="number" name="porcentaje_{{ $docente->id }}" value="{{ $docente->porcentaje }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar porcentaje del personal de EMPLEADOS</h5>
                    </div>
                </div>
                <hr class="horizontal dark my-4"> 
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'sireh.nomina.noProf.editSueldosNoProf','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @php
                            $empleadosCount = count($empleados);
                            $halfEmpleadosCount = ceil($empleadosCount / 2);
                        @endphp
                        @foreach ($empleados->take($halfEmpleadosCount) as $empleado)
                            <div class="form-group">
                                <label for="porcentaje_{{ $empleado->id }}">{{ $empleado->descripcion }} CON {{ $empleado->antiguedad }} AÑOS </label>
                                <input type="number" name="porcentaje_{{ $empleado->id }}" value="{{ $empleado->porcentaje }}" class="form-control">
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @foreach ($empleados->slice($halfEmpleadosCount) as $empleado)
                            <div class="form-group">
                                <label for="porcentaje_{{ $empleado->id }}"> {{ $empleado->descripcion }} CON {{ $empleado->antiguedad }} AÑOS </label>
                                <input type="number" name="porcentaje_{{ $empleado->id }}" value="{{ $empleado->porcentaje }}" class="form-control">
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
