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
                    <a class="btn btn-secondary btn-sm mb-0"
                        href="{{ route('sireh.ingreso-personal.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                @if (count($errors) > 0)
                <div class="alert alert-danger mx-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="row g-3 requires-validation" name="registro-personal" id="registro-personal" method="post"
                    action="{{route('extra.registrar')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 pt-2">
                            <div class="form-group">
                                <h6>Tipo Empleado:</h6>
                                <select class="select2 form-control" name="tipo_emp" id="tipo_emp" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach ($tipos_emp as $row)
                                    <option value="{{$row->tipo_emp}}">{{ $row->descripcion }} ({{ $row->tipo_emp}})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-1 pb-1 position-relative">
                                    <h5 class="card-title">Datos Personales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Nacionalidad:</h6>
                                                <select class="select2 form-control registrar" name="nacionalidad"
                                                    id="nacionalidad" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($nacionalidades as $key=>$value)
                                                    <option value="{{$key}}">{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Cédula:</h6>
                                                <input id="cedula" type="text"
                                                    class="form-control @error('cedula') is-invalid @enderror"
                                                    name="cedula" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Primer Nombre:</h6>
                                                {!! Form::text('nombre1', null, array('placeholder' => 'Primer
                                                Nombre','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Segundo Nombre:</h6>
                                                {!! Form::text('nombre2', null, array('placeholder' => 'Segundo
                                                Nombre','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Primer Apellido:</h6>
                                                {!! Form::text('apellido1', null, array('placeholder' => 'Primer
                                                Apellido','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Segundo Apellido:</h6>
                                                {!! Form::text('apellido2', null, array('placeholder' => 'Segundo
                                                Apellido','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Fecha Nacimiento: <small></small></h6>
                                                <input name="fecha_nacim" type="date" class="form-control fecha"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Sexo:</h6>
                                                <select class="select2 form-control registrar" name="genero" id="genero"
                                                    required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($generos as $key=>$value)
                                                    <option value="{{$key}}">{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado Civil:</h6>
                                                <select class="select2 form-control registrar" name="edo_civil"
                                                    id="edo_civil" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($edos_civil as $key=>$value)
                                                    <option value="{{$key}}">{{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Telefono:</h6>
                                                {!! Form::text('telefono_cel', null, array('placeholder' =>
                                                'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Telefono Casa:</h6>
                                                {!! Form::text('telefono', null, array('placeholder' =>
                                                'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Correo:</h6>
                                                {!! Form::text('correo', null, array('placeholder' => 'Telefono','class'
                                                => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Estado:</h6>
                                                <select class="select2 form-control registrar" name="estado"
                                                    id="estado">
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($estados as $row)
                                                    <option value="{{$row->id_estado}}">{{ $row->estado }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Ciudad:</h6>
                                                <select class="select2 form-control registrar" name="ciudad"
                                                    id="ciudad">
                                                    <option value="">...</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <h6>Direccion:</h6>
                                                {!! Form::text('direccion', null, array('placeholder' =>
                                                'Telefono','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Laborales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                <h6>Fecha Ingreso: <small></small></h6>
                                                <input name="fecha_ingreso" id="fecha_ingreso" type="date"
                                                    class="form-control fecha" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="form-group">
                                                <h6>Ubicación:</h6>
                                                <select class="select2 form-control registrar" name="ubicacion"
                                                    id="ubicacion" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($ubicaciones as $row)
                                                    <option value="{{$row->codigo_ubicacion}}">{{ $row->descripcion }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card d-none" id="div-militar">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Datos Militares</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6>Grado Militar:</h6>
                                                <select class="select2 form-control" name="grado_militar"
                                                    id="grado_militar">
                                                    <option value="">...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6>Componente:</h6>
                                                <select class="select2 form-control registrar" name="componente"
                                                    id="genero" required>
                                                    <option value="">Seleccione ...</option>
                                                    @foreach ($componentes as $key => $value)
                                                    <option value="{{$key}}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Otros Datos</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                            <div class="form-group">
                                                <h6>Nombre y Apellido (contacto de emergencia):</h6>
                                                {!! Form::text('persona_contacto', null, array('placeholder' =>
                                                '','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <h6>Telefono (contacto de emergencia):</h6>
                                                {!! Form::text('telefono_e', null, array('placeholder' =>
                                                '','class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="avatar-wrapper">
                                <img class="profile-pic" src="" />
                                <div class="upload-button">
                                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                </div>
                                <input class="file-upload" type="file" accept="image/*" name="foto" id="foto" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary" id="btn-registrar">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function (){
        $('.nivel_instruccion').hide();
        $('.obrero').hide();
        $('.cargo').hide();
        $("input").prop( "disabled", true );
        $("select.registrar").prop( "disabled", true );
        $("#btn-registrar").prop( "disabled", true );
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
                    $('#ciudad').append('<option value="'+ ciudad.ciudad +'">'+ ciudad.ciudad +'</option>');
                });
            });
        });

        $("#tipo_emp").on('change', function(){
            var tipo_emp = this.value;
            if (tipo_emp == 'MEF' || tipo_emp == 'ALI' || tipo_emp == 'MIL' || tipo_emp == 'TRP'){
                $('#div-militar').removeClass('d-none');
                $('#div-militar #grado_militar').attr('required');
                $.get('/api/grados-militares/' + tipo_emp,function(data) {
                    $('#grado_militar').empty();
                    $.each(data, function(fetch, grado){
                        $('#grado_militar').append('<option value="'+ grado.codigo_grado +'">'+ grado.descripcion +'</option>');
                    });
                });
                contingente(tipo_emp, $('#fecha_ingreso').val());
                $('.cargo').hide();
            }else{
                $('.cargo').show();
                $('#div-militar').addClass('d-none');
                $('#div-militar #grado_militar').removeAttr('required');
                if (tipo_emp == 'OBR'){

                    $('.obrero #grado_obr').attr('required');
                    $('.obrero #clasificacion').attr('required');
                    $('.obrero').show();
                }else{
                    $('.obrero').hide();
                    $('.obrero #grado_obr').removeAttr('required');
                    $('.obrero #clasificacion').removeAttr('required');
                }
            }
            if(tipo_emp!=''){
                $( "input" ).prop( "disabled", false );
                $( "select.registrar" ).prop( "disabled", false );
                $("#btn-registrar").prop( "disabled", false );
            }else{
                $( "input" ).prop( "disabled", true );
                $( "select.registrar" ).prop( "disabled", true );
                $("#btn-registrar").prop( "disabled", true );
            }
        });

        $('#fecha_ingreso').on('change', function(e){
            var tipo_emp = $('#tipo_emp').val();
            if (tipo_emp == 'MEF' || tipo_emp == 'ALI' || tipo_emp == 'MIL' || tipo_emp == 'TRP'){
                contingente(tipo_emp, this.value);
            }
        });

        $("#nivel").on('change', function(){
            var nivel_instruccion = $(this).find(':selected').attr('data-nivel');
            if (nivel_instruccion>=5){
                $('.nivel_instruccion').show();
            }else{
                $('.nivel_instruccion').hide();
            }
        });

        const forms = $('.requires-validation')
        Array.from(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
    });

    function contingente(tipo_emp, fecha_ingreso=null) {
        if (tipo_emp == 'ALI') {
            if (fecha_ingreso){
                var mes = new Date(fecha_ingreso).getMonth()+1;
                if (mes<5) {
                    var mes2 = '1';
                }
                else if (mes>4 && mes<9) {
                    var mes2 = '2';
                }
                else if (mes>8 && mes<=12) {
                    var mes2 = '3';
                }
                var año = new Date(fecha_ingreso).getFullYear().toString();
                var final = año.slice(-2);
                var valor2 = mes2+""+final;
                $('#contingente').val(valor2);
            }else {
                $('#contingente').val('');
            }
        }else {
            $('#contingente').val('');
        }
    }
</script>
@endsection
