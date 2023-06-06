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
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="avatar-wrapper">
                                    @if ($profile && $profile->foto)
                                        <img class="profile-pic" src="{{asset($profile->foto)}}"/>
                                    @else
                                        <img class="profile-pic" src="" />
                                    @endif
                                  

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Cédula:</strong>
                                    {!! Form::text('cedula', $profile->cedula, array('placeholder' => 'Cédula','class' => 'form-control', 'disabled'=>'true')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Primer Nombre:</strong>
                                    {!! Form::text('nombre1', $profile->nombre1, array('placeholder' => 'Nombres','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Segundo Nombre:</strong>
                                    {!! Form::text('nombre2', $profile->nombre2, array('placeholder' => 'Nombres','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Primer Apellido:</strong>
                                    {!! Form::text('apellido1', $profile->apellido1, array('placeholder' => 'Apellidos','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Segundo Apellido:</strong>
                                    {!! Form::text('apellido2', $profile->apellido2, array('placeholder' => 'Apellidos','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Telefono:</strong>
                                    {!! Form::text('telefono', $profile->telefono, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                                </div>
                            </div>
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
        /*imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                prview.style.visibility = 'visible';
                if (typeof foto_preview !== 'undefined')
                    foto_preview.style.visibility = 'hidden';
                prview.src = URL.createObjectURL(file)
            }
        }*/
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".file-upload").on('change', function(){
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });
    });
</script>
@endsection
