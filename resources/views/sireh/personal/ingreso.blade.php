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
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Tipo Empleado:</h6>
                            <select class="select2 form-control" name="tipo_emp" id="tipo_emp" required>
                                <option value=""
                                    >Seleccione ...</option>
                                @foreach ($tipos_emp as $row)
                                    <option value="{{$row->tipo_emp}}"
                                    >{{ $row->descripcion }} ({{ $row->tipo_emp}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Cédula:</h6>
                            <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" required >
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Primer Nombre:</h6>
                            {!! Form::text('nombre1', null, array('placeholder' => 'Primer Nombre','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Segundo Nombre:</h6>
                            {!! Form::text('nombre2', null, array('placeholder' => 'Segundo Nombre','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Primer Apellido:</h6>
                            {!! Form::text('apellido1', null, array('placeholder' => 'Primer Apellido','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Segundo Apellido:</h6>
                            {!! Form::text('apellido2', null, array('placeholder' => 'Segundo Apellido','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">   
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Fecha Nacimiento: <small></small></h6>
                            <input name="fecha" type="date" class="form-control fecha load_fecha" >
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Sexo:</h6>
                            <select class="select2 form-control" name="genero" id="genero" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($generos as $key=>$value)
                                    <option value="{{$key}}" >{{ $value }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Estado Civil:</h6>
                            <select class="select2 form-control" name="edo_civil" id="edo_civil" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($edos_civil as $key=>$value)
                                    <option value="{{$key}}" >{{ $value }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                    
                </div>
                <div class="row">    
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Telefono:</h6>
                            {!! Form::text('telefono_cel', null, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Telefono Casa:</h6>
                            {!! Form::text('telefono', null, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Telefono Oficina:</h6>
                            {!! Form::text('telefono_ofi', null, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Correo:</h6>
                            {!! Form::text('correo', null, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Estado:</h6>
                            <select class="select2 form-control" name="estado" id="estado" required>
                                <option value="">Seleccione ...</option>
                                @foreach ($estados as $row)
                                    <option value="{{$row->id_estado}}" >{{ $row->estado }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Ciudad:</h6>
                            <select class="select2 form-control" name="ciudad" id="ciudad" required>
                                <option value="">...</option>
                              
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <h6>Direccion:</h6>
                            {!! Form::text('direccion', null, array('placeholder' => 'Telefono','class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">    
                    
                </div>
                <div class="row">    
                    
                    </div>

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
        $('.select2').select2();

        $('#estado').on('change', function(e){
            var estado = e.target.value;
            $.get('/api/ciudades/' + estado,function(data) {
                $('#ciudad').empty();
                $.each(data, function(fetch, ciudad){          
                    $('#ciudad').append('<option value="'+ ciudad.id +'">'+ ciudad.ciudad +'</option>');
                });
            });
        });
    });
</script>
@endsection