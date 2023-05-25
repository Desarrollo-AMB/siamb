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
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                            <input hidden="true" name="ov_ota_om"
                                    style="width: 100%; border: none !important; text-transform: uppercase" type="text"
                                    class="unidad load_unidad" id="grupos" placeholder="" required="true"
                                    value="{{ $unidad[0]->codigos }}">
                            <input hidden="true" name="componente_organismo"
                                style="width: 100%; border: none !important; text-transform: uppercase" type="text"
                                class="mb-0 componente_organismo load_componente_organismo" placeholder=""
                                required="true" value="{{ $componentes[0]->organismo }}">
                            <div class="col-sm-4 mb-2 mb-sm-0">
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
                            <div class="col-sm-2 mb-2 mb-sm-0">
                                <div class="form-group">
                                    <h6>MATRICULA <small></small></h6>
                                    <select name="matricula" id="matricula"
                                        class="form-control matricula load_matricula">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5 mb-2 mb-sm-0">
                                <div class="form-group">
                                    <h6>BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                    <select name="base_estacion" class="form-control base_estacion load_estacion">
                                        <option value=""  disabled selected>Selecione..</option>
                                        @foreach ($bases as $data)
                                            <option value="{{ $data->siglas }}">{{ $data->descripcion }} - ({{ $data->siglas }})</option>
                                        @endforeach
                                        <option value="" disabled selected>_______PARROQUIA__________</option>
                                        @foreach ($parroquias as $data)
                                            <option value="{{ mb_strtoupper($data->parroquia) }}">{{ mb_strtoupper($data->parroquia) }}
                                            </option>
                                        @endforeach
                                            <option value="" disabled selected>_______AEROPUERTOS_________</option>
                                        @foreach($aeropuertos as $data)
                                                {{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}
                                            <option title="{{$data->nombre}}" value="{{$data->codigo_icao}}">{{$data->codigo_icao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                            <div class="col-xs-2 col-sm-2 col-md-2">
                                <div class="form-group" style="margin-top: 0; display: flex; align-items: flex-start;" id="div_serial">
                                    <strong style="margin-bottom: 0; margin-top: 0; margin-left: 15px; margin-right: 15px;">SERIAL:</strong>
                                    <input readonly="true" name="serial" id="serial" type="text"
                                        class="form-control serial" required="true" value="" style="margin-right: 15px; padding: 5px; margin-top: 0;">
                                </div>
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9">
                                <div class="form-group">
                                    <strong>MATRICULAS ALTERNAS:</strong>
                                    <br>
                                    <select class="select2 form-control" name="matricula_alterna" id="matricula_alterna" multiple required disabled>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- fin de otro formato -->
                    </div>
                </div>
                <div class="card mb-4 mx-4">
                    <div class="card-body px-2 pt-2 pb-2">
                        <div class="table-responsive">
                            <table id="responsiveA1" class="table align-items-center mb-0 table-responsive table-bordered">
                                <thead style="background: #e1e1e0;">
                                    <tr>
                                        <th class="text-uppercase font-weight-bolder"><h6>N°</h6></th>
                                        <th class="text-uppercase font-weight-bolder"><h6>ORDENADA POR</h6></th>
                                        <th class="text-uppercase font-weight-bolder"><h6>T. MISIÓN</h6></th>
                                        <th class="text-uppercase font-weight-bolder"><h6>CÓDIGO</h6></th>
                                        <th class="text-uppercase font-weight-bolder"><h6>DESDE</h6></th>
                                        <th class="text-uppercase font-weight-bolder"><h6>HASTA</h6></th>
                                        <th class="text-uppercase font-weight-bolder"><h6>SALIDA</h6></th>
                                        <th class="text-uppercase font-weight-bolder"><h6>LLEGADA</h6></th>
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
                                                <option value="{{ $nomenclaturaUnidad }}">{{ $nomenclaturaUnidad }}</option>
                                                @foreach($vueloOrdenadaPor as $data)
                                                    <option value="{{$data->codigo}}">{{$data->codigo}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="siglas" id="siglas" class="form-control siglas load_siglas">
                                                <option value="" selected>...</option>
                                                <option value="ALERTA">ALERTA</option>
                                                <option value="ENCENDIDO Y CHEQUEO EN TIERRA">ENCEND. Y CHEQ. EN TIERRA</option>
                                                @foreach($codigoTipoMisionSiglas as $data)
                                                    <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="codigo" id="codigo" class="form-control codigo load_codigo">
                                                <option value=""></option>
                                                    @foreach($codigoMision as $data)
                                                        <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>
                                                    @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="ruta_desde" class="form-control ruta_desde load_ruta_desde">
                                                <option value="EVENTUAL">EVENTUAL</option>
                                                <option value="LOCAL">LOCAL</option>
                                                @foreach($aeropuertos as $data)
                                                    {{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}
                                                    <option title="{{$data->nombre}}" value="{{$data->codigo_icao}}">{{$data->codigo_icao}}</option>
                                                @endforeach
                                                    <option value="">_______PARROQUIA__________</option>
                                                @foreach ($parroquias as $data)
                                                    <option value="{{ mb_strtoupper($data->parroquia) }}">{{ mb_strtoupper($data->parroquia) }}
                                                    </option>
                                                @endforeach
                                                    <option value="">_______BASE__________</option>
                                                @foreach ($bases as $data)
                                                    <option value="{{ $data->descripcion }}">{{ $data->descripcion }} -
                                                    ({{ $data->siglas }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta">
                                                <option value="EVENTUAL">EVENTUAL</option>
                                                <option value="LOCAL">LOCAL</option>
                                                @foreach($aeropuertos as $data)
                                                    {{--<option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>--}}
                                                    <option title="{{$data->nombre}}" value="{{$data->codigo_icao}}">{{$data->codigo_icao}}</option>
                                                @endforeach
                                                <option value="">_______PARROQUIA__________</option>
                                                @foreach ($parroquias as $data)
                                                    <option value="{{ mb_strtoupper($data->parroquia) }}">{{ mb_strtoupper($data->parroquia) }} </option>
                                                @endforeach
                                                    <option value="">_______BASE__________</option>
                                                @foreach ($bases as $data)
                                                    <option value="{{ $data->descripcion }}">{{ $data->descripcion }} - ({{ $data->siglas }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase">
                                        </td>
                                        <td>
                                            <input name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase">
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <small><strong>NOTA:</strong> Al dejar la hora en blanco, se tomará el valor de <strong>"EVENTUAL"</strong></small>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="padding-top:5px" class="wizard-footer">
                    <div class="col-md-12 text-center">
                        <input id="enviar" style="background: #00168C" type='button'
                            class='btn mx-auto btn-next btn-fill btn-info btn-wd enviar' name='next'
                            value='Guardar' />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
    $('#responsiveA1').DataTable({
        responsive: true
    });
});
        $(document).ready(function() {

            var id_fam0001;
            var fam0001_a1_mision_id;
            var ov_ota_om;

            // Obtengo la fecha del día siguiente para usarla tanto en la cabecera como en la programación
            var fechaActual = new Date();
            var fechaManana = new Date(fechaActual.getTime() + 20 * 60 * 60 * 1000).toISOString().slice(0, 10);
            var fecha_inv = fechaManana.split('-').reverse().join('-');

            // Obtengo la unidad
            var unidad = $('.unidad').val();
            var unidad_ov = unidad.replace('-', '');

            // Obtengo la OV
            var ov_ota_om = $('input:radio[name=ov_ota_om]:checked').val()+"-"+unidad_ov+"-"+fecha_inv;

            $('#matricula_alterna').select2({
                allowClear: true,
                minimumResultsForSearch: -1,
                width: 300
            });
            $("#matricula_alterna").prop('disabled', true);


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

            $('.siglas').on('change', function() {
                var siglaId = $(this).val();
                if (siglaId) {
                    if(siglaId === 'ALERTA'){
                        $('.codigo').val('').trigger('change');
                        $(".codigo").prop('disabled', true);
                        $(".ruta_desde").val('EVENTUAL').trigger('change');
                        $(".ruta_hasta").val('EVENTUAL').trigger('change');
                        $(".encend").prop('hidden', true);
                        $(".apag").prop('hidden', true);
                    }
                    else if(siglaId === 'ENCENDIDO Y CHEQUEO EN TIERRA'){
                        $('.codigo').val('').trigger('change');
                        $(".codigo").prop('disabled', true);
                        $(".ruta_desde").val('LOCAL').trigger('change');
                        $(".ruta_hasta").val('LOCAL').trigger('change');
                        $(".encend").prop('hidden', true);
                        $(".apag").prop('hidden', true);
                    }else{
                        $(".codigo").prop('disabled', false);
                        $(".ruta_desde").prop('disabled', false);
                        $(".ruta_hasta").prop('disabled', false);
                        $(".encend").prop('hidden', false);
                        $(".apag").prop('hidden', false);
                    }
                }
            });

            $('#naves').on('change', function() {
                $("#matricula_alterna").empty();
                $("#serial").val('');
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
                $("#matricula_alterna").empty();
                $("#matricula_alterna").prop('disabled', false);
                $("#serial").val('');
                var matriculaId = $(this).val();
                var naveId = $('#naves').val();

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
                                    '<strong style="margin-bottom: 0; margin-top: 0; margin-left: 15px; margin-right: 15px;">SERIAL:</strong>\
                                    <input readonly="true" name="serial" id="serial" type="text"class="form-control serial" required="true" style="margin-right: 15px; padding: 5px; margin-top: 0;" value="' +
                                    res[0].serial + '">');
                            }
                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: "{{ route('matriculasAlternas') }}",
                        data: {
                            "id":  matriculaId,
                            "naved": naveId
                        },
                        success: function(res) {
                            if (res) {

                                if(res.length == 0){

                                    $("#matricula_alterna").append(
                                        '<option value="SIN MATRICULAS ALTERNAS">Sin Alternas</option>');
                                } else{

                                    $("#matricula_alterna").append(
                                        '<option value="SIN MATRICULAS ALTERNAS">Sin Alternas</option>');

                                    $.each(res, function(key, value) {
                                        $("#matricula_alterna").append(
                                            '<option class="load_matricula" value="' +
                                            value.matricula + '">' + value.matricula +
                                            '</option>');
                                    });
                                }
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
                //Desabilitar el boton de enviar hasta confirmar el registro
                $(this).prop('disabled', true);

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
                var sigla = $('.siglas').val();
                var numero = $('.codigo').val();
                var array_matriculas_alternas = $('#matricula_alterna').select2().val();
                var matriculas_alternas = array_matriculas_alternas.join(' - ');
                var ruta_desde = "";
                var ruta_hasta = "";

                if(sigla ==="ALERTA"){
                    numero = "EVENTUAL";
                    ruta_desde = $('.ruta_desde').val();
                    ruta_hasta = $('.ruta_hasta').val();
                }
                else if(sigla === 'ENCENDIDO Y CHEQUEO EN TIERRA'){
                    numero = "ENCENDIDO Y CHEQUEO EN TIERRA";
                    ruta_desde = $('.ruta_desde').val();
                    ruta_hasta = $('.ruta_hasta').val();
                } else {
                    ruta_desde = $('.ruta_desde').val();
                    ruta_hasta = $('.ruta_hasta').val();
                }

                //VALIDAR PASO UNO HEADER
                if (ov_ota_om === "" || base_estacion === "" || aeronave_modelo === "" || unidad === "" ||
                    fecha === "" || serial === "" || matricula === "" || ordenada_por==="" || matriculas_alternas==="" || sigla==="" || numero === "") {
                    Swal.fire({
                        title: 'Atención!',
                        text: 'Debes completar ciertos campos para continuar.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                    $(this).prop('disabled', false);
                    console.log('no puedes guardar datos vacios')

                }
                else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('store_programacion') }}",
                        method: 'POST',
                        data: {
                            ov_ota_om: ov_ota_om.toUpperCase(),
                            componente_organismo: componente_organismo,
                            unidad: unidad,
                            aeronave_modelo: aeronave_modelo,
                            serial: serial,
                            matricula: matricula,
                            base_estacion: base_estacion,
                            completado: "programando",
                            matriculas_alternas: matriculas_alternas
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
                                $('#actualizar_a1_mision').prop('hidden', false);

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

                //VALIDAR PASO UNO HEADER
                if(ordenada_por==="" || sigla===""){
                    console.log('no puedes guardar datos vacios')
                }else{
                    if(sigla ==="ALERTA"){
                        var codigo = "ALERTA";
                        var ruta_desde = "EVENTUAL";
                        var ruta_hasta = "EVENTUAL";
                        var encend = "EVENTUAL";
                        var apag = "EVENTUAL";
                    }
                    else if(sigla ==="ENCENDIDO Y CHEQUEO EN TIERRA"){
                        var codigo = "ENCENDIDO Y CHEQUEO EN TIERRA";
                        var ruta_desde = $('.ruta_desde').val();
                        var ruta_hasta = $('.ruta_hasta').val();
                        var encend = "EVENTUAL";
                        var apag = "EVENTUAL";
                    } else {

                        var codigo = sigla+"-"+numero;
                        var ruta_desde = $('.ruta_desde').val();
                        var ruta_hasta = $('.ruta_hasta').val();
                        var encend = $('.encend').val();
                        var apag = $('.apag').val();
                        if(encend === ""){
                            encend = "EVENTUAL";
                        }
                        if(apag === ""){
                            apag = "EVENTUAL";
                        }

                    }

                    //ENVIAR
                    $.ajax({
                    url:"{{ route('store_a1') }}",
                    method:'POST',
                    data:{
                        pierna:0,
                        ordenada_por:ordenada_por,
                        codigo:codigo.toUpperCase(),
                        ruta_desde:ruta_desde,
                        ruta_hasta:ruta_hasta,
                        encend:encend.toUpperCase(),
                        apag:apag.toUpperCase(),

                        ov_ota_om: ov_ota_om,
                        fam0001_id: id_fam0001,
                        completado: "programando",
                        },
                        success:function(response){
                            if(response.success){

                                var fam_id = response.data[0].fam0001_id;
                                window.location.href = "{{URL::to('/dao/editar-programacion')}}/"+fam_id;

                            }
                        },
                        error:function(error){
                            console.log(error)
                        }
                    });
                }

            }

        });
    </script>
@endsection
