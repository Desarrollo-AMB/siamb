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
                                        <select name="base_estacion" class="form-control base_estacion load_estacion"
                                            disabled="true">
                                            <option value="{{ $baseSelect->id }}">{{ $baseSelect->descripcion }} -
                                                {{ $baseSelect->siglas }}</option>
                                        </select>
                                    @endrole
                                    @role('aviacion_grupo_aereo|administrador')
                                        <select name="base_estacion" class="form-control base_estacion load_estacion" disabled>
                                            @foreach ($ubicacion as $data)
                                            <option value="{{ $data->base_estacion}}">{{ $data->base_estacion}} -
                                                {{ $data->base_estacion }}</option>
                                            @endforeach
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
                                    <select disabled name="matriculaSelect" id="matriculaSelect"
                                        class="form-control matriculaSelect">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($matriculas as $data)
                                            <option value="{{ $data->matricula }}">{{ $data->matricula }}</option>
                                        @endforeach
                                    </select>
                                @endrole
                            </div>
                            <div class="col-6" id="div_matricula_input">
                                <h6>MATRICULAS ALTERNAS</h6>
                                @role('aviacion_dao')
                                    <input readonly type="text" name="matricula_alterna" id="matricula_alterna"
                                        class="form-control matricula_alterna" width="100%"
                                        value="{{ $headerFam0001[0]->matriculas_alternas }}">
                                @endrole
                                @role('aviacion_grupo_aereo|administrador')
                                    <input readonly type="text" name="matricula_alterna" id="matricula_alterna"
                                        class="form-control matricula_alterna" width="100%"
                                        value="{{ $headerFam0001[0]->matriculas_alternas }}">
                                @endrole
                            </div>
                        </div>
                        <!-- fin de otro formato -->
                    </div>
                </div>
                <div class="card mb-4 mx-4">
                    <div class="card-body px-2 pt-2 pb-2">
                        <div class="table_responsive">
                            <table id="responsiveA1" class="table align-items-center mb-0">
                                <thead style="background: #e1e1e0;">
                                    <tr>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>N°</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>ORDENADA POR</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>T. MISIÓN</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>CÓDIGO</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>DESDE</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>HASTA</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>SALIDA</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>RETORNO</h6>
                                        </th>
                                        <th class="text-uppercase font-weight-bolder">
                                            <h6>ACCIÓN</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="A1_data">
                                    @php
                                        $contador = 1; // Inicializamos el contador en 1
                                    @endphp
                                    @foreach ($A1_mision as $data)
                                        <tr id="delete_a1_mision{{ $data->id }}">
                                            <td>
                                                <span> v {{ $contador++ }}</span>
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                            </td>
                                            <td>
                                                <select name="ordenada_por"
                                                    class="form-control ordenada_por load_ordenado_por enviables">
                                                    <option value="{{ $data->ordenada_por }}">{{ $data->ordenada_por }}
                                                    </option>
                                                    @foreach ($vueloOrdenadaPor as $datosOrdenadaPor)
                                                        <option value="{{ $datosOrdenadaPor->codigo }}">
                                                            {{ $datosOrdenadaPor->codigo }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="siglas" class="form-control siglas load_siglas"
                                                    id="{{ $data->id }}">
                                                    @if ($data->siglas == 'ALERTA')
                                                        <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                    @else
                                                        <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>
                                                        <option value="ALERTA">ALERTA</option>
                                                    @endif
                                                    @foreach ($codigoTipoMisionSiglas as $datos)
                                                        <option value="{{ $datos->siglas }}">{{ $datos->siglas }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA')
                                                    <select name="codigo" disabled class="form-control codigo load_codigo"
                                                        id="codigo{{ $data->id }}">
                                                        <option value="{{ $data->numero }}">{{ $data->numero }}</option>
                                                        @foreach ($codigoMision as $datoscodigo)
                                                            <option title="{{ $datoscodigo->nombre }}"
                                                                value="{{ $datoscodigo->codigo }}">
                                                                {{ $datoscodigo->codigo }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select name="codigo" class="form-control codigo load_codigo"
                                                        id="codigo{{ $data->id }}">
                                                        <option value="{{ $data->numero }}">{{ $data->numero }}</option>
                                                        @foreach ($codigoMision as $datoscodigo)
                                                            <option title="{{ $datoscodigo->nombre }}"
                                                                value="{{ $datoscodigo->codigo }}">
                                                                {{ $datoscodigo->codigo }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA')
                                                    <select name="ruta_desde" disabled
                                                        class="form-control ruta_desde load_ruta_desde"
                                                        id="ruta_desde{{ $data->id }}">
                                                        <option value="{{ $data->ruta_desde }}">{{ $data->ruta_desde }}
                                                        </option>

                                                    </select>
                                                @else
                                                    <select name="ruta_desde"
                                                        class="form-control ruta_desde load_ruta_desde"
                                                        id="ruta_desde{{ $data->id }}">
                                                        <option value="{{ $data->ruta_desde}}">{{ $data->ruta_desde }}
                                                        </option>
                                                                @foreach ($aeropuertos as $dataruta_desde)
                                                                    <option title="{{ $dataruta_desde->nombre }}"
                                                                    value="{{ $dataruta_desde->codigo_icao }}">
                                                                    {{ $dataruta_desde->codigo_icao }}</option>
                                                                @endforeach
                                                                    <option value="">_______PARROQUIA__________</option>
                                                                @foreach ($parroquias as $data)
                                                                    <option value="{{ $data->parroquia}}">{{ $data->parroquia}}
                                                                    </option>
                                                                @endforeach
                                                                    <option value="">_______BASE__________</option>
                                                                @foreach ($bases as $data)
                                                                    <option value="{{ $data->siglas }}">{{ $data->descripcion }} -
                                                                    {{ $data->siglas }}</option>
                                                                @endforeach

                                                    </select>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($A1_mision as $data)
                                                @if ($data->siglas == 'ALERTA')
                                                    <select disabled name="ruta_hasta"
                                                        class="form-control ruta_hasta load_ruta_hasta"
                                                        id="ruta_hasta{{ $data->id }}">
                                                        <option value="{{ $A1_mision->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>


                                                    </select>
                                                @else
                                                    <select name="ruta_hasta"
                                                        class="form-control ruta_hasta load_ruta_hasta"
                                                        id="ruta_hasta{{ $data->id }}">
                                                        <option value="{{ $data->ruta_hasta }}">{{ $data->ruta_hasta }}
                                                        </option>
                                                            @foreach ($aeropuertos as $dataruta_hasta)
                                                                <option title="{{ $dataruta_hasta->nombre }}"
                                                                value="{{ $dataruta_hasta->codigo_icao }}">
                                                                {{ $dataruta_hasta->codigo_icao }}</option>
                                                            @endforeach
                                                                <option value="">_______PARROQUIA__________</option>
                                                            @foreach ($parroquias as $data)
                                                                <option value="{{ $data->parroquia}}">{{ $data->parroquia}}
                                                                </option>
                                                            @endforeach
                                                                <option value="">_______BASE__________</option>
                                                            @foreach ($bases as $data)
                                                                <option value="{{ $data->siglas }}">{{ $data->descripcion }} -
                                                                {{ $data->siglas }}</option>
                                                            @endforeach
                                                    </select>
                                                @endif
                                            </td>
                                            @endforeach
                                            <td>
                                                @if ($data->siglas == 'ALERTA')
                                                    <input hidden name="encend" type="time"
                                                        class="form-control encend load_encend calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->encend }}"
                                                        id="encend{{ $data->id }}">
                                                @else
                                                    <input name="encend" type="time"
                                                        class="form-control encend load_encend calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->encend }}"
                                                        id="encend{{ $data->id }}">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->siglas == 'ALERTA')
                                                    <input hidden name="apag" type="time"
                                                        class="form-control apag load_apag calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->apag }}"
                                                        id="apag{{ $data->id }}">
                                                @else
                                                    <input name="apag" type="time"
                                                        class="form-control apag load_apag calculateTime"
                                                        style="text-transform: uppercase" value="{{ $data->apag }}"
                                                        id="apag{{ $data->id }}">
                                                @endif
                                            </td>
                                            <td style="padding-left: 20px;">
                                                @if ($data->vuelo > 1)
                                                    <button value="{{ $data->id }}"
                                                        style="background: rgb(189, 0, 0);color: white;" type="button"
                                                        class="btn btn-danger delete_a1_mision" id="DeleteRow">X</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="padding-top:5px" class="row">
                                @role('aviacion_grupo_aereo|administrador')
                                    <div class="pull-right">
                                        <button style="float: right; background: green;color: white;" type="button"
                                            class="btn-sm btn-success agregar_mision add_edit_input"
                                            id="agregar_mision">Agregar Pierna</button>
                                        <button style="float: right; background: rgb(122, 151, 231);color: rgb(0, 0, 0);"
                                            type="button" class="btn btn-success edit_input actualizar_a1_mision"
                                            id="actualizar_a1_mision">ACTUALIZAR</button>
                                    </div>
                                @endrole
                                @role('aviacion_dao|administrador')
                                    <div style="text-align: center;">
                                        <button style="background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button"
                                            class="btn btn-success" id="revisado">REVISADO</button>
                                    </div>
                                @endrole
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
    $('#responsiveA1').DataTable({
        responsive: true
    });
});
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

            $('.siglas').on('change', function() {
                var siglaId = $(this).val();
                var id = $(this).attr('id');
                if (siglaId) {
                    if (siglaId == 'ALERTA') {
                        $("#codigo" + id).prop('disabled', true);
                        $("#ruta_desde" + id).prop('disabled', true);
                        $("#ruta_hasta" + id).prop('disabled', true);
                        $("#encend" + id).prop('hidden', true);
                        $("#apag" + id).prop('hidden', true);
                    } else {
                        $("#codigo" + id).prop('disabled', false);
                        $("#ruta_desde" + id).prop('disabled', false);
                        $("#ruta_hasta" + id).prop('disabled',false);
                        $("#encend" + id).prop('hidden', false);
                        $("#apag" + id).prop('hidden', false);
                    }
                }
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


            var data_id = parseInt('{{ $fam0001 }}')
            //TRAER DATA DEL PRIMER PASO
            $.ajax({
                url: "{{ route('programacion_data') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data_id: data_id
                },
                cache: false,
                dataType: 'json',
                success: function(response) {

                    if (response.headerData.length > 0) {
                        var loopSteps = response.headerData.length
                        for (let i = 0; i < loopSteps; i++) {
                            let famSteps = response.headerData[i]
                            id_fam0001 = famSteps.id;
                            ov_ota_om = famSteps.ov_ota_om;
                            var dataHeader = 1;
                            //PASOS COMPLETADOS
                            if (dataHeader > 0) {
                                var unidad = response.unidad[0].unidad;
                                siglasUnidad = famSteps.unidad;
                                $("#ov_ota_om").text(famSteps.ov_ota_om);
                                $("#aeronave").text(famSteps.aeronaves.aeronave + " - MATRÍCULA: " +
                                    famSteps.matricula);
                                $("#unidad_componente").text(unidad + " - " + famSteps
                                    .componente_organismo);
                                //CARGAR DATOS DE PASOS

                                $("#fecha_cabecera").val(famSteps.fecha);
                                $("#serial").val(famSteps.serial);
                                $(".load_componente_organismo").val(famSteps.componente_organismo)
                                    .trigger('change')
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


            $("#agregar_mision").click(function() {

                $.ajax({
                    url: "{{ route('store_a1') }}",
                    method: 'POST',
                    data: {
                        pierna: 1,
                        ordenada_por: siglasUnidad,
                        codigo: "ALERTA",
                        ruta_desde: "EVENTUAL",
                        ruta_hasta: "EVENTUAL",
                        encend: "EVENTUAL",
                        apag: "EVENTUAL",

                        ov_ota_om: ov_ota_om,
                        fam0001_id: id_fam0001,
                        completado: "programando",
                    },
                    success: function(response) {
                        if (response.success) {

                            A1_id = response.A1_id[0];
                            nuevaOperacionVuelo =
                                '<tr id="delete_a1_mision' + A1_id.id + '">\
                                        <td>\
                                            <span>V</span>\
                                            <input type="hidden" name="id" value="' + A1_id.id +'">\
                                        </td>\
                                        <td><select name="ordenada_por" class="form-control ordenada_por load_ordenado_por">\
                                            <option value="' + A1_id.ordenada_por + '">' + A1_id.ordenada_por +'</option>\
                                                @foreach ($vueloOrdenadaPor as $data)\
                                                    <option value="{{ $data->codigo }}">{{ $data->codigo }}</option>\
                                                @endforeach\
                                        </select></td>\
                                        <td><select name="siglas" class="form-control siglas load_siglas">\
                                            <option value="ALERTA">ALERTA</option>\
                                                @foreach ($codigoTipoMisionSiglas as $data)\
                                                    <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>\
                                                @endforeach\
                                                </select></td>\
                                        <td><select name="codigo" class="form-control codigo load_codigo" disabled>\
                                            <option value=""></option>\
                                            @foreach ($codigoMision as $data)\
                                                <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{ $data->codigo }}\
                                                </option>\
                                            @endforeach\
                                        </select></td>\
                                        <td><select name="ruta_desde" class="form-control ruta_desde load_ruta_desde" disabled>\
                                            <option value="EVENTUAL">EVENTUAL</option>\
                                                @foreach ($aeropuertos as $data)\
                                                    <option title="{{ $data->nombre }}" value="{{ $data->codigo_icao }}">{{ $data->codigo_icao }}</option>\
                                                @endforeach\
                                        </select></td>\
                                        <td><select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta" disabled>\
                                            <option value="EVENTUAL">EVENTUAL</option>\
                                            @foreach ($aeropuertos as $data)\
                                                <option title="{{ $data->nombre }}" value="{{ $data->codigo_icao }}">\
                                                {{ $data->codigo_icao }}</option>\
                                            @endforeach\
                                        </select></td><td><input hidden name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase"></td><td><input hidden name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase"></td><td style="padding-left: 20px;"><button value="' +
                                A1_id.id +
                                '" style="background: rgb(189, 0, 0);color: white;" type="button" class="delete_a1_mision btn btn-danger" id="DeleteRow">X</button></td></tr>';


                            $('#A1_data').append(nuevaOperacionVuelo);
                            $('.ordenada_por').select2();
                            $('.siglas').select2();
                            $('.codigo').select2();
                            $('.ruta_desde').select2();
                            $('.ruta_hasta').select2();

                            window.location.href =
                                "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });

            });
            $('.delete_a1_mision').on('click', function(event) {
                event.preventDefault();
                var id = $(this).val();
                Swal.fire({
                    title: 'Estas Seguro de Eliminar?',
                    text: "No podrás revertir esto.!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('delete_a1_mision') }}",
                            method: 'POST',
                            data: {
                                id: id
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    $("#delete_a1_mision" + id + "").remove();
                                }
                            }
                        });
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'La Misión ha sido eliminado.',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: true,
                        });
                    }
                });
            });

            //PASO #1 - revisar Programacion
            $("#revisado").click(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('revisarProgramacion') }}",
                    method: 'POST',
                    data: {
                        id: id_fam0001
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response)

                            Swal.fire({
                                title: 'Programación Enviada con éxito!',
                                text: 'Se Creo Correctamente.',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });

                            window.location.href = "{{ URL::to('/dao/ver-programacion') }}";
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });

            });

            $("#actualizar_a1_mision").click(function(e) {
                e.preventDefault();

                try {

                    // recorrer cada fila de la tabla
                    $('table tbody tr').each(function() {
                        // recorrer cada celda de la fila

                        var rowData = {};

                        // Obtener los valores de los inputs y selects de cada fila
                        var id = $(this).find("input[name='id']").val();
                        var ordenada_por = $(this).find("select[name='ordenada_por']").val();
                        var siglas = $(this).find("select[name='siglas']").val();
                        var numero = $(this).find("select[name='codigo']").val();


                        if (siglas === "ALERTA") {
                            rowData.codigo = "ALERTA";
                            var ruta_desde = "EVENTUAL";
                            var ruta_hasta = "EVENTUAL";
                            var encend = "EVENTUAL";
                            var apag = "EVENTUAL";
                        } else {
                            rowData.codigo = siglas + "-" + numero;
                            var ruta_desde = $(this).find("select[name='ruta_desde']").val();
                            var ruta_hasta = $(this).find("select[name='ruta_hasta']").val();
                            var encend = $(this).find("input[name='encend']").val();
                            var apag = $(this).find("input[name='apag']").val();

                            if (encend === "") {
                                encend = "EVENTUAL";
                            }
                            if (apag === "") {
                                apag = "EVENTUAL";
                            }
                        }

                        rowData.id = id;
                        rowData.ordenada_por = ordenada_por;
                        rowData.ruta_desde = ruta_desde;
                        rowData.ruta_hasta = ruta_hasta;
                        rowData.encend = encend;
                        rowData.apag = apag;
                        rowData.completado = 'actualizado';

                        if (siglas !== "ALERTA") {
                            if (numero === "") {
                                throw new Error(
                                    "El codigo de la mision no puede estar vacio mientras la misión no sea de alerta."
                                    );
                            } else if (ruta_desde === "EVENTUAL" || ruta_hasta === "EVENTUAL") {
                                throw new Error(
                                    "Las Rutas de la misión no pueden ser EVENTUALES mientras la misión no sea de alerta."
                                    );
                            } else {

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    }
                                });
                                // // enviar los datos de la fila actual al servidor
                                $.ajax({
                                    url: "{{ route('actualizarProgramacionA1') }}",
                                    method: "POST",
                                    data: rowData,
                                    success: function(response) {},
                                    error: function(error) {
                                        console.log(error)
                                    }
                                });
                            }
                        } else {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            // // enviar los datos de la fila actual al servidor
                            $.ajax({
                                url: "{{ route('actualizarProgramacionA1') }}",
                                method: "POST",
                                data: rowData,
                                success: function(response) {},
                                error: function(error) {
                                    console.log(error)
                                }
                            });
                        }

                        //FORMULARIO GUARDAR

                    });

                    Swal.fire({
                        title: 'Programación Actualizada con éxito!',
                        text: 'Se Actualizó con éxito.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                    window.location.href = "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                } catch (error) {
                    console.error(error);

                    Swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        timer: 6000,
                        showConfirmButton: true,
                    });
                }
            });
        });

        $('.delete_a1_mision').on('click', function(event) {
            event.preventDefault();
            var id = $(this).val();
            Swal.fire({
                title: 'Estas Seguro de Eliminar?',
                text: "No podrás revertir esto.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_a1_mision') }}",
                        method: 'POST',
                        data: {
                            id: id
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response) {
                                $("#delete_a1_mision" + id + "").remove();
                            }
                        }
                    });
                    Swal.fire({
                        title: 'Eliminado!',
                        text: 'La Misión ha sido eliminado.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                    window.location.href = "{{ URL::to('/dao/editar-programacion') }}/" + id_fam0001;
                }
            });
        });
    </script>
@endsection
