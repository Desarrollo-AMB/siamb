@extends('layouts.user_type.auth')
@section('title', 'SIREH')
@section('content')
    {{-- @include('sireh.buttonsbar') --}}
    @if ($message = Session::get('success'))
    <div class="alert alert-success mx-4" role="alert">
        <span class="text-white">{{ $message }}</span>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Ingreso de Personal</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('dashboard') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(['method' => 'POST', 'enctype'=>'multipart/form-data', 'route' => ['sireh.registra-personal']]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="avatar-wrapper">
                            <img class="profile-pic" src="" />
                            <div class="upload-button">
                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                            </div>
                            <input class="file-upload" type="file" accept="image/*" name="foto"  id="imgInp"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <strong>Cédula:</strong>
                            <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" required >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <strong>Nombres:</strong>
                            {!! Form::text('nombres', null, array('placeholder' => 'Nombres','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <strong>Apellidos:</strong>
                            {!! Form::text('apellidos', null, array('placeholder' => 'Apellidos','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {!! Form::text('telefono', null, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                        </div>
                    </div>
                                       
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Registrar</button>
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
        //Para la foto
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
        //////////////////////////////////
    });
</script>
@endsection