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
                    @include('dao.operacionesAereas.programacionVuelo.header_programacionEdit')
                </div>
                <div class="card mb-4 mx-4">
                    <div class="card-body px-2 pt-2 pb-2">
                        <!-- el otro formato -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <h6>BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                    @role('aviacion_dao')
                                        <select name="base_estacion" class="form-control base_estacion load_estacion" disabled="true">
                                            <option value="{{ $baseSelect->id }}">{{ $baseSelect->descripcion }} - {{ $baseSelect->siglas }}</option>
                                        </select>
                                    @endrole
                                    @role('aviacion_grupo_aereo|administrador')
                                        <select name="base_estacion" class="form-control base_estacion load_estacion">
                                            <option value="{{ $baseSelect->id }}">{{ $baseSelect->descripcion }} - {{ $baseSelect->siglas }}</option>
                                            @foreach ($bases as $data)
                                                <option value="{{ $data->id }}">{{ $data->descripcion }} -
                                                    {{ $data->siglas }}</option>
                                            @endforeach
                                        </select>
                                    @endrole
                                </div>
                            </div>
                            <div class="col-2">
                                <h6>Selecionar</h6>
                                @role('aviacion_dao')
                                    <select name="matriculaSelect" id="matriculaSelect" class="form-control matriculaSelect"
                                    disabled>
                                        <option value="">Seleccionar...</option>
                                    </select>
                                @endrole
                                @role('aviacion_grupo_aereo|administrador')
                                    <select name="matriculaSelect" id="matriculaSelect" class="form-control matriculaSelect">
                                        <option value="">Seleccionar...</option>
                                        @foreach($matriculas as $data)
                                                <option value="{{$data->matricula}}">{{$data->matricula}}</option>
                                        @endforeach
                                    </select>
                                @endrole
                            </div>
                            <div class="col-6" id="div_matricula_input">
                                <h6>MATRICULAS ALTERNAS</h6>
                                @role('aviacion_dao')
                                    <input readonly type="text" name="matricula_alterna" id="matricula_alterna" class="form-control matricula_alterna" width="100%" value="{{ $headerFam0001[0]->matriculas_alternas }}">
                                @endrole
                                @role('aviacion_grupo_aereo|administrador')
                                    <input type="text" name="matricula_alterna" id="matricula_alterna" class="form-control matricula_alterna" width="100%" value="{{ $headerFam0001[0]->matriculas_alternas }}">
                                @endrole
                            </div>
                        </div>
                        <!-- fin de otro formato -->
                    </div>
                </div>
                <div class="card mb-4 mx-4">
                    <div class="card-body px-2 pt-2 pb-2">
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
                                @foreach ($A1_mision as $data)
                                    <tr>
                                        <td>
                                            <span> v {{ $data->vuelo }} </span>
                                        </td>
                                        <td>
                                            <select name="ordenada_por" class="form-control ordenada_por load_ordenado_por">
                                                <option value="{{ $data->ordenada_por }}">{{ $data->ordenada_por }}</option>
                                                @foreach($vueloOrdenadaPor as $datosOrdenadaPor)
                                                    <option value="{{$datosOrdenadaPor->codigo}}">{{$datosOrdenadaPor->codigo}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="siglas" class="form-control siglas load_siglas">
                                                <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                @foreach($codigoTipoMisionSiglas as $datos)
                                                    <option value="{{$datos->siglas}}">{{$datos->siglas}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="codigo" class="form-control codigo load_codigo">
                                                <option value="{{ $data->numero }}">{{ $data->numero }}</option>
                                                    @foreach($codigoMision as $datoscodigo)
                                                        <option title="{{$datoscodigo->nombre}}" value="{{$datos->datoscodigo}}">{{$datos->datoscodigo}}</option>
                                                    @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="ruta_desde" class="form-control ruta_desde load_ruta_desde">
                                                <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}</option>
                                                @foreach($bases as $dataruta_desde)
                                                    {{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}
                                                    <option value="{{$dataruta_desde->siglas}}">{{$dataruta_desde->siglas}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta">
                                                <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}</option>
                                                @foreach($bases as $dataruta_hasta)
                                                    {{--<option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>--}}
                                                    <option value="{{$dataruta_hasta->siglas}}">{{$dataruta_hasta->siglas}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase" value="{{ $data->encend }}">
                                        </td>
                                        <td>
                                            <input name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase" value="{{ $data->apag }}">
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="padding-top:5px" class="row">
                            @role('aviacion_grupo_aereo|administrador')
                                <div  class="pull-right">
                                    <button style="float: right; background: green;color: white;" type="button" class="btn-sm btn-success agregar_mision add_edit_input" id="agregar_mision">Agregar Pierna</button>
                                    <button style="float: right; background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success edit_input actualizar_a1_mision" id="actualizar_a1_mision">ACTUALIZAR</button>
                                </div>
                            @endrole
                            @role('aviacion_dao|administrador')
                                <div style="text-align: center;">
                                    <button style="background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success" id="">REVISADO</button>
                                </div>
                            @endrole
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
            var base_estacion;
            var siglasUnidad;

            base_estacion = $('.base_estacion').val();

            //PASO 1 Convierto en select2 los campos que lo necesitan
            $('.base_estacion').select2();
            $('.ordenada_por').select2();
            $('.siglas').select2();
            $('.codigo').select2();
            $('.ruta_desde').select2();
            $('.ruta_hasta').select2();
            $('#matriculaSelect').select2();

            $('.base_estacion').change(function(e) {
                e.preventDefault();
                base_estacion = $('.base_estacion').val();
            });


            //LIMPIAR A1
            function cleanA1() {
                $('.ordenada_por').val('').trigger('change');
                $('.en_apoyo').val('').trigger('change');
                $('.codigo').val('').trigger('change');
            }



            //FORMULARIO GUARDAR
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //PASO #1 - GUARDAR HEADER
            /*$(".enviar").click(function(e) {
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
            });*/

                //PASO #2 - GUARDAR A1 MISION
            /* function guardar_a1_mision(id_fam0001){

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

            } */

            /* $("#agregar_mision").click(function () {

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
                                '<tr id="row"><td><span>V'+A1_id.vuelo+'</span></td><td><select name="ordenada_por" class="form-control ordenada_por load_ordenado_por"><option value=""></option>@foreach($vueloOrdenadaPor as $data)<option value="{{$data->codigo}}">{{$data->codigo}}</option>@endforeach</select></td><td><select name="siglas" class="form-control siglas load_siglas"><option value=""></option>@foreach($codigoTipoMisionSiglas as $data)<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><select name="codigo" class="form-control codigo load_codigo"><option value=""></option>@foreach($codigoMision as $data)<option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>@endforeach</select></td><td><select name="ruta_desde" class="form-control ruta_desde load_ruta_desde"><option value=""></option>@foreach($bases as $data){{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta"><option value=""></option>@foreach($bases as $data){{--<option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>--}}<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><input name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase"></td><td><input name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase"></td><td style="padding-left: 20px;"><button value='+A1_id.id+' style="background: rgb(189, 0, 0);color: white;" type="button" class="btn btn-danger" id="DeleteRow">X</button></td></tr>';


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
            }) */

            var data_id = parseInt('{{$fam0001}}')
            //TRAER DATA DEL PRIMER PASO
            $.ajax({
                url:"{{ route('programacion_data') }}",
                method:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
                    data_id:data_id
                },
                cache: false,
                dataType: 'json',
                success: function(response){

                    if(response.headerData.length>0){
                        var loopSteps = response.headerData.length
                        for (let i = 0; i < loopSteps; i++) {
                            let famSteps = response.headerData[i]
                            id_fam0001 = famSteps.id;
                            ov_ota_om = famSteps.ov_ota_om;
                            var dataHeader = 1;
                                //PASOS COMPLETADOS
                                if(dataHeader>0){
                                    var unidad = response.unidad[0].unidad;
                                    siglasUnidad = famSteps.unidad;
                                    $("#ov_ota_om").text(famSteps.ov_ota_om);
                                    $("#aeronave").text(famSteps.aeronaves.aeronave+ " - MATRÍCULA: " +famSteps.matricula);
                                    $("#unidad_componente").text(unidad+ " - " +famSteps.componente_organismo);
                                    //CARGAR DATOS DE PASOS

                                    $("#fecha_cabecera").val(famSteps.fecha);
                                    $("#serial").val(famSteps.serial);
                                    $(".load_componente_organismo").val(famSteps.componente_organismo).trigger('change')
                                    $(".load_unidad").val(famSteps.unidad).trigger('change')

                                        //EDITAR MISION
                                        /*$(".editar_a1_mision").click(function() {
                                            var id_edit = $(this).val();
                                            $.ajax({
                                                url:"{{ route('editar_a1_mision') }}",
                                                method:'POST',
                                                data:{id:id_edit},
                                                cache: false,
                                                dataType: 'json',
                                                success: function(response){
                                                    if(response){
                                                        let res = response.data[0]
                                                        edit_A1(res)
                                                        let consumblesEdit = response.consumibles
                                                    }
                                                    else{
                                                        alert('Fallo en la peticion con el servidor')
                                                    }
                                                }
                                            });
                                        }); */
                                        //ACTUALIZAR MISION (METER EN HELPER)
                                        /*$(".actualizar_a1_mision").click(function() {
                                            var sigla = $('.load_siglas').val();
                                            var numero = $('.load_codigo').val();
                                            var codigo = ""+sigla+"-"+numero+"";
                                            $.ajax({
                                                url:"{{ route('actualizar_a1_mision') }}",
                                                method:'POST',
                                                data:{
                                                    id:$(".load_id_mision").val(),
                                                    ordenada_por:$(".load_ordenado_por").val(),
                                                    en_apoyo:$('.load_en_apoyo').val(),
                                                    codigo:codigo,
                                                    ruta_desde:$('.load_ruta_desde').val(),
                                                    ruta_hasta:$('.load_ruta_hasta').val(),
                                                    encend:$('.load_encend').val(),
                                                    despeg:$('.load_despeg').val(),
                                                    aterriz:$('.load_aterriz').val(),
                                                    apag:$('.load_apag').val(),
                                                    registro_manual:$('.load_registro_manual').val(),
                                                    horometro:$('.load_horometro').val(),
                                                    ind_vuelo:$('.load_ind_vuelo').val(),
                                                    toque_desp:$('.load_toque_desp').val(),
                                                    low_go:$('.load_low_go').val(),
                                                    ciclos_tren:$('.load_ciclos_tren').val(),
                                                    ov_ota_om:$('.ov_ota_om').val().toUpperCase(),
                                                    fam0001_id: id_fam0001,
                                                    en_apoyo_A2:$(".load_en_apoyo_A2").val(),
                                                    descripcion_A2:$('.load_descripcion_A2').val(),
                                                    completado: A1Steps[0].completado=="completado"?"completado":"paso2",
                                                },
                                                cache: false,
                                                dataType: 'json',
                                                success: function(response){
                                                    if(response){
                                                        misionID = $(".load_id_mision").val()
                                                        guardarConsumo(misionID);
                                                        console.log(response)
                                                        cleanA1()
                                                        $('.edit_input').prop('hidden', true);
                                                        $('.add_edit_input').prop('hidden', false);
                                                        Swal.fire({
                                                            title: 'Actualizado!',
                                                            text: 'La Misión ha sido Actualizada Correctamente.',
                                                            icon: 'success',
                                                            timer: 3000,
                                                            showConfirmButton: true,
                                                        });
                                                    }
                                                }
                                            });
                                        });
                                        updateClean_A1() */


                                    //EDITAR PASO 1
                                    /*$("#editar_paso1").click(function() {
                                        var id_edit = $(this).val();
                                        $.ajax({
                                            url:"{{ route('editar_paso1') }}",
                                            method:'POST',
                                            data:{
                                                fecha: $('.fecha').val(),
                                                ov_ota_om: $('.ov_ota_om').val().toUpperCase(),
                                                componente_organismo: $('.componente_organismo').val(),
                                                unidad: $('.unidad').val(),
                                                aeronave_modelo: $('.aeronaves').val(),
                                                serial: $('.serial').val(),
                                                matricula: $('.matricula').val(),
                                                base_estacion: $('.base_estacion').val(),
                                                jefe_maquina: $('.jefe_maquina').val(),
                                                completado: famSteps.completado=="completado"?"completado":"paso1",
                                                id:id_edit,
                                            },
                                            cache: false,
                                            dataType: 'json',
                                            success: function(response){
                                                if(response){
                                                    console.log('editado')
                                                    Swal.fire({
                                                        title: 'Actualizado!',
                                                        text: 'Datos del vuelo Actualizado Correctamente.',
                                                        icon: 'success',
                                                        timer: 3000,
                                                        showConfirmButton: true,
                                                    });
                                                }
                                                else{
                                                    alert('Fallo en la peticion con el servidor')
                                                }
                                            }
                                        });

                                    }); */
                                    //data_vuelos(id_fam0001);
                                }
                        }
                    }
                }

            });


            $("#agregar_mision").click(function () {

                $.ajax({
                    url:"{{ route('store_a1') }}",
                    method:'POST',
                    data:{
                        ordenada_por:siglasUnidad,
                        codigo:"EVENTUAL",
                        ruta_desde:"EVENTUAL",
                        ruta_hasta:"EVENTUAL",
                        encend:"00:00",
                        apag:"00:00",

                        ov_ota_om: ov_ota_om,
                        fam0001_id: id_fam0001,
                        completado: "programando",
                    },
                        success:function(response){
                            if(response.success){

                                A1_id = response.A1_id[0];
                                nuevaOperacionVuelo =
                                '<tr id="row"><td><span>V'+A1_id.vuelo+'</span></td><td><select name="ordenada_por" class="form-control ordenada_por load_ordenado_por"><option value="'+siglasUnidad+'">'+siglasUnidad+'</option>@foreach($vueloOrdenadaPor as $data)<option value="{{$data->codigo}}">{{$data->codigo}}</option>@endforeach</select></td><td><select name="siglas" class="form-control siglas load_siglas"><option value="EVENTUAL">EVENTUAL</option>@foreach($codigoTipoMisionSiglas as $data)<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><select name="codigo" class="form-control codigo load_codigo"><option value="EVENTUAL">EVENTUAL</option>@foreach($codigoMision as $data)<option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>@endforeach</select></td><td><select name="ruta_desde" class="form-control ruta_desde load_ruta_desde"><option value="EVENTUAL">EVENTUAL</option>@foreach($bases as $data){{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta"><option value="EVENTUAL">EVENTUAL</option>@foreach($bases as $data){{--<option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>--}}<option value="{{$data->siglas}}">{{$data->siglas}}</option>@endforeach</select></td><td><input name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase"></td><td><input name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase"></td><td style="padding-left: 20px;"><button value='+A1_id.id+' style="background: rgb(189, 0, 0);color: white;" type="button" class="btn btn-danger" id="DeleteRow">X</button></td></tr>';


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
            });
        });
    </script>
@endsection
