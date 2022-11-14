@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
@section('content')

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
                            <h5 class="mb-0">Escalafon AMB</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.personal-militar.index') }}">Volver</a>
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
                    <form class="row g-3 requires-validation" method="post" action="{{route('sireh.personal-militar.imprimirescalafon')}}" enctype="multipart/form-data" >
                        @csrf
                        <!-- DATOS PERSONALES -->
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group">
                                                    <h6>Grado Militar:</h6>
                                                    <select class="select2 form-control" name="grado_militar" id="grado_militar">
                                                        <option value="">SELECCIONE...</option>
                                                        @foreach ($grados_militares as $row)
                                                            <option value="{{$row->codigo_grado}}">{{ $row->descripcion }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BOTON PARA GENERAR ESCALAFON -->
                        <div class="row">    
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" id="btn-escalafon">Generar Escalafon</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--@section('scripts')
<script>
    $(function (){
        $('.select2').select2();

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

        $('#causa_egreso').on('change', function(e){
            var causa_egreso = e.target.value;
            if (causa_egreso === "") {
                $('#fecha_salida').prop('disabled',true);
                $('#nro_resuelto').prop('disabled',true);
                $('#fecha_resuelto').prop('disabled',true);
            }
            else {
                $('#fecha_salida').prop('disabled',false);
                $('#nro_resuelto').prop('disabled',false);
                $('#fecha_resuelto').prop('disabled',false);
            }
        });

        $('#fecha_salida').on('change', function(e){
            var fecha_inicio = $('#fecha_ingreso').val();
            var fecha_salida = e.target.value;

            if (fecha_salida < fecha_inicio) {
                alert('La Fecha De Egreso No Puede Ser Mayor A La De Graduación, Por Favor Verifique!');
                $('#fecha_ingreso').val();
                $('#fecha_salida').val();
            }
            else {
                var añoinicio = new Date(fecha_inicio) / 31557600000;
                var añoegreso = new Date(fecha_salida) / 31557600000;

                var final = Math.trunc(añoegreso - añoinicio);//año
                $('#año_antiguedad').val(final);

                var mes_inicio = new Date(fecha_inicio).getMonth()+1;
                var mes_egreso = new Date(fecha_salida).getMonth()+1;

                var dia_ini = new Date(fecha_inicio).getDate();
                var dia_fin = new Date(fecha_salida).getDate();

                if (dia_fin >= dia_ini) {
                    if (mes_egreso >= mes_inicio) {
                        var final = mes_egreso - mes_inicio;
                    }
                    else {
                        var final = (12 - mes_inicio) + mes_egreso;
                    }
                }
                else {
                    if (mes_egreso >= mes_inicio) {
                        var final = mes_egreso - mes_inicio - 1;
                    }
                    else {
                        var final = (12 - mes_inicio) + mes_egreso - 1;
                    }
                }

                $('#meses_antiguedad').val(final);
                return final;
            }
        })

        inicializar();
    });

    function inicializar() {
        var causa_egreso = $('#causa_egreso').val();
        if(causa_egreso == '') {
            $('#fecha_salida').prop('disabled',true);
            $('#nro_resuelto').prop('disabled',true);
            $('#fecha_resuelto').prop('disabled',true);
        }
    }
</script>
@endsection--}}