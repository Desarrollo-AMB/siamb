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
        <div class="col-12">
            <form action="" method="">
                <div class="card mb-4 mx-4">
                    @include('dao.operacionesAereas.programacionVuelo.header_programacion')
                </div>
                <div class="card mb-4 mx-4">
                    <div class="card-body px-2 pt-2 pb-2">
                        <!-- el otro formato -->
                        <div class="row">
                            <input hidden="true" name="ov_ota_om"
                                    style="width: 100%; border: none !important; text-transform: uppercase" type="text"
                                    class="unidad load_unidad" id="grupos" placeholder="" required="true"
                                    value="{{ $unidad[0]->codigos }}">
                            <input hidden="true" name="componente_organismo"
                                style="width: 100%; border: none !important; text-transform: uppercase" type="text"
                                class="mb-0 componente_organismo load_componente_organismo" placeholder=""
                                required="true" value="{{ $componentes[0]->organismo }}">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <h6>AERONAVE / MODELO</h6>
                                    <select class="selectpicker form-control aeronaves aeronave_modelo load_aeronave"
                                        id="naves" name="aeronave_modelo">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($aeronaveModelos as $data)
                                            <option value="{{ $data->id }}">{{ $data->aeronave }} -
                                                {{ $data->modelo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <h6>MATRICULA <small></small></h6>
                                    <select name="matricula" id="matricula"
                                        class="form-control matricula load_matricula">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group" id="div_serial">
                                    <h6>SERIAL</h6>
                                    <input readonly="true" name="serial" id="serial" type="text"
                                        class="form-control serial" required="true" value="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <h6>BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                    <select name="base_estacion" class="form-control base_estacion load_estacion">
                                        <option value=""></option>
                                        @foreach ($bases as $data)
                                            <option value="{{ $data->id }}">{{ $data->descripcion }} -
                                                {{ $data->siglas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- fin de otro formato -->
                    </div>
                    <div class="row">
                        <div class="card">
                            <div class="table-responsive">
                                <table id="responsiveA1" class="table align-items-center mb-0">
                                    <thead style="background: #e1e1e0;">
                                        <tr>
                                            <th class="text-uppercase font-weight-bolder"><h6>N°</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>ORDENADA POR</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>T. MISIÓN</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>CÓDIGO</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>DESDE</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>HASTA</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>SALIDA</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>RETORNO</h6></th>
                                            <th class="text-uppercase font-weight-bolder"><h6>ACCIÓN</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody id="A1_data">
                                        <tr>
                                            <td>
                                                <span> v1 </span>
                                            </td>
                                            <td>
                                                <select name="ordenada_por" class="form-control ordenada_por load_ordenado_por">
                                                    <option value=""></option>
                                                    @foreach($vueloOrdenadaPor as $data)
                                                        <option value="{{$data->codigo}}">{{$data->codigo}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="siglas" class="form-control siglas load_siglas">
                                                    <option value="EVENTUAL">EVENTUAL</option>
                                                    @foreach($codigoTipoMisionSiglas as $data)
                                                        <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="codigo" class="form-control codigo load_codigo">
                                                    <option value="EVENTUAL">EVENTUAL</option>
                                                        @foreach($codigoMision as $data)
                                                            <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>
                                                        @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="ruta_desde" class="form-control ruta_desde load_ruta_desde">
                                                    <option value="EVENTUAL">EVENTUAL</option>
                                                    @foreach($bases as $data)
                                                        {{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}
                                                        <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta">
                                                    <option value="EVENTUAL">EVENTUAL</option>
                                                    @foreach($bases as $data)
                                                        {{--<option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>--}}
                                                        <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase">
                                            </td>
                                            <td>
                                                <input name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase">
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="padding-top:5px" class="row">
                            <div  class="pull-right">
                                <button style="float: right; background: green;color: white;" type="button" class="btn-sm btn-success agregar_mision add_edit_input" id="agregar_mision" hidden="true">Agregar Pierna</button>
                                <button hidden="true" style="float: right; background: rgb(189, 0, 0);color: white;" type="button" class="btn btn-danger edit_input update_A1_clean">X</button>
                                <button hidden="true" style="float: right; background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success edit_input actualizar_a1_mision">ACTUALIZAR</button>
                            </div>
                        </div>
                        <div style="padding-top:5px" class="wizard-footer">
                            <div class="col-md-12 text-center">
                                <input id="enviar" style="background: #00168C" type='button'
                                    class='btn mx-auto btn-next btn-fill btn-info btn-wd enviar' name='next'
                                    value='Guardar' />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var id_fam0001;
            var fam0001_a1_mision_id;
            var ov_ota_om;

            // Obtengo la fecha del día siguiente para usarla tanto en la cabecera como en la programación
            var fechaActual = new Date();
            var fechaManana = new Date(fechaActual.getTime() + 24 * 60 * 60 * 1000).toISOString().slice(0, 10);
            var fecha_inv = fechaManana.split('-').reverse().join('-');

            // Obtengo la unidad
            var unidad = $('.unidad').val();
            var unidad_ov = unidad.replace('-', '');

            // Obtengo la OV
            var ov_ota_om = $('input:radio[name=ov_ota_om]:checked').val()+"-"+unidad_ov+"-"+fecha_inv;


            $('.aeronaves').val('').trigger('change');
            $('#fecha_cabecera').val(fechaManana);
            $("#ov_ota_om").text(ov_ota_om);


            //PASO 1 Convierto en select2 los campos que lo necesitan
            $('#naves').select2();
            $('#matricula').select2();
            $('.base_estacion').select2();
            $('.ordenada_por').select2();
            $('.siglas').select2();
            $('.codigo').select2();
            $('.ruta_desde').select2();
            $('.ruta_hasta').select2();


            //LIMPIAR A1
            function cleanA1() {
                $('.aeronaves').val('').trigger('change');
                $('.ordenada_por').val('').trigger('change');
                $('.en_apoyo').val('').trigger('change');
                $('.codigo').val('').trigger('change');
                $('.matricula').val('').trigger('change');
                $('.serial').val('').trigger('change');
            }



            // Radio button dinamicos

            $('input:radio[name=ov_ota_om]').on('change', function() {
                var fecha = $('.fecha').val();
                var fecha_inv = fecha.split('-').reverse().join('-');
                var unidad = $('.unidad').val();
                var unidad_ov = unidad.replace('-', '');
                var ov_ota_om = $('input:radio[name=ov_ota_om]:checked').val()+"-"+unidad_ov+"-"+fecha_inv;
                if (ov_ota_om) {
                    $("#ov_ota_om").text(ov_ota_om);
                }
            });


            //SELECT DINAMICOS PASO #1

            $('#naves').on('change', function() {
                var naveId = $(this).val();
                if (naveId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('matriculas') }}",
                        data: {
                            "id": naveId
                        },
                        success: function(res) {
                            if (res) {
                                $("#matricula").empty();
                                $("#serial").val('');
                                $("#matricula").append(
                                    '<option value="">Seleccionar..</option>');
                                $.each(res, function(key, value) {
                                    $("#matricula").append(
                                        '<option class="load_matricula" value="' +
                                        value.matricula + '">' + value.matricula +
                                        '</option>');
                                });
                            }
                        }
                    });
                }
            });

            $('#matricula').on('change', function() {
                $("#serial").val('');
                var matriculaId = $(this).val();
                if (matriculaId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('seriales') }}",
                        data: {
                            "id": matriculaId
                        },
                        success: function(res) {
                            if (res) {
                                console.log(res[0].serial);
                                $("#div_serial").empty();
                                $("#div_serial").append(
                                    '<h6>SERIAL</h6><input readonly="true" name="serial" type="text" id="serial" class="form-control serial" required="true" value="' +
                                    res[0].serial + '">');
                            }
                        }
                    });
                }
            });


            //FORMULARIO GUARDAR
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //PASO #1 - GUARDAR HEADER
            $(".enviar").click(function(e) {
                e.preventDefault();
                var fecha = $('.fecha').val();
                var fecha_inv = fecha.split('-').reverse().join('-');
                var unidad = $('.unidad').val();
                var unidad_ov = unidad.replace('-', '');
                var ov_ota_om = $('input:radio[name=ov_ota_om]:checked').val()+"-"+unidad_ov+"-"+fecha_inv;
                var componente_organismo = $('.componente_organismo').val();
                var aeronave_modelo = $('.aeronaves').val();
                var serial = $('.serial').val();
                var matricula = $('.matricula').val();
                var base_estacion = $('.base_estacion').val();
                var ordenada_por = $('.ordenada_por').val();

                //VALIDAR PASO UNO HEADER
                if (ov_ota_om === "" || base_estacion === "" || aeronave_modelo === "" || unidad === "" ||
                    fecha === "" || serial === "" || matricula === "" || ordenada_por==="") {
                    Swal.fire({
                        title: 'Atención!',
                        text: 'Debes completar ciertos campos para continuar.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                    console.log('no puedes guardar datos vacios')
                } else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('store_programacion') }}",
                        method: 'POST',
                        data: {
                            fecha: fecha,
                            ov_ota_om: ov_ota_om.toUpperCase(),
                            componente_organismo: componente_organismo,
                            unidad: unidad,
                            aeronave_modelo: aeronave_modelo,
                            serial: serial,
                            matricula: matricula,
                            base_estacion: base_estacion,
                            completado: "programacionEnv",
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log(response)

                                id_fam0001 = response.data.id;
                                ov_ota_om = response.data.ov_ota_om;

                                $(".ov-ota-om-header").empty();
                                $(".ov-ota-om-header").append('<h6><span style="color: black;">OV / OTA / OM: </span><span>'+ov_ota_om+'</span></h6>');

                                $('#enviar').prop('hidden', true);
                                $('#naves').prop('disabled', true);
                                $('#matricula').prop('disabled', true);


                                guardar_a1_mision(id_fam0001, ov_ota_om);
                                $('#agregar_mision').prop('hidden', false);

                                Swal.fire({
                                    title: 'Creado!',
                                    text: 'Se Creo Correctamente.',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }
            });

                //PASO #2 - GUARDAR A1 MISION
            function guardar_a1_mision(id_fam0001){

                var ordenada_por = $('.ordenada_por').val();
                var sigla = $('.siglas').val();
                var numero = $('.codigo').val();
                var codigo = ""+sigla+"-"+numero+"";
                var ruta_desde = $('.ruta_desde').val();
                var ruta_hasta = $('.ruta_hasta').val();
                var encend = $('.encend').val();
                var apag = $('.apag').val();
                //VALIDAR PASO UNO HEADER
                if(ordenada_por===""){
                    console.log('no puedes guardar datos vacios')
                }else{
                    //ENVIAR
                    $.ajax({
                    url:"{{ route('store_a1') }}",
                    method:'POST',
                    data:{
                        ordenada_por:ordenada_por,
                        codigo:codigo.toUpperCase(),
                        ruta_desde:ruta_desde,
                        ruta_hasta:ruta_hasta,
                        encend:encend.toUpperCase(),
                        apag:apag.toUpperCase(),

                        ov_ota_om: ov_ota_om,
                        fam0001_id: id_fam0001,
                        completado: "misionEnv",
                        },
                        success:function(response){
                            if(response.success){

                                updateClean_A1()
                                data_vuelos(id_fam0001);

                            }
                        },
                        error:function(error){
                            console.log(error)
                        }
                    });
                }

            }

            $("#agregar_mision").click(function () {

                $.ajax({
                    url:"{{ route('store_a1') }}",
                    method:'POST',
                    data:{
                        ordenada_por:"",
                        codigo:"",
                        ruta_desde:"",
                        ruta_hasta:"",
                        encend:"",
                        apag:"",

                        ov_ota_om: ov_ota_om,
                        fam0001_id: id_fam0001,
                        completado: "misionEnv",
                    },
                        success:function(response){
                            if(response.success){

                                A1_id = response.A1_id[0];
                                nuevaOperacionVuelo =
                                '<tr id="row"><td><span>V'+A1_id.vuelo+'</span></td><td><select name="ordenada_por" class="form-control ordenada_por load_ordenado_por"><option value=""></option>@foreach($vueloOrdenadaPor as $data)<option value="{{$data->codigo}}">{{$data->codigo}}</option>@endforeach</select></td><td><select name="siglas" class="form-control siglas load_siglas"><option value=""></option>@foreach($codigoTipoMisionSiglas as $data)<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><select name="codigo" class="form-control codigo load_codigo"><option value=""></option>@foreach($codigoMision as $data)<option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>@endforeach</select></td><td><select name="ruta_desde" class="form-control ruta_desde load_ruta_desde"><option value=""></option>@foreach($bases as $data){{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta"><option value=""></option>@foreach($bases as $data){{--<option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>--}}<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><input name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase"></td><td><input name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase"></td><td style="padding-left: 20px;"><button value='+A1_id.id+' type="button" class="btn-sm btn-danger" id="DeleteRow"><i style="font-size: 15px; color:white;" class="ti-trash"></i></button></td></tr>';


                                $('#A1_data').append(nuevaOperacionVuelo);
                                $('.ordenada_por').select2();
                                $('.siglas').select2();
                                $('.codigo').select2();
                                $('.ruta_desde').select2();
                                $('.ruta_hasta').select2();


                            }
                        },
                        error:function(error){
                            console.log(error)
                    }
                });

            });
            $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })

        });
    </script>
@endsection
