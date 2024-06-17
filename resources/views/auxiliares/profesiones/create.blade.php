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
                        <h5 class="mb-0">Nueva Profesión</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('auxiliares.profesiones.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'auxiliares.profesiones.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <strong>Codigo Profesión:</strong>
                            {!! Form::text('codigo_profesion', null, array('placeholder' => 'Codigo','class' => 'codigo_profesion form-control',  'id'=>'codigo_profesion', 'maxlength' => '4')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <strong>Nombre de la Profesión:</strong>
                            {!! Form::text('descripcion', null, array('placeholder' => 'Descripcion','class' => 'form-control', 'id'=>'descripcion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
        jQuery('.codigo_profesion').keypress(function(tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });
    });
</script>
@endsection
