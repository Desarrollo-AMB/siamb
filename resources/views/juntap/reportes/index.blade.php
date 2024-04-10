{{--@extends('layouts.user_type.auth')
@section('title', 'Personal Civil')
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
                        <h5 class="mb-0">Reportes</h5>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="row justify-content-end" 
          style="display: flex;
          flex-wrap: wrap;
          justify-content: center!important;"  
        >
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" style="
                margin-bottom: 10px!important;">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('juntap.reportehistorico')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Reporte Histórico Ascenso

                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#cc886f,#ee1505)" class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                    <i class="fas fa-user-times text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" style="
                margin-bottom: 10px!important;">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{route('sireh.personal-civil.evaluaciones.index')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Reporte Historial

                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#a7e9b0,#087904)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fa fa-file-excel text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" style="
                margin-bottom: 10px!important;">
                    <div class="card">
                        <div class="card-body p-3">
                            <a href="{{ route('sireh.personal-civil-jubilables.index')}}">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                            <p class="font-weight-bolder mb-0">
                                                Promedio de Calificaciones

                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div style="background-image:linear-gradient(310deg,#3a9c9b,#087904)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fa fa-house-user text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" style="
                margin-bottom: 10px!important;">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('sireh.personal-civil.noActive')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Nomina Inicial de Ascenso

                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#cc886f,#ee1505)" class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                    <i class="fas fa-user-times text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" style="
                margin-bottom: 10px!important;">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('juntap.reportes.reporteascenso')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                       Personal Tentativo Ascenso
                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#cc886f,#ee1505)" class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                    <i class="fas fa-user-times text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            
            </div>
        </div>
    </div>
</div>
@endsection--}}
@extends('layouts.user_type.auth')
@section('title', 'Junta Permanente')
@section('style')
<style>

</style>
@endsection
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
                            <h5 class="mb-0">Reportes Junta Permanente</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ URL::previous() }}">Volver</a>
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

                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault1" checked="checked" value="1">
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            Reporte Histórico de Ascenso
                                                        </label>
                                                    </div>
                                                </div>

                                                <form id="formDevolucion5" action="{{ route('juntap.reportehistorico')}}" method="POST" class="row" target="_blank">
                                                    @csrf
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div id="Parametros1" class="parametros ">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <h6 class="col-sm-4 col-form-label">Cédula:</h6>
                                                                    <div class="col-sm-4">
                                                                        <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" value="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>

                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault1" checked="checked" value="1">
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            Resumen Digital del Historial
                                                        </label>
                                                    </div>
                                                </div>

                                                <form id="formDevolucion5" action="{{ route('juntap.historial')}}" method="POST" class="row" target="_blank">
                                                    @csrf
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div id="Parametros2" class="parametros2 ">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <h6 class="col-sm-4 col-form-label">Cédula:</h6>
                                                                    <div class="col-sm-4">
                                                                        <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" value="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>

                                        {{--<li class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault1" checked="checked" value="1">
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            Nómina Inicial de Evaluación para Ascenso
                                                        </label>
                                                    </div>
                                                </div>

                                                <form id="formDevolucion5" action="{{ route('bienestar-social.reporte.devolucion5')}}" method="POST" class="row" target="_blank">
                                                    @csrf
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div id="Parametros3" class="parametros3 ">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <h6 class="col-sm-4 col-form-label">Cédula:</h6>
                                                                    <div class="col-sm-4">
                                                                        <input id="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" value="">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(function (){
        $('.select2').select2();
        $("input[name$='reporte']").click(function() {
            var test = $(this).val();

            $("div.parametros").hide();
            $("div.parametros *").attr("disabled", true);
            $("div.parametros").prop('disabled', 'disabled');
            $("div.parametros2 *").attr("disabled", false);
            $("div.parametros2").prop('disabled', 'disabled');
            $("#Parametros2" + test).show();
            $("#Parametros2" + test+' *').prop("disabled", true);
            $("#Parametros" + test).show();
            $("#Parametros" + test+' *').prop("disabled", false);
        });

        $("#lista1").on('change', function() {
            var test = $(this).val();

            if (test == 6) {
                $("#Fecha").show();

                $("#ejecutar").click(function() {
                    var desde = $("#desde").val();
                    var hasta = $("#hasta").val();

                    if (desde == "" || hasta == "") {
                        alert("Los Campos Desde o Hasta estan Vacios");
                        window.location.reload();
                    }
                });
            }
            else {
                $("#Fecha").hide();
            }
        });

        $("#lista2").on('change', function() {
            var test = $(this).val();
            console.log(test);

            switch (test) {
                case '1':
                $("#div1").show();
                $("#div2").hide();
                $("#div3").hide();
                $("#div4").hide();
                $("#div5").hide();
                $("#div6").hide();

                $("#ejecutar1").click(function() {
                    var valor = $("#especialidad").val();

                    if (valor == "") {
                        alert("Los Campos No Pueden Estar Vacios");
                        window.location.reload();
                    }
                });
                break;

                case '2':
                $("#div1").hide();
                $("#div2").show();
                $("#div3").hide();
                $("#div4").hide();
                $("#div5").hide();
                $("#div6").hide();

                $("#ejecutar1").click(function() {
                    var valor = $("#grado").val();

                    if (valor == "") {
                        alert("Los Campos No Pueden Estar Vacios");
                        window.location.reload();
                    }
                });
                break;

                case '3':
                $("#div1").hide();
                $("#div2").hide();
                $("#div3").show();
                $("#div4").hide();
                $("#div5").hide();
                $("#div6").hide();

                $("#ejecutar1").click(function() {
                    var valor = $("#categoria").val();

                    if (valor == "") {
                        alert("Los Campos No Pueden Estar Vacios");
                        window.location.reload();
                    }
                });
                break;

                case '4':
                $("#div1").hide();
                $("#div2").hide();
                $("#div3").hide();
                $("#div4").show();
                $("#div5").hide();
                $("#div6").hide();

                $("#ejecutar1").click(function() {
                    var valor = $("#sexo").val();

                    if (valor == "") {
                        alert("Los Campos No Pueden Estar Vacios");
                        window.location.reload();
                    }
                });
                break;

                case '5':
                $("#div1").hide();
                $("#div2").hide();
                $("#div3").hide();
                $("#div4").hide();
                $("#div5").show();
                $("#div6").hide();

                $("#ejecutar1").click(function() {
                    var valor = $("#tipo_egreso").val();

                    if (valor == "") {
                        alert("Los Campos No Pueden Estar Vacios");
                        window.location.reload();
                    }
                });
                break;

                case '6':
                $("#div1").hide();
                $("#div2").hide();
                $("#div3").hide();
                $("#div4").hide();
                $("#div5").hide();
                $("#div6").show();

                $("#ejecutar1").click(function() {
                    var desde1 = $("#desde1").val();
                    var hasta1 = $("#hasta1").val();

                    if (desde1 == "" || hasta1 == "") {
                        alert("Los Campos Desde o Hasta estan Vacios");
                        window.location.reload();
                    }
                });
                break;

                default:
                $("#div1").hide();
                $("#div2").hide();
                $("#div3").hide();
                $("#div4").hide();
                $("#div5").hide();
                $("#div6").hide();
                break;
            }
        });
    });
</script>
@endsection