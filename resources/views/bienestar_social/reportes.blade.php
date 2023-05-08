@extends('layouts.user_type.auth')
@section('title', 'Bienestar Social')
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
                            <h5 class="mb-0">Reportes Bienestar Social</h5>
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
                                                            Reporte de Devolucion del 5%
                                                        </label>
                                                    </div>
                                                </div>

                                                <form id="formDevolucion5" action="{{ route('bienestar-social.reporte.devolucion5')}}" method="POST" class="row" target="_blank">
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
                                                        <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault2" value="2">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            Reporte de Carga Familiar
                                                        </label>
                                                    </div>
                                                </div>

                                                <form id="formCargaFamiliar" action="{{route('bienestar-social.reporte.cargafamiliar')}}" method="POST" class="row" target="_blank">
                                                    @csrf
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div id="Parametros2" class="parametros" style="display: none;">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <h6 class="col-sm-4 col-form-label">Reporte a Expulsar:</h6>
                                                                    <div class="col-sm-4">
                                                                        <select name="lista1" id="lista1" class="select2 form-control" disabled="disabled">
                                                                            <option value="">SELECCIONE...</option>
                                                                            <option value="1">0 a 12 años</option>
                                                                            <option value="2">0 a 26 años</option>
                                                                            <option value="3">Madres AMB</option>
                                                                            <option value="4">Padres AMB</option>
                                                                            <option value="5">Matriz Completa</option>
                                                                            <option value="6">Por Fecha</option>
                                                                        </select>

                                                                        <div id="Fecha" class="fecha" style="display: none">
                                                                            <strong>Desde</strong>
                                                                            <input type="date" name="desde" id="desde" class="form-control">

                                                                            <strong>Hasta</strong>
                                                                            <input type="date" name="hasta" id="hasta" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button id="ejecutar" value="1" class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
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
                                                        <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault2" value="3">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            Reporte de Bajas
                                                        </label>
                                                    </div>
                                                </div>

                                                <form id="formBajas" action="{{ route('bienestar-social.reporte.bajas')}}" method="POST" class="row" target="_blank">
                                                    @csrf
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div id="Parametros3" class="parametros" style="display: none;">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <h6 class="col-sm-4 col-form-label">Reporte a Expulsar:</h6>
                                                                    <div class="col-sm-4">
                                                                        <select name="lista2" id="lista2" class="select2 form-control" disabled="disabled">
                                                                            <option value="">SELECCIONE...</option>
                                                                            <option value="1">ESPECIALIDAD</option>
                                                                            <option value="2">GRADO</option>
                                                                            <option value="3">CATEGORIA</option>
                                                                            <option value="4">SEXO</option>
                                                                            <option value="5">TIPO EGRESO</option>
                                                                            <option value="6">FECHA EGRESO</option>
                                                                        </select>

                                                                        <div id="div1" style="display: none">
                                                                            <select id="especialidad" name="especialidad" class="select2 form-control">
                                                                                <option value="">SELECCIONE...</option>
                                                                                @foreach ($especialidades_militares as $row)
                                                                                    <option value="{{$row->codigo_especialidad}}">{{ $row->descripcion }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div id="div2" style="display: none">
                                                                            <select id="grado" name="grado" id="grado" class="select2 form-control">
                                                                                <option value="">SELECCIONE...</option>
                                                                                @foreach ($grados_militares as $row)
                                                                                    <option value="{{$row->codigo_grado}}">{{ $row->descripcion }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div id="div3" style="display: none">
                                                                            <select id="categoria" name="categoria" id="categoria" class="select2 form-control">
                                                                                <option value="">SELECCIONE...</option>
                                                                                @foreach ($categorias_militares as $row)
                                                                                    <option value="{{$row->codigo_categoria}}">{{ $row->descripcion }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div id="div4" style="display: none">
                                                                            <select id="sexo" name="sexo" id="sexo" class="select2 form-control">
                                                                                <option value="">SELECCIONE...</option>
                                                                                @foreach ($generos as $key=>$value)
                                                                                    <option value="{{$key}}" >{{ $value }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div id="div5" style="display: none">
                                                                            <select id="tipo_egreso" name="tipo_egreso" id="tipo_egreso" class="select2 form-control">
                                                                                <option value="">SELECCIONE...</option>
                                                                                @foreach ($tipo_egreso as $row)
                                                                                    <option value="{{$row->codigo_egreso}}">{{ $row->descripcion }} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div id="div6" style="display: none">
                                                                            <strong>Desde</strong>
                                                                            <input type="date" name="desde1" id="desde1" class="form-control">

                                                                            <strong>Hasta</strong>
                                                                            <input type="date" name="hasta1" id="hasta1" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button id="ejecutar1" value="1" class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
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
