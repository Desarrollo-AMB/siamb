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
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row">
    <div class="col-8">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Consultar Deducciones</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.nomina.personalcivil.deducciones') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2 text-center" >
                {!! Form::open(array('route' => 'sireh.nomina.personalcivil.actualesdeduciones','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                        <div class="form-group">
                            <strong>Cédula del profesional:</strong>
                            {!! Form::number('cedula', null, array('placeholder' => 'Inserte el numero de cédula del profesional','class' => 'cedula form-control',  'id'=>'cedula', 'maxlength' => '8')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Buscar</button>
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
