@extends('layouts.user_type.auth')
@section('title', 'Perfil')
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
                        <h5 class="mb-0">Perfil Usuario</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('dashboard') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::model($profile, ['method' => 'POST', 'enctype'=>'multipart/form-data', 'route' => ['profile.update', $user->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Foto:</strong>
                            <input type="file" placeholder="Foto" name="foto" id="imgInp">
                            <img style="visibility:hidden"  id="prview" src=""  width=100 height=100 />
                            @if ($profile && $profile->foto)
                            <img height="100" width=100 src="{{asset($profile->foto)}}"  id="foto_preview"/>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Cédula:</strong>
                            {!! Form::text('cedula', null, array('placeholder' => 'Cédula','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombres:</strong>
                            {!! Form::text('nombres', null, array('placeholder' => 'Nombres','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Apellidos:</strong>
                            {!! Form::text('apellidos', null, array('placeholder' => 'Apellidos','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {!! Form::text('telefono', null, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                        </div>
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
    $(function (){
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                prview.style.visibility = 'visible';
                if (typeof foto_preview !== 'undefined')
                    foto_preview.style.visibility = 'hidden';
                prview.src = URL.createObjectURL(file)
            }
        }
    });
</script>
@endsection