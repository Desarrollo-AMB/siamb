@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
@section('content')
@if (session()->has('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div id="error-message" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row">
    <div class="col-10">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar Deducción</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('users.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2"> 
                {!! Form::model($id, ['method' => 'PATCH','route' => ['sireh.nomina.NoProf.updateDeducciones', $id]]) !!}
                <div class="row">
                    {{--<div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Nombre','class' => 'form-control')) !!}
                        </div>
                    </div>--}}
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Codigo de Deducción:</strong>
                            {!! Form::text('codigo_concepto', null, array('placeholder' => 'codigo_concepto','class' => 'form-control','disabled' => 'disabled')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Descripción:</strong>
                            {!! Form::text('descripcion', null, array('placeholder' => 'descripcion','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Porcentaje:</strong>
                            {!! Form::number('porcentaje', null, array('placeholder' => 'porcentaje','class' => 'form-control','step'=>"any")) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    </div>
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
    setTimeout(function() {
        var successMessage = document.getElementById("success-message");
        if (successMessage) {
            successMessage.style.display = "none";
        }

        var errorMessage = document.getElementById("error-message");
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    }, 2000); // 5000 milisegundos = 5 segundos
</script>
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
