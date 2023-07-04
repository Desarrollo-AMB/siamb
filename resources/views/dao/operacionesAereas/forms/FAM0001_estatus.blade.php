@extends('layouts.user_type.auth')
@section('title', 'form')
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success mx-4" role="alert">
            <span class="text-white">{{ $message }}</span>
        </div>
    @endif
    {!! Html::style('template/wizard/css/paper-bootstrap-wizard.css') !!}

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="container">
                    <div class="row">
                        <div class="card-header pb-0 mb-2">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0"></h5>
                                </div>
                                <a style="background: #303e55;color: white; border-radius:5px;"
                                    class="btn btn-secondary btn-sm mb-0" href="javascript: history.go(-1)">Volver</a>
                            </div>
                        </div>
                        <div style="margin: 0 auto;" class="col-sm-11 col-sm-offset-2">
                            @include('dao.operacionesAereas.forms.step_one_card')
                            <div class="wizard-container">
                                <div class="card wizard-card" data-color="orange" id="">
                                    <form action="" method="">
                                        <div class="wizard-header text-center">
                                        </div>
                                        <div class="wizard-navigation">
                                            <div class="progress-with-circle">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="1"
                                                    aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#about" data-toggle="tab">
                                                        <div class="icon-circle step_one_color">
                                                            <i class="ti-files"></i>
                                                        </div>
                                                        <p style="font-size:11px; color:black">DATOS AERONAVE</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#misionTap" data-toggle="tab">
                                                        <div class="icon-circle step_two_color">
                                                            <i class="ti-flag-alt-2"></i>
                                                        </div>
                                                        <p style="font-size:11px; color:black">A1 - DATOS DE LA MISIÓN</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#b1tap" data-toggle="tab">
                                                        <div class="icon-circle step_three_color">
                                                            <i class="ti-user"></i>
                                                        </div>
                                                        <p style="font-size:11px; color:black">B1 - DATOS DE LA TRIPULACIÓN
                                                            DE VUELO</p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#a3tap" data-toggle="tab">
                                                        <div class="icon-circle step_four_color">
                                                            <i class="ti-package"></i>
                                                        </div>
                                                        <p style="font-size:11px; color:black">A3 - DATOS DE CARGA Y
                                                            PASAJEROS</p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane" id="about">
                                                <div class="row">
                                                    <div style="padding-top:30px;" class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <h6>FECHA <small></small></h6>
                                                                <input readonly="true" name="fecha" type="date"
                                                                    class="form-control fecha load_fecha blackInReadOnly">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <h6>OV / OTA / OM <small></small></h6>
                                                                <input readonly="true" name="ov_ota_om"
                                                                    style="text-transform: uppercase" type="text"
                                                                    class="form-control ov_ota_om load_ov_ota_om blackInReadOnly"
                                                                    placeholder="" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <h6>COMPONENTE / ORGANISMO <small></small></h6>
                                                                <select disabled name="componente_organismo"
                                                                    class="form-control componente_organismo load_componente_organismo"
                                                                    id="organismo">
                                                                    <option value="">Seleccionar..</option>
                                                                    @foreach ($componentes as $data)
                                                                        <option value="{{ $data->organismo }}">
                                                                            {{ $data->componente }} - {{ $data->organismo }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <h6>UNIDAD<small></small></h6>
                                                                <select disabled name="unidad"
                                                                    class="form-control unidad load_unidad" id="grupos">
                                                                    <option value=""></option>
                                                                    @foreach ($unidad as $data)
                                                                        <option value="{{ $data->codigos }}">
                                                                            <strong>{{ $data->codigos }}</strong> -
                                                                            {{ $data->unidad }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <h6>AERONAVE / MODELO</h6>
                                                                <input type="hidden" id="id_aeronave" name="id_aeronave" value="">
                                                                <input readonly="true" id="naves" name="aeronave_modelo"
                                                                type="text"
                                                                class="form-control aeronaves aeronave_modelo load_aeronave blackInReadOnly"
                                                                value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <h6>MATRICULA</h6>
                                                                <input readonly="true" id="matricula" name="matricula"
                                                                type="text"
                                                                class="form-control matricula load_matricula blackInReadOnly"
                                                                value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <h6>SERIAL</h6>
                                                                <input readonly="true" id="serial" name="serial"
                                                                    type="text"
                                                                    class="form-control serial load_serial blackInReadOnly"
                                                                    value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-sm-offset-1">
                                                            <div class="form-group">
                                                                <h6>BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                                                <select disabled id="base_estacion" name="base_estacion"
                                                                    class="form-control base_estacion load_estacion">
                                                                    <option value="{{ $fam0001data->base_estacion }}">
                                                                        {{ $fam0001data->base_estacion }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 col-sm-offset-1">
                                                            <div class="form-group" id="div_jefe_maquina">
                                                                <h6>JEFE DE MAQUINA EN LINEA DE VUELO <small></small></h6>
                                                                <select required name="jefe_maquina" id="jefe_maquina"
                                                                    class="form-control jefe_maquina load_jefe_maquina">
                                                                    <option value=""></option>
                                                                    @foreach ($jefeMaquina as $data)
                                                                        <option
                                                                            value="{{ $data->empleado->codigo_empleado }}">
                                                                            {{ $data->empleado->cedula }} -
                                                                            {{ $data->empleado->nombre1 }}
                                                                            {{ $data->empleado->apellido1 }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button value="" id="editar_paso1" hidden="true"
                                                    style="background: rgb(190, 200, 227);color: rgb(0, 0, 0);"
                                                    type="button"
                                                    class="btn btn-fill btn-info btn-wd show_edit_paso1">ACTUALIZAR</button>
                                            </div>
                                            <div class="tab-pane" id="misionTap">
                                                @include('dao.operacionesAereas.forms.A1')
                                            </div>
                                            <div class="tab-pane" id="b1tap">
                                                @include('dao.operacionesAereas.forms.B1')
                                            </div>
                                            <div class="tab-pane" id="a3tap">
                                                @include('dao.operacionesAereas.forms.A3')
                                            </div>
                                        </div>
                                        <br>
                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input id="stepInputData"
                                                    style="background: linear-gradient(310deg,#506793,#273244);"
                                                    type='button' class='btn btn-next btn-fill btn-info btn-wd enviar'
                                                    name='next' value='Guardar' />
                                                <input id="stepInputDataNext"
                                                    style="background: linear-gradient(310deg,#506793,#273244);"
                                                    type='button' class='btn btn-next btn-fill btn-info btn-wd'
                                                    name='next' value='Siguiente' hidden="true" />

                                                <input disabled id="finish" type='button' style="background: #00168C"
                                                    class='btn btn-finish btn-fill btn-info btn-wd finish show_finish_btn'
                                                    name='finish' value='Terminar' />
                                            </div>

                                            <div class="pull-left">
                                                <input type='button' class='btn btn-previous btn-default btn-wd'
                                                    name='previous' value='Atras' />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CANCELAR MISIÓN --}}
    <div class="modal fade" id="modal-view-cancelar_mision" tabindex="-1" role="dialog" aria-labelledby="cancelarTitle" aria-hidden="true">
        <div style="max-width: 620px;" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancelar Misión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <input class="id_a1_mision" name="id_a1_mision" id="id_a1_mision" type="hidden" value="">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="aeronave_mat_cancelar" class="col-form-label">Aeronave y Matrícula</label>
                                    <input  type="text" class="form-control aeronave_mat_cancelar" value="" id="aeronave_mat_cancelar" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ruta_cancelar" class="col-form-label">Codigo Misión / Ruta</label>
                                    <input  type="text" class="form-control ruta_cancelar" value="" id="ruta_cancelar" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="motivo_cancel" class="col-form-label">Motivo de cancelación</label>
                                    <input type="text" name="motivo_cancel" id="motivo_cancel" class="form-control motivo_cancel" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn bg-gradient-danger close-modal" data-bs-dismiss="modal">Atras</a>
                        <a class="btn bg-gradient-success enviar_cancelar_mision">Confirmar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // Obtener el ID del tab-pane actual
            //const activeTabPane = document.querySelector('.tab-content .tab-pane.active');
            //const activeTabPaneId = activeTabPane.getAttribute('id');
            var numCods = 0;
            var arrayHvCods = [];
            var sumTotalHv = 0;
            // Almacenar el ID del tab-pane actual en el almacenamiento local del navegador
            //localStorage.setItem('activeTab', activeTabPaneId);

            // Actualizar el ID del tab-pane almacenado cuando se cambia de tab-pane
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr("href"); // Obtener el href del enlace de la pestaña activa
                console.log(`Se cambió a la pestaña ${target}`); // Imprimir el href en la consola
                localStorage.setItem('activeTab', target);
            });

            // Mostrar el tab-pane activo después de que se recargue la página
            const storedTab = localStorage.getItem('activeTab');
            if (storedTab) {
                $('a[data-toggle="tab"][href="' + storedTab + '"]').tab('show');
            }


            //PASO 1
            $('.select2').select2();
            $('.componente_organismo').select2();
            $('#grupos').select2();
            $('.base_estacion').select2();
            $('.jefe_maquina').select2();
            //PASO 2
            $('.ordenada_por').select2();
            $('.en_apoyo').select2();
            $('.siglas').select2();
            $('.codigo').select2();
            $('.ruta_desde').select2();
            $('.ruta_hasta').select2();
            $('.en_apoyo_A2').select2();
            //PASO 3
            $('.v_trip').select2();
            $('.funcion').select2();
            $('.grado_nombre').select2();
            $('.tipo_despegue').select2();
            //PASO 4
            $('.n_vuelo').select2();

            $(document).on('select2:open', () => {
                setTimeout(function() {
                    document.querySelector('.select2-container--open .select2-search__field')
                    .focus();
                }, 10);
            });

            //LIMPIAR A1
            function cleanA1() {
                $('.ordenada_por').val('').trigger('change');
                $('.en_apoyo').val('').trigger('change');
                $('.codigo').val('').trigger('change');
                $('.siglas').val('').trigger('change');
                $('.ruta_desde').val('').trigger('change');
                $('.ruta_hasta').val('').trigger('change');
                $('.encend').val('');
                $('.despeg').val('');
                $('.aterriz').val('');
                $('.apag').val('');
                $('.registro_manual').val('');
                $('.horometro').val('');
                $('.ind_vuelo').val('');
                $('.toque_desp').val('');
                $('.low_go').val('');
                $('.total').val('');
                $('.ciclos_tren').val('');
                $('.en_apoyo_A2').val('').trigger('change');
                $('.descripcion_A2').val('');
                $('.descripcion_A2').val('');
                $('.condicion').val('');
                $('.hv').val('0.0');
                $(".div_cods").empty();
                $('#fecha_mision').prop('disabled', false);
                $('#fecha_mision').val('');
                $('#btnAgregarCod').css('display', 'none');
                numCods = 0;
                sumTotalHv = 0;
            }
            //LIMPIAR B1
            function cleanB1() {
                $('.v_trip').val('').trigger('change');
                $('.funcion').val('').trigger('change');
                $('.grado_nombre').val('').trigger('change');
                $('.tipo_despegue').val('').trigger('change');

                $(".load_vuelo_ov_ota_om").text('');
                $(".load_vuelo_desde").text('');
                $(".load_vuelo_hasta").text('');
                $('.load_codigo_tripulacion').text('');
                $('.v_mision').val('');

                $(".load_cedula_empleado").text('')
                $(".cedula_empleado").val('')
                $('.codigo_trip').val('')
                $('.load_registro_hv').val('')

                $('.cod1_trip').val('')
                $('.cod2_trip').val('')
                $('.cod3_trip').val('')
                $('.cod4_trip').val('')

                $('.registro_hv1').val('')
                $('.registro_hv2').val('')
                $('.registro_hv3').val('')
                $('.registro_hv4').val('')
            }
            //LIMPIAR A3
            function cleanA3() {
                $('.n_vuelo').val('').trigger('change')
                $('.apoyo_carga').val('')
                $('.pesocargaTotal').val('')
                $('.volCargaTotal').val('')
                $(".seca").val('')
                $(".liquida").val('')
                $(".comb").val('')
                $('.ammto').val('')
                $('.tox_pel').val('')
                $(".mil").val('')
                $(".gob").val('')
                $('.no_gob').val('')
                $('.civil').val('')
                $('.cant_animales').val('')
                $('.carga').val('')
                $('.pers').val('')
            }

            var id_fam0001;
            var fam0001_a1_mision_id;

            // Validacion campo de primer paso
            if ($('#jefe_maquina').val() == '') {
                $('#div_jefe_maquina').append(
                    '<span id="error_jefe_maquina" style="color:red;">El campo Jefe de Maquina es obligatorio para continuar</span>'
                    );
                //$('#stepInputDataNext').prop('disabled', true);
            } else {
                $('#stepInputDataNext').prop('disabled', false);
            }

            //SELECT DINAMICOS PASO #1

            var data_id = parseInt('{{ $fam0001 }}')
            //TRAER DATA DEL PRIMER PASO
            $.ajax({
                url: "{{ route('steps_status') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data_id: data_id
                },
                cache: false,
                dataType: 'json',
                success: function(response) {
                    if (response.headerData[0].completado == "completado") {
                        $('#finish').prop('hidden', true);
                    }
                    if (response.headerData.length > 0) {
                        var loopSteps = response.headerData.length
                        for (let i = 0; i < loopSteps; i++) {
                            let famSteps = response.headerData[i]
                            id_fam0001 = famSteps.id;
                            //alert(JSON.stringify(response));
                            var dataHeader = 1;
                            //PASOS COMPLETADOS
                            if (dataHeader > 0) {

                                //comprobar_status_misiones(id_fam0001);
                                comprobar_status_misiones(id_fam0001);

                                //CARGAR DATOS DE PASOS
                                $('#step_one').prop('hidden', false);
                                $('.show_edit_paso1').prop('hidden', false);
                                $(".show_edit_paso1").val(famSteps.id);
                                $("#ov_ota_om").text(famSteps.ov_ota_om);
                                $("#fecha").text(famSteps.fecha);

                                //CARGAR DATOS DE PASOS
                                $('#stepInputData').prop('hidden', true);
                                $('#stepInputDataNext').prop('hidden', false);
                                $(".step_one_color").css({
                                    "border": "3px solid #08acc9",
                                    "background": "#08acc9",
                                    "color": "white"
                                });

                                $(".load_fecha").val(famSteps.fecha)
                                $(".load_ov_ota_om").val(famSteps.ov_ota_om)

                                setTimeout(function() {
                                    $(".load_componente_organismo").val(famSteps
                                        .componente_organismo).trigger('change')
                                    $("#base_estacion").val(famSteps.base_estacion).trigger(
                                        'change')
                                    $(".load_jefe_maquina").val(famSteps.jefe_maquina).trigger(
                                        'change')
                                }, 1000);

                                $(".load_unidad").val(famSteps.unidad).trigger('change');
                                $("#naves").val(famSteps.aeronaves.aeronave);
                                $("#id_aeronave").val(famSteps.aeronave_modelo);
                                $(".load_serial").val(famSteps.serial).trigger('change');
                                $(".load_matricula").val(famSteps.matricula).trigger('change');
                                $("#aeronave_span").text(famSteps.aeronaves.aeronave +
                                    " - " + famSteps.matricula);



                                //CARGAR PASO 2
                                let A1Steps = response.A1_data
                                if (A1Steps.length > 0) {
                                    $(".step_two_color").css({
                                        "border": "3px solid #08acc9",
                                        "background": "#08acc9",
                                        "color": "white"
                                    });

                                    var counter = 1;

                                    $.each(A1Steps, function(key, value) {
                                        if (value.codigo == 'ENCENDIDO Y CHEQUEO EN TIERRA') {

                                            $('#A1_data_check').append(
                                                "<tr id='delete_a1_mision" + value.id + "'>\
                                                    <td style='padding-left: 20px;'>CHECK</td>\
                                                    <td style='padding-left: 20px;'>" + value.ordenada_por + "</td>\
                                                    <td style='padding-left: 20px;'>" + (value.codigo == null ? "NADA" :
                                                    value.codigo) + "</td>\
                                                    <td style='padding-left: 20px;'>" + value.ruta_desde + "</td>\
                                                    <td style='padding-left: 20px;'>" + value.ruta_hasta + "</td>\
                                                    <td style='padding-left: 20px;'>" + (value.completado == 'cancelado' ?
                                                    "<button disabled  value=" + value.id +
                                                    " style='background: gray;color: white;' type='button' class='btn btn-secondary'><i class='fas fa-ban'></i> Cancelada</button>" :
                                                    "<button  value=" + value.id +
                                                    " style='background: green;color: white;' type='button' class='btn btn-success check-complete'><i class='fas fa-check'></i></button><button value=" +
                                                    value.id + "/" + value.codigo + "/" + value.ruta_desde + "-" + value.ruta_hasta +
                                                    " style='background:yellow;' class='btn btn-light cancelar_a1_mision' type='button'>Cancelar</button>"
                                                    ) + "</td>\
                                                    </tr>");

                                        }
                                        if (value.completado == 'actualizar' || value
                                            .completado == 'cancelado' || value.completado ==
                                            'completado' || value.completado == 'paso2') {
                                            $('#A1_data_check').append(
                                                "<tr id='delete_a1_mision" + value.id + "'>\
                                                <td style='padding-left: 20px;'>V" + value.vuelo + "</td>\
                                                <td style='padding-left: 20px;'>" + value.ordenada_por + "</td>\
                                                <td style='padding-left: 20px;'>" + (value.codigo == null ? "NADA" : value
                                                    .codigo) + "</td>\
                                                <td style='padding-left: 20px;'>" + value.ruta_desde + "</td>\
                                                <td style='padding-left: 20px;'>" + value.ruta_hasta + "</td>\
                                                <td style='padding-left: 20px;'>" + (value.completado == 'cancelado' ?
                                                    "<button disabled  value=" + value.id +
                                                    " style='background: gray;color: white;' type='button' class='btn btn-secondary'><i class='fas fa-ban'></i> Cancelada</button>" :
                                                    (value.completado == 'completado' || value.completado == 'paso2' ?
                                                        "<button value=" + value.id +
                                                        " style='background: #212529;color: white;' type='button' class='btn btn-success editar_a1_mision'>Editar</button>" :
                                                        "<button value=" + value.id +
                                                        " style='background: #c90061;color: white;' type='button' class='btn btn-success editar_a1_mision'>Completar datos de misión</button><button value=" +
                                                        value.id + "/" + value.codigo + "/" + value.ruta_desde + "-" + value.ruta_hasta +
                                                        " style='background:yellow;' class='btn btn-light cancelar_a1_mision' type='button'>Cancelar</button>"
                                                        )) + "</td>\
                                                </tr>");
                                            counter += 1;
                                        }
                                    })

                                    $.each(A1Steps, function(key, value) {
                                        if (value.completado == 'paso2Alert') {

                                            $('#A1_data').append(
                                                "<tr id='delete_a1_mision" + value.id + "'>\
                                                <td style='padding-left: 20px;'>V" + counter + "</td>\
                                                <td style='padding-left: 20px;'>" + value.ordenada_por + "</td>\
                                                <td style='padding-left: 20px;'>" + (value.codigo == null ? "NADA" : value
                                                    .codigo) + "</td>\
                                                <td style='padding-left: 20px;'>" + value.ruta_desde + "</td>\
                                                <td style='padding-left: 20px;'>" + value.ruta_hasta + "</td>\
                                                <td style='padding-left: 20px;'>" + (value.codigo ==
                                                    'ENCENDIDO Y CHEQUEO EN TIERRA' ?
                                                    "<button  value=" + value.id +
                                                    " style='background: green;color: white;' type='button' class='btn btn-success'><i class='fas fa-check'></i></button>" :
                                                    "<button  value=" + value.id +
                                                    " style='background: #212529;color: white;' type='button' class='btn btn-success editar_a1_mision'>Editar</button><button value=" +
                                                    value.id +
                                                    " style='color: white; background:red;' class='btn btn-light delete_a1_mision' type='button'>Eliminar</button>"
                                                    ) + "</td>\
                                                </tr>");
                                            counter += 1;

                                        }
                                    })

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
                                                    success: function(
                                                    response) {
                                                        if (response) {
                                                            cleanA1()
                                                            $("#delete_a1_mision" +
                                                                    id + "")
                                                                .remove();
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

                                    $('.cancelar_a1_mision').on('click', function(event) {
                                        event.preventDefault();

                                        var arrayDatosMision = $(this).val().split("/");
                                        var id = arrayDatosMision[0];
                                        var aeronave_mat_cancelar = $("#aeronave_span").text();
                                        var ruta_cancelar = arrayDatosMision[1] + " / " + arrayDatosMision[2];

                                        $('#modal-view-cancelar_mision #id_a1_mision').val(id)
                                        $('#modal-view-cancelar_mision #aeronave_mat_cancelar').val(aeronave_mat_cancelar);
                                        $('#modal-view-cancelar_mision #ruta_cancelar').val(ruta_cancelar);
                                        $('#modal-view-cancelar_mision').modal("show");
                                        $('#modal-view-cancelar_mision').modal({
                                            backdrop: 'static',
                                            keyboard: false
                                        });
                                    });


                                    $(".enviar_cancelar_mision").click(function(e){
                                        e.preventDefault();
                                        var id = $('.id_a1_mision').val();
                                        var motivo_cancel = $('.motivo_cancel').val();
                                        if(motivo_cancel===""){
                                            Swal.fire({
                                                title: 'Atención!',
                                                text: 'Debes Ingresar el motivo de cancelación de la misión.',
                                                icon: 'warning',
                                                timer: 3000,
                                                showConfirmButton: true,
                                            });
                                        }else{
                                            //ENVIAR
                                            $.ajax({
                                            url:"{{ route('cancelar_mision') }}",
                                            method:'POST',
                                            data:{
                                                    id: id,
                                                    motivo_cancel: motivo_cancel
                                                },
                                                success:function(response){
                                                    if(response.success){
                                                        $('#modal-view-cancelar_mision').modal('hide');
                                                        Swal.fire({
                                                            title: 'LISTO!',
                                                            text: 'Misión cancelada con exito!',
                                                            icon: 'success',
                                                            timer: 3000,
                                                            showConfirmButton: true,
                                                        });
                                                        setTimeout(function () {
                                                            window.location.reload();
                                                        }, 1000);
                                                    }
                                                },
                                                error:function(error){
                                                    console.log(error)
                                                }
                                            });
                                        }
                                    });

                                    $('.check-complete').on('click', function(event) {
                                        alert('hola');
                                    });

                                    //EDITAR MISION
                                    $(".editar_a1_mision").click(function() {
                                        var id_edit = $(this).val();
                                        $.ajax({
                                            url: "{{ route('editar_a1_mision') }}",
                                            method: 'POST',
                                            data: {
                                                id: id_edit
                                            },
                                            cache: false,
                                            dataType: 'json',
                                            success: function(response) {
                                                if (response) {
                                                    let res = response.data[0]
                                                    edit_A1(res)
                                                    let consumblesEdit = response
                                                        .consumibles
                                                } else {
                                                    alert(
                                                        'Fallo en la peticion con el servidor')
                                                }
                                            }
                                        });
                                    });
                                    //ACTUALIZAR MISION (METER EN HELPER)
                                    $(".actualizar_a1_mision").click(function() {
                                        var id = $(".load_id_mision").val();
                                        var sigla = $('.load_siglas').val();
                                        var numero = $('.load_codigo').val();
                                        var ordenada_por = $(".load_ordenado_por").val();
                                        var en_apoyo = $('.load_en_apoyo').val();
                                        var ruta_desde = $('.load_ruta_desde').val();
                                        var ruta_hasta = $('.load_ruta_hasta').val();
                                        var encend = $('.load_encend').val();
                                        var despeg = $('.load_despeg').val();
                                        var aterriz = $('.load_aterriz').val();
                                        var apag = $('.load_apag').val();
                                        var registro_manual = $('.load_registro_manual').val();
                                        var horometro = $('.load_horometro').val();
                                        var ind_vuelo = $('.load_ind_vuelo').val();
                                        var toque_desp = $('.load_toque_desp').val();
                                        var low_go = $('.load_low_go').val();
                                        var ciclos_tren = $('.load_ciclos_tren').val();
                                        var ov_ota_om = $('.ov_ota_om').val().toUpperCase();
                                        var en_apoyo_A2 = $(".load_en_apoyo_A2").val();
                                        var descripcion_A2 = $('.load_descripcion_A2').val();
                                        var codigo = "" + sigla + "-" + numero + "";

                                        // codigos COD
                                        var cod1 = $('#siglas1').val() + '-' + $('#codigo1')
                                            .val() + $('#condicion1').val();
                                        var hv1 = $('#hv1').val();
                                        var cod2 = $('#siglas2').val() + '-' + $('#codigo2')
                                            .val() + $('#condicion2').val();
                                        var hv2 = $('#hv2').val();
                                        var cod3 = $('#siglas3').val() + '-' + $('#codigo3')
                                            .val() + $('#condicion3').val();
                                        var hv3 = $('#hv3').val();
                                        var cod4 = $('#siglas4').val() + '-' + $('#codigo4')
                                            .val() + $('#condicion4').val();
                                        var hv4 = $('#hv4').val();

                                        if (ov_ota_om == "" ||
                                            ov_ota_om == null ||
                                            id == "" ||
                                            sigla == "" ||
                                            numero == "" ||
                                            ordenada_por == "" ||
                                            en_apoyo == "" ||
                                            ruta_desde == "" ||
                                            ruta_hasta == "" ||
                                            encend == "" ||
                                            despeg == "" ||
                                            aterriz == "" ||
                                            apag == "" ||
                                            registro_manual == "" ||
                                            horometro == "" ||
                                            ind_vuelo == "" ||
                                            toque_desp == "" ||
                                            low_go == "" ||
                                            ciclos_tren == "" ||
                                            en_apoyo_A2 == "" ||
                                            descripcion_A2 == "") {

                                            Swal.fire({
                                                title: 'Atención!',
                                                text: 'Debes completar todos campos para guardar.',
                                                icon: 'warning',
                                                timer: 3000,
                                                showConfirmButton: true,
                                            });
                                            $(this).prop('disabled', false);
                                            console.log('no puedes guardar datos vacios');

                                        } else if(sumTotalHv < registro_manual) {
                                            Swal.fire({
                                                title: 'Atención!',
                                                text: 'La suma de las horas (COD) deben coincidir con la hora total del registro manual.',
                                                icon: 'warning',
                                                timer: 3000,
                                                showConfirmButton: true,
                                            });
                                            $(this).prop('disabled', false);
                                            console.log('no puedes guardar datos vacios');
                                        }
                                        else {
                                            $.ajax({
                                                url: "{{ route('actualizar_a1_mision') }}",
                                                method: 'POST',
                                                data: {
                                                    id: id,
                                                    ordenada_por: ordenada_por,
                                                    en_apoyo: en_apoyo,
                                                    codigo: codigo,
                                                    ruta_desde: ruta_desde,
                                                    ruta_hasta: ruta_hasta,
                                                    encend: encend,
                                                    despeg: despeg,
                                                    aterriz: aterriz,
                                                    apag: apag,
                                                    registro_manual: registro_manual,
                                                    horometro: horometro,
                                                    ind_vuelo: ind_vuelo,
                                                    cod1: cod1.toUpperCase(),
                                                    hv1: hv1,
                                                    cod2: cod2.toUpperCase(),
                                                    hv2: hv2,
                                                    cod3: cod3.toUpperCase(),
                                                    hv3: hv3,
                                                    cod4: cod4.toUpperCase(),
                                                    hv4: hv4,
                                                    toque_desp: toque_desp,
                                                    low_go: low_go,
                                                    ciclos_tren: ciclos_tren,
                                                    ov_ota_om: ov_ota_om,
                                                    fam0001_id: id_fam0001,
                                                    en_apoyo_A2: en_apoyo_A2,
                                                    descripcion_A2: descripcion_A2,
                                                    completado: 'paso2',
                                                },
                                                cache: false,
                                                dataType: 'json',
                                                success: function(response) {
                                                    if (response) {
                                                        misionID = $(
                                                                ".load_id_mision")
                                                            .val()
                                                        guardarConsumo(misionID);
                                                        console.log(response)
                                                        cleanA1()
                                                        $('.edit_input').prop(
                                                            'hidden', true);
                                                        $('.add_edit_input').prop(
                                                            'hidden', false);
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
                                        }
                                    });
                                    updateClean_A1()
                                }

                                //EDITAR PASO 1
                                $("#editar_paso1").click(function() {
                                    var id_edit = $(this).val();
                                    $.ajax({
                                        url: "{{ route('editar_paso1') }}",
                                        method: 'POST',
                                        data: {
                                            fecha: $('.fecha').val(),
                                            ov_ota_om: $('.ov_ota_om').val()
                                                .toUpperCase(),
                                            componente_organismo: $(
                                                '.componente_organismo').val(),
                                            unidad: $('.unidad').val(),
                                            aeronave_modelo: $('#id_aeronave').val(),
                                            serial: $('.serial').val(),
                                            matricula: $('.matricula').val(),
                                            base_estacion: $('.base_estacion').val(),
                                            jefe_maquina: $('.jefe_maquina').val(),
                                            completado: famSteps.completado ==
                                                "completado" ? "completado" : "paso1",
                                            id: id_edit,
                                        },
                                        cache: false,
                                        dataType: 'json',
                                        success: function(response) {
                                            if (response) {
                                                console.log('editado')
                                                Swal.fire({
                                                    title: 'Actualizado!',
                                                    text: 'Datos del vuelo Actualizado Correctamente.',
                                                    icon: 'success',
                                                    timer: 3000,
                                                    showConfirmButton: true,
                                                });
                                            } else {
                                                alert(
                                                    'Fallo en la peticion con el servidor')
                                            }
                                        }
                                    });

                                });
                                data_vuelos(id_fam0001);
                                //CARGAR PASO 3
                                let B1Steps = response.B1_data
                                if (B1Steps.length > 0) {
                                    $(".step_three_color").css({
                                        "border": "3px solid #08acc9",
                                        "background": "#08acc9",
                                        "color": "white"
                                    });
                                    datos_tripulacion(B1Steps)
                                    //PASO #3 - EDITAR TRIPULACION
                                    $(".editar_B1_trip").click(function() {
                                        var id_edit = $(this).val();
                                        $.ajax({
                                            url: "{{ route('editar_b1') }}",
                                            method: 'POST',
                                            data: {
                                                id: id_edit
                                            },
                                            cache: false,
                                            dataType: 'json',
                                            success: function(response) {
                                                if (response) {
                                                    let res = response.data[0]
                                                    edit_B1(res)
                                                } else {
                                                    alert(
                                                        'Fallo en la peticion con el servidor')
                                                }
                                            }
                                        });
                                    });
                                    //PASO #3 - UPDATE TRIPULACION
                                    update_B1(B1Steps)
                                    //PASO #3 - BOTON LIMPIAR TRIPULACION
                                    updateClean_B1()
                                    //PASO #3 - ELIMINAR TRIPULACION
                                    $(".delete_b1_trip").click(function() {
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
                                                    url: "{{ route('delete_b1') }}",
                                                    method: 'POST',
                                                    data: {
                                                        id: id
                                                    },
                                                    cache: false,
                                                    dataType: 'json',
                                                    success: function(
                                                    response) {
                                                        if (response) {
                                                            cleanB1()
                                                            $("#delete_b1" +
                                                                    id + "")
                                                                .remove();
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
                                    data_vuelos(id_fam0001);

                                }
                                //CARGAR PASO 4
                                let A3Steps = response.A3_data
                                if (A3Steps.length > 0) {
                                    $(".step_four_color").css({
                                        "border": "3px solid #08acc9",
                                        "background": "#08acc9",
                                        "color": "white"
                                    });
                                    console.log(A3Steps)
                                    A3Steps.completado == "completado" ? $('.show_finish_btn').prop(
                                        'hidden', true) : null
                                    datos_aterrizaje(A3Steps)
                                    //PASO #4 - DELETE CARGA
                                    $(".borrar_A3").click(function() {
                                        var id = $(this).val();
                                        dalete_A3(id)
                                    });
                                    //PASO #4 EDITAR CARGA
                                    $(".editar_A3").click(function() {
                                        var id_edit = $(this).val();
                                        $.ajax({
                                            url: "{{ route('editar_a3') }}",
                                            method: 'POST',
                                            data: {
                                                id: id_edit
                                            },
                                            cache: false,
                                            dataType: 'json',
                                            success: function(response) {
                                                if (response) {
                                                    let res = response.data[0]
                                                    edit_A3(res)
                                                } else {
                                                    alert(
                                                        'Fallo en la peticion con el servidor')
                                                }
                                            }
                                        });
                                    });
                                    //PASO #4 - UPDATE CARGA
                                    update_A3(A3Steps)
                                    //BOTON ACTUALIZAR DINAMICO CERRAR
                                    updateClean_A3()
                                }

                            }
                        }
                    }
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
                var ov_ota_om = $('.ov_ota_om').val();
                var componente_organismo = $('.componente_organismo').val();
                var unidad = $('.unidad').val();
                var aeronave_modelo = $('.aeronaves').val();
                var serial = $('.serial').val();
                var matricula = $('.matricula').val();
                var base_estacion = $('.base_estacion').val();
                var jefe_maquina = $('.jefe_maquina').val();

                //VALIDAR PASO UNO HEADER
                if (ov_ota_om === "") {
                    alert('no puedes guardar el ov_ota_om vacio')
                    console.log('no puedes guardar datos vacios')
                } else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('store_header') }}",
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
                            jefe_maquina: jefe_maquina,
                            completado: "paso1",
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log(response)
                                id_fam0001 = response.data.id;
                                $("#ov_ota_om").text(response.data.ov_ota_om);
                                $("#fecha").text(fecha);
                                $('#step_one').prop('hidden', false);

                                $('#stepInputData').prop('hidden', true);
                                $('#stepInputDataNext').prop('hidden', false);

                                $(".step_one_color").css({
                                    "border": "3px solid #309830",
                                    "background": "#309830",
                                    "color": "white"
                                });

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

            //PASO #2 - AGREGAR CONSUMIBLES
            $("#rowAdder").click(function() {
                newRowAdd =
                    '<div id="row"><div style="margin-bottom: 0;" class="input-group"><div style="padding:10px" class="col-sm-4"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CONSUMIBLES</small> <select name="consumibles[]"  class="form-control consumibles" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>' +
                    '<div style="padding:10px" class="col-sm-3"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">UNIDADES</small> <select name="unidades[]" class="form-control unidades" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>' +
                    '<div style="padding:10px" class="col-sm-3"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CANTIDAD</small><input name="cantidad[]" type="number" class="form-control cantidad" style="height: 37px;border: 1px solid #a5a9bf7a;"></div></div>' +
                    '<div style="padding:10px" class="col-sm-1"><div style="margin-bottom: 0;" class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="DeleteRow" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

                $('#newinput').append(newRowAdd);

                $('.consumibles').select2();
                $('.unidades').select2();

                $.ajax({
                    url: "{{ route('consumibles') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            //$(".consumibles").empty();
                            $(".consumibles").append('<option value=""></option>');
                            $.each(response.consumibles, function(key, value) {
                                $(".consumibles").append(
                                    '<option class="load_consumible" value="' + key
                                    .id + '">' + value.consumible + '</option>');
                            });

                            //$(".unidades").empty();
                            $(".unidades").append('<option value=""></option>');
                            $.each(response.unidades, function(key, value) {
                                $(".unidades").append(
                                    '<option class="load_unidades" value="' + key
                                    .id + '">' + value.unidad + '</option>');
                            });
                        }
                    }
                });

            });
            $("body").on("click", "#DeleteRow", function() {
                $(this).parents("#row").remove();
            })
            //PASO #2 - GUARDAR A1 MISION
            $(".enviar_a1_mision").click(function(e) {
                e.preventDefault();
                var ordenada_por = $('.ordenada_por').val();
                var en_apoyo = $('.en_apoyo').val();
                var sigla = $('.siglas').val();
                var numero = $('.codigo').val();
                var codigo = "" + sigla + "-" + numero + "";
                var ruta_desde = $('.ruta_desde').val();
                var ruta_hasta = $('.ruta_hasta').val();
                var encend = $('.encend').val();
                var despeg = $('.despeg').val();
                var aterriz = $('.aterriz').val();
                var apag = $('.apag').val();
                var registro_manual = $('.registro_manual').val();
                var horometro = $('.horometro').val();
                var ind_vuelo = $('.ind_vuelo').val();
                var toque_desp = $('.toque_desp').val();
                var low_go = $('.low_go').val();
                var ciclos_tren = $('.ciclos_tren').val();
                var en_apoyo_A2 = $('.en_apoyo_A2').val();
                var descripcion_A2 = $('.descripcion_A2').val();

                // codigos COD
                var cod1 = $('#siglas1').val() + '-' + $('#codigo1').val() + $('#condicion1').val();
                var hv1 = $('#hv1').val();
                var cod2 = $('#siglas2').val() + '-' + $('#codigo2').val() + $('#condicion2').val();
                var hv2 = $('#hv2').val();
                var cod3 = $('#siglas3').val() + '-' + $('#codigo3').val() + $('#condicion3').val();
                var hv3 = $('#hv3').val();
                var cod4 = $('#siglas4').val() + '-' + $('#codigo4').val() + $('#condicion4').val();
                var hv4 = $('#hv4').val();
                //VALIDAR PASO UNO HEADER
                if (sigla == "" ||
                    numero == "" ||
                    ordenada_por == "" ||
                    en_apoyo == "" ||
                    ruta_desde == "" ||
                    ruta_hasta == "" ||
                    encend == "" ||
                    despeg == "" ||
                    aterriz == "" ||
                    apag == "" ||
                    registro_manual == "" ||
                    horometro == "" ||
                    ind_vuelo == "" ||
                    toque_desp == "" ||
                    low_go == "" ||
                    ciclos_tren == "" ||
                    en_apoyo_A2 == "" ||
                    descripcion_A2 == "") {
                    Swal.fire({
                        title: 'Atención!',
                        text: 'Debes completar todos campos para guardar.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                } else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('store_a1') }}",
                        method: 'POST',
                        data: {
                            ordenada_por: ordenada_por,
                            en_apoyo: en_apoyo,
                            codigo: codigo.toUpperCase(),
                            ruta_desde: ruta_desde,
                            ruta_hasta: ruta_hasta,
                            encend: encend.toUpperCase(),
                            despeg: despeg.toUpperCase(),
                            aterriz: aterriz.toUpperCase(),
                            apag: apag.toUpperCase(),
                            registro_manual: registro_manual.toUpperCase(),
                            horometro: horometro.toUpperCase(),
                            ind_vuelo: ind_vuelo.toUpperCase(),
                            cod1: cod1.toUpperCase(),
                            hv1: hv1,
                            cod2: cod2.toUpperCase(),
                            hv2: hv2,
                            cod3: cod3.toUpperCase(),
                            hv3: hv3,
                            cod4: cod4.toUpperCase(),
                            hv4: hv4,
                            toque_desp: toque_desp,
                            low_go: low_go,
                            ciclos_tren: ciclos_tren,
                            ov_ota_om: $('.ov_ota_om').val().toUpperCase(),
                            fam0001_id: id_fam0001,
                            en_apoyo_A2: en_apoyo_A2,
                            descripcion_A2: descripcion_A2.toUpperCase(),
                            completado: "paso2Alert",
                        },
                        success: function(response) {
                            if (response.success) {
                                //LIMPIAR CAMPOS
                                cleanA1()
                                $("#A1_data tr").remove();
                                $(".step_two_color").css({
                                    "border": "3px solid #309830",
                                    "background": "#309830",
                                    "color": "white"
                                });
                                Swal.fire({
                                    title: 'Creado!',
                                    text: 'Misión Registrada Correctamente.',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                                //GUARDAR CONSUMIBLES
                                let misionID = response.A1_id[0].id;
                                guardarConsumo(misionID);

                                //MOSTRAR A1
                                let res = response.data;
                                var counter = 1;

                                $.each(res, function(key, value) {
                                    if (value.completado == 'paso2Alert') {
                                        $.ajax({
                                            url: "{{ route('check_nvuelo') }}",
                                            method: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                id: id_fam0001,
                                            },
                                            cache: false,
                                            dataType: 'json',
                                            success: function(
                                                response) {
                                                if (response) {
                                                    let num_vuelo = response.num[0] + 1;
                                                    alert(num_vuelo);
                                                    $('#A1_data').append(
                                                        "<tr id='delete_a1_mision" + value.id + "'>\
                                                        <td style='padding-left: 20px;'>V" + num_vuelo + "</td>\
                                                        <td style='padding-left: 20px;'>" + value.ordenada_por + "</td>\
                                                        <td style='padding-left: 20px;'>" + (value.codigo == null ? "NADA" : value
                                                            .codigo) + "</td>\
                                                        <td style='padding-left: 20px;'>" + value.ruta_desde + "</td>\
                                                        <td style='padding-left: 20px;'>" + value.ruta_hasta + "</td>\
                                                        <td style='padding-left: 20px;'>" + (value.codigo ==
                                                            'ENCENDIDO Y CHEQUEO EN TIERRA' ?
                                                            "<button  value=" + value.id +
                                                            " style='background: green;color: white;' type='button' class='btn btn-success'><i class='fas fa-check'></i></button>" :
                                                            "<button  value=" + value.id +
                                                            " style='background: #212529;color: white;' type='button' class='btn btn-success editar_a1_mision'>Editar</button>"
                                                            ) + "<button value=" + value.id + " style='color:white; background:red;' class='btn btn-light delete_a1_mision' type='button'>Eliminar</button></td>\
                                                        </tr>");
                                                }
                                            }
                                        });
                                    }
                                })

                                //ELIMINAR MISION (METER EN HELPER)

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
                                                success: function(
                                                    response) {
                                                    if (response) {
                                                        cleanA1()
                                                        $("#delete_a1_mision" +
                                                                id +
                                                                "")
                                                            .remove();
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

                                //EDITAR MISION (METER EN HELPER)
                                $(".editar_a1_mision").click(function() {
                                    var id_edit = $(this).val();
                                    $.ajax({
                                        url: "{{ route('editar_a1_mision') }}",
                                        method: 'POST',
                                        data: {
                                            id: id_edit
                                        },
                                        cache: false,
                                        dataType: 'json',
                                        success: function(response) {
                                            if (response) {
                                                let res = response.data[0]
                                                edit_A1(res)
                                            } else {
                                                alert(
                                                    'Fallo en la peticion con el servidor')
                                            }
                                        }
                                    });

                                });

                                //ACTUALIZAR MISION (METER EN HELPER)
                                $(".actualizar_a1_mision").click(function() {
                                    var sigla = $('.load_siglas').val();
                                    var numero = $('.load_codigo').val();
                                    var id = $(".load_id_mision").val();
                                    var ordenada_por = $(".load_ordenado_por").val();
                                    var en_apoyo = $('.load_en_apoyo').val();
                                    var ruta_desde = $('.load_ruta_desde').val();
                                    var ruta_hasta = $('.load_ruta_hasta').val();
                                    var encend = $('.load_encend').val();
                                    var despeg = $('.load_despeg').val();
                                    var aterriz = $('.load_aterriz').val();
                                    var apag = $('.load_apag').val();
                                    var registro_manual = $('.load_registro_manual')
                                        .val();
                                    var horometro = $('.load_horometro').val();
                                    var ind_vuelo = $('.load_ind_vuelo').val();
                                    var toque_desp = $('.load_toque_desp').val();
                                    var low_go = $('.load_low_go').val();
                                    var ciclos_tren = $('.load_ciclos_tren').val();
                                    var ov_ota_om = $('.ov_ota_om').val().toUpperCase();
                                    var en_apoyo_A2 = $(".load_en_apoyo_A2").val();
                                    var descripcion_A2 = $('.load_descripcion_A2')
                                .val();

                                    var codigo = "" + sigla + "-" + numero + "";

                                    // codigos COD
                                    var cod1 = $('#siglas1').val() + '-' + $('#codigo1')
                                        .val() + $('#condicion1').val();
                                    var hv1 = $('#hv1').val();
                                    var cod2 = $('#siglas2').val() + '-' + $('#codigo2')
                                        .val() + $('#condicion2').val();
                                    var hv2 = $('#hv2').val();
                                    var cod3 = $('#siglas3').val() + '-' + $('#codigo3')
                                        .val() + $('#condicion3').val();
                                    var hv3 = $('#hv3').val();
                                    var cod4 = $('#siglas4').val() + '-' + $('#codigo4')
                                        .val() + $('#condicion4').val();
                                    var hv4 = $('#hv4').val();

                                    if (ov_ota_om == "" ||
                                        ov_ota_om == null ||
                                        id == "" ||
                                        sigla == "" ||
                                        numero == "" ||
                                        ordenada_por == "" ||
                                        en_apoyo == "" ||
                                        ruta_desde == "" ||
                                        ruta_hasta == "" ||
                                        encend == "" ||
                                        despeg == "" ||
                                        aterriz == "" ||
                                        apag == "" ||
                                        registro_manual == "" ||
                                        horometro == "" ||
                                        ind_vuelo == "" ||
                                        toque_desp == "" ||
                                        low_go == "" ||
                                        ciclos_tren == "" ||
                                        en_apoyo_A2 == "" ||
                                        descripcion_A2 == "") {

                                        Swal.fire({
                                            title: 'Atención!',
                                            text: 'Debes completar todos campos para guardar.',
                                            icon: 'warning',
                                            timer: 3000,
                                            showConfirmButton: true,
                                        });
                                        $(this).prop('disabled', false);
                                        console.log('no puedes guardar datos vacios');

                                    } else if(sumTotalHv < registro_manual) {
                                        Swal.fire({
                                            title: 'Atención!',
                                            text: 'La suma de las horas (COD) deben coincidir con la hora total del registro manual.',
                                            icon: 'warning',
                                            timer: 3000,
                                            showConfirmButton: true,
                                        });
                                        $(this).prop('disabled', false);
                                        console.log('las horas deben coincidir');
                                    }else {
                                        $.ajax({
                                            url: "{{ route('actualizar_a1_mision') }}",
                                            method: 'POST',
                                            data: {
                                                id: id,
                                                ordenada_por: ordenada_por,
                                                en_apoyo: en_apoyo,
                                                codigo: codigo,
                                                ruta_desde: ruta_desde,
                                                ruta_hasta: ruta_hasta,
                                                encend: encend,
                                                despeg: despeg,
                                                aterriz: aterriz,
                                                apag: apag,
                                                registro_manual: registro_manual,
                                                horometro: horometro,
                                                ind_vuelo: ind_vuelo,
                                                cod1: cod1.toUpperCase(),
                                                hv1: hv1,
                                                cod2: cod2.toUpperCase(),
                                                hv2: hv2,
                                                cod3: cod3.toUpperCase(),
                                                hv3: hv3,
                                                cod4: cod4.toUpperCase(),
                                                hv4: hv4,
                                                toque_desp: toque_desp,
                                                low_go: low_go,
                                                ciclos_tren: ciclos_tren,
                                                ov_ota_om: ov_ota_om,
                                                en_apoyo_A2: en_apoyo_A2,
                                                descripcion_A2: descripcion_A2,
                                                fam0001_id: id_fam0001,
                                                completado: 'paso2Alert'
                                            },
                                            cache: false,
                                            dataType: 'json',
                                            success: function(response) {
                                                if (response) {
                                                    console.log(response)
                                                    misionID = $(
                                                        ".load_id_mision"
                                                        ).val()
                                                    //updateConsumo(misionID);
                                                    cleanA1()
                                                    $('.edit_input').prop(
                                                        'hidden', true);
                                                    $('.add_edit_input')
                                                        .prop('hidden',
                                                            false);
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
                                    }
                                });
                                updateClean_A1()
                                data_vuelos(id_fam0001);
                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }

            });

            //PASO #3 - BOTON AGREGAR OPERACIONES EN VUELO
            $("#OV_ADD").click(function() {
                nuevaOperacionVuelo =
                    '<div id="operacionVuelo"><div style="margin-bottom: 0;" class="input-group">' +
                    '<div style="padding:10px" class="col-sm-2"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">HV</small> <input type="number" name="HV[]" id="HV" class="form-control HV load_HV" style="height: 37px;border: 1px solid #a5a9bf7a;"></input> </div></div>' +
                    '<div style="padding:10px" class="col-sm-1"><div style="margin-bottom: 0;" class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="BorrarOperacionVuelo" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

                $('#nuevaOperacionVuelo').append(nuevaOperacionVuelo);
            });
            $("body").on("click", "#BorrarOperacionVuelo", function() {
                $(this).parents("#operacionVuelo").remove();
            })
            //PASO #3 - BOTON AGREGAR ATERRIZAJES
            $("#ATR_ADD").click(function() {
                var numItems = jQuery('.operacionVuelo').length
                if (numItems < 3) {
                    nuevoAterrizaje =
                        '<div class="operacionVuelo" id="operacionVuelo"><div style="margin-bottom: 0;" class="input-group"><div style="padding:10px" class="col-sm-6"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">TIPO</small> <select name="tipo_aterrizaje[]" class="form-control tipo_aterrizaje load_tipo_aterrizaje" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>' +
                        '<div style="padding:10px" class="col-sm-2"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CANTIDAD</small> <input type="number" name="cantidad_atr[]" id="cantidad" class="form-control cantidad load_cantidad" style="height: 37px;border: 1px solid #a5a9bf7a;"></input> </div></div>' +
                        '<div style="padding:10px" class="col-sm-1"><div style="margin-bottom: 0;" class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="BorrarAterrizaje" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

                    $('#nuevoAterrizaje').append(nuevoAterrizaje);
                    $('.tipo_aterrizaje').select2();

                    $.ajax({
                        url: "{{ route('codigos_aterrizaje_json') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            //console.log(response)
                            if (response) {
                                $(".tipo_aterrizaje").empty();
                                $(".tipo_aterrizaje").append(
                                    '<option value="">Seleccionar..</option>');
                                $.each(response.codigo, function(key, value) {
                                    $(".tipo_aterrizaje").append(
                                        '<option class="load_tipo_aterrizaje" value="' +
                                        key.codigo + '">' + value.codigo + ' - ' +
                                        value.tipo_aterrizaje + '</option>');
                                });
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'ERROR!',
                        text: 'No puedes agregar mas de tres Aterrizajes.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                }
            });
            $("body").on("click", "#BorrarAterrizaje", function() {
                $(this).parents("#operacionVuelo").remove();
            })
            //PASO #3 - FUNCION TRIPULANTE CARGO
            $("#funcion").change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('tripulante_funcion') }}',
                        data: {
                            "id_funcion": id
                        },
                        success: function(res) {
                            $(".load_cedula_empleado").text('')
                            $(".cedula_empleado").val('')
                            $(".grado_nombre").empty();
                            $(".grado_nombre").append(
                            '<option value="">Seleccionar..</option>');
                            console.log(res)
                            $.each(res, function(key, value) {
                                if (value.siglas != null) {
                                    $(".grado_nombre").append('<option value="' + value
                                        .id + '">' + value.siglas + ' - ' + value
                                        .empleado.apellido1 + ' ' + value.empleado
                                        .nombre1 + ' - (C.I): ' + value.empleado
                                        .cedula + '</option>');
                                } else {
                                    false
                                }
                            });
                        }
                    });
                }
            });
            //PASO #3 - MOSTRAR DATOS DE VUELO
            $("#v_trip").change(function() {
                $('#v_data').prop('hidden', false);
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('data_vuelo') }}',
                        data: {
                            "id": id
                        },
                        success: function(res) {
                            let data = res[0]
                            $(".load_vuelo_ov_ota_om").text(data.ov_ota_om)
                            $(".load_vuelo_desde").text(data.ruta_desde)
                            $(".load_vuelo_hasta").text(data.ruta_hasta)
                            $('.load_codigo_tripulacion').text(data.codigo)
                            $('.codigo_trip').val(data.codigo)
                            $('.v_mision').val(data.vuelo)
                            $('.load_registro_hv').val(data.registro_manual)
                            $('.cod1_trip').val(data.cod1)
                            $('.registro_hv1').val(data.hv1)
                            $('.cod2_trip').val(data.cod2)
                            $('.registro_hv2').val(data.hv2)
                            $('.cod3_trip').val(data.cod3)
                            $('.registro_hv3').val(data.hv3)
                            $('.cod4_trip').val(data.cod4)
                            $('.registro_hv4').val(data.hv4)
                        }
                    });
                }
            }).change();
            //PASO #3 - DATOS DEL TRIPULANTE DE VUELO
            $("#empleado_vuelo").change(function() {
                var id = $(this).val();
                console.log(id)
                if (id) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('datos_empleado_vuelo') }}',
                        data: {
                            "id": id
                        },
                        success: function(res) {
                            let emp = res.data[0]
                            $(".load_cedula_empleado").text(emp.empleado.cedula)
                            $(".cedula_empleado").val(emp.empleado.cedula)
                        }
                    });
                }
            });
            //PASO #3 - GUARDAR DATOS TRIPULACION
            $(".enviar_b1_tripulacion").click(function(e) {
                e.preventDefault();
                //VALIDAR PASO UNO HEADER
                if (v_trip === "") {
                    alert('no puedes guardar campos vacios')
                    console.log('no puedes guardar datos vacios')
                } else {
                    //ENVIAR
                    let misionID = $('.v_trip').val()
                    $.ajax({
                        url: "{{ route('store_b1') }}",
                        method: 'POST',
                        data: {
                            ov_ota_om: ($('.ov_ota_om').val()).toUpperCase(),
                            fam0001_id: id_fam0001,
                            fam0001_a1_mision_id: $('.v_trip').val(),
                            v_trip: $('.v_mision').val(),
                            //
                            grado_nombre_id: $('.grado_nombre').val(),
                            grado_nombre_data: $('.grado_nombre').find(":selected").text(),
                            funcion: $('.funcion').val(),
                            codigo_funcion: $('.funcion').find(":selected").text(),
                            //
                            cedula: $('.cedula_empleado').val(),
                            tipo_despegue: $('.tipo_despegue').val(),
                            COD: $('.codigo_trip').val(),
                            HV: $('.load_registro_hv').val(),

                            COD1: $('.cod1_trip').val(),
                            COD2: $('.cod2_trip').val(),
                            COD3: $('.cod3_trip').val(),
                            COD4: $('.cod4_trip').val(),

                            HV1: $('.registro_hv1').val(),
                            HV2: $('.registro_hv2').val(),
                            HV3: $('.registro_hv3').val(),
                            HV4: $('.registro_hv4').val(),

                            completado: "paso3",
                        },
                        success: function(response) {
                            $("#B1_data tr").remove();
                            if (response.success) {
                                cleanB1()
                                let b1_data = response.data
                                datos_tripulacion(b1_data)

                                //GUARDAR ATERRIZAJES
                                guardarAterrizajes(misionID);

                                $(".step_three_color").css({
                                    "border": "3px solid #309830",
                                    "background": "#309830",
                                    "color": "white"
                                });

                                Swal.fire({
                                    title: 'Creado!',
                                    text: 'Tripulación registrada Exitosamente!',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                            }
                            if (response.error) {
                                let b1_data_error = response.data
                                datos_tripulacion(b1_data_error)
                                Swal.fire({
                                    title: 'ERROR!',
                                    text: 'Solo un tripulante puede tener la funcion de PILOTO en este vuelo.',
                                    icon: 'warning',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                            }
                            //PASO #3 - EDITAR TRIPULACION
                            $(".editar_B1_trip").click(function() {
                                var id_edit = $(this).val();
                                $.ajax({
                                    url: "{{ route('editar_b1') }}",
                                    method: 'POST',
                                    data: {
                                        id: id_edit
                                    },
                                    cache: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response) {
                                            let res = response.data[0]
                                            edit_B1(res)
                                        } else {
                                            alert(
                                                'Fallo en la peticion con el servidor')
                                        }
                                    }
                                });

                            });
                            //PASO #3 - UPDATE TRIPULACION
                            update_B1()
                            //PASO #3 - BOTON LIMPIAR TRIPULACION
                            updateClean_B1()
                            //PASO #3 - ELIMINAR TRIPULACION
                            $(".delete_b1_trip").click(function() {
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
                                            url: "{{ route('delete_b1') }}",
                                            method: 'POST',
                                            data: {
                                                id: id
                                            },
                                            cache: false,
                                            dataType: 'json',
                                            success: function(
                                            response) {
                                                if (response) {
                                                    cleanB1()
                                                    $("#delete_b1" +
                                                            id + "")
                                                        .remove();
                                                }
                                            }
                                        });
                                        Swal.fire({
                                            title: 'Eliminado!',
                                            text: 'La Tripulación ha sido eliminada.',
                                            icon: 'success',
                                            timer: 3000,
                                            showConfirmButton: true,
                                        });
                                    }
                                });
                            });
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }
            });
            //PASO #3 - MOSTRAR DATOS VUELO CARGA
            $("#n_vuelo").change(function() {
                var id = $(this).val();
                console.log(id)
                if (id) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('data_vuelo') }}',
                        data: {
                            "id": id
                        },
                        success: function(res) {
                            console.log(res)
                            let data = res[0]
                            $(".apoyo_carga").val(data.en_apoyo)
                            // poner el hhiden en false
                            $(".enviar_sincarga_a3").prop('hidden', false);

                        }
                    });
                }
            }).change();

            //PASO #4 - GUARDAR DATOS CARGA
            $(".enviar_a3").click(function(e) {
                e.preventDefault();
                //VALIDAR PASO UNO HEADER  n_vuelo
                if (v_trip === "") {
                    alert('no puedes guardar campos vacios')
                    console.log('no puedes guardar datos vacios')
                } else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('store_a3') }}",
                        method: 'POST',
                        data: {
                            ov_ota_om: ($('.ov_ota_om').val()).toUpperCase(),
                            fam0001_id: id_fam0001,
                            fam0001_a1_mision_id: $('.n_vuelo').val(),
                            n_vuelo: $('.n_vuelo').val(),
                            apoyo_carga: $('.apoyo_carga').val(),
                            pesocargaTotal: $('.pesocargaTotal').val(),
                            volCargaTotal: $('.volCargaTotal').val(),
                            seca: $('.seca').val(),
                            liquida: $('.liquida').val(),
                            comb: $('.comb').val(),
                            ammto: $('.ammto').val(),
                            tox_pel: $('.tox_pel').val(),
                            mil: $('.mil').val(),
                            gob: $('.gob').val(),
                            no_gob: $('.no_gob').val(),
                            civil: $('.civil').val(),
                            cant_animales: $('.cant_animales').val(),
                            carga: $('.carga').val(),
                            pers: $('.pers').val(),
                            completado: "paso4",
                        },
                        success: function(response) {
                            $(".step_four_color").css({
                                "border": "3px solid #309830",
                                "background": "#309830",
                                "color": "white"
                            });
                            $("#A3_data tr").remove();
                            cleanA3()
                            let A3_data = response.data
                            datos_aterrizaje(A3_data)
                            Swal.fire({
                                title: 'Creado!',
                                text: 'Carga registrada correctamente!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            //PASO #4 - DELETE CARGA
                            $(".borrar_A3").click(function() {
                                var id = $(this).val();
                                dalete_A3(id)
                            });
                            //PASO #4 EDITAR CARGA
                            $(".editar_A3").click(function() {
                                var id_edit = $(this).val();
                                $.ajax({
                                    url: "{{ route('editar_a3') }}",
                                    method: 'POST',
                                    data: {
                                        id: id_edit
                                    },
                                    cache: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response) {
                                            let res = response.data[0]
                                            edit_A3(res)
                                        } else {
                                            alert(
                                                'Fallo en la peticion con el servidor')
                                        }
                                    }
                                });
                            });
                            //PASO #4 - UPDATE CARGA
                            update_A3()
                            //CLEAN
                            updateClean_A3()
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }
            });

            $(".enviar_sincarga_a3").click(function(e) {
                e.preventDefault();
                //VALIDAR PASO UNO HEADER  n_vuelo
                if (v_trip === "") {
                    alert('no puedes guardar campos vacios')
                    console.log('no puedes guardar datos vacios')
                } else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('store_a3') }}",
                        method: 'POST',
                        data: {
                            ov_ota_om: ($('.ov_ota_om').val()).toUpperCase(),
                            fam0001_id: id_fam0001,
                            fam0001_a1_mision_id: $('.n_vuelo').val(),
                            n_vuelo: $('.n_vuelo').val(),
                            apoyo_carga: 'sin carga',
                            pesocargaTotal: '0',
                            volCargaTotal: '0',
                            seca: '0',
                            liquida: '0',
                            comb: '0',
                            ammto: '0',
                            tox_pel: '0',
                            mil: '0',
                            gob: '0',
                            no_gob: '0',
                            civil: '0',
                            cant_animales: '0',
                            carga: '0',
                            pers: '0',
                            completado: "paso4",
                        },
                        success: function(response) {
                            $(".step_four_color").css({
                                "border": "3px solid #309830",
                                "background": "#309830",
                                "color": "white"
                            });
                            $("#A3_data tr").remove();
                            cleanA3()
                            let A3_data = response.data
                            datos_aterrizaje(A3_data)
                            Swal.fire({
                                title: 'Creado!',
                                text: 'vuelo registrado sin carga!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            //PASO #4 - DELETE CARGA
                            $(".borrar_A3").click(function() {
                                var id = $(this).val();
                                dalete_A3(id)
                            });
                            //PASO #4 EDITAR CARGA
                            $(".editar_A3").click(function() {
                                var id_edit = $(this).val();
                                $.ajax({
                                    url: "{{ route('editar_a3') }}",
                                    method: 'POST',
                                    data: {
                                        id: id_edit
                                    },
                                    cache: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response) {
                                            let res = response.data[0]
                                            edit_A3(res)
                                        } else {
                                            alert(
                                                'Fallo en la peticion con el servidor')
                                        }
                                    }
                                });
                            });
                            //PASO #4 - UPDATE CARGA
                            update_A3()
                            //CLEAN
                            updateClean_A3()
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }
            });


            //PASO FINAL - CERRAR ORDEN DE VUELO
            $(".finish").click(function(e) {
                e.preventDefault();
                //VALIDAR PASO UNO HEADER
                if (v_trip === "") {
                    alert('no puedes guardar campos vacios')
                    console.log('no puedes guardar datos vacios')
                } else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('pasoFinal') }}",
                        method: 'POST',
                        data: {
                            id_fam0001: id_fam0001,
                        },
                        success: function(response) {
                            console.log(response)
                            Swal.fire({
                                title: 'Vuelo Completado!',
                                text: 'Vuelo Completado Correctamente!',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            setTimeout(function() {
                                window.location = "{{ route('dao.index') }}"
                            }, 2000);
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }
            });

            function edit_A1(res) {
                arrayHvCods = [];
                cleanA1();
                $('#fecha_mision').prop('disabled', true);
                $('.edit_input').prop('hidden', false);
                $('.add_edit_input').prop('hidden', true);

                $(".load_ordenado_por").val(res.ordenada_por).trigger('change')
                $(".load_en_apoyo").val(res.en_apoyo).trigger('change')

                var dato = res.codigo
                var datos = dato.split("-")
                var siglas = datos[0]
                var codigo = datos[1]
                $(".load_siglas").val(siglas).trigger('change')
                $(".load_codigo").val(codigo).trigger('change')

                $(".load_ruta_desde").val(res.ruta_desde).trigger('change')
                $(".load_ruta_hasta").val(res.ruta_hasta).trigger('change')
                $("#fecha_mision").val(res.fecha);

                $('.load_encend').val(res.encend)
                $('.load_despeg').val(res.despeg)
                $('.load_aterriz').val(res.aterriz)
                $('.load_apag').val(res.apag)
                $('.load_registro_manual').val(res.registro_manual)
                $('.load_horometro').val(res.horometro)
                $('.load_ind_vuelo').val(res.ind_vuelo)
                $('.load_toque_desp').val(res.toque_desp)
                $('.load_low_go').val(res.low_go)
                $('.load_ciclos_tren').val(res.ciclos_tren)
                $('.load_id_mision').val(res.id)

                $(".load_en_apoyo_A2").val(res.en_apoyo_A2).trigger('change')
                $('.load_descripcion_A2').val(res.descripcion_A2)

                $('#hv1').val(res.hv1)
                $('#hv2').val(res.hv2)
                $('#hv3').val(res.hv3)
                $('#hv4').val(res.hv4)
                sumTotalHv = parseFloat(res.hv1)+parseFloat(res.hv2)+parseFloat(res.hv3)+parseFloat(res.hv4);

                if (res.cod1 !== null && res.hv1 !== null) {
                    const regex = /^([A-Za-z]+)-(\d+)([A-Za-z]+)$/;
                    const match = res.cod1.match(regex);
                    if (match !== null) {
                        const cod1_siglas = match[1];
                        const cod1_numero = match[2];
                        const cod1_condicion = match[3];
                        const hv1 = res.hv1;
                        arrayHvCods.push(hv1);
                        numCods = 1;

                        $.ajax({
                            type: "post",
                            url: "{{ route('codigos_mision_json') }}",
                            success: function(res) {
                                if (res) {
                                    $('.div_cods').append('<div class="row">\
                                        <small style="font-weight: bold; color:#67748e;">COD-1</small>\
                                        <div class="col-sm-3">\
                                            <div class="form-group">\
                                                <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>\
                                                <select id="siglas1" name="siglas1" class="form-control siglas selectCod">\
                                                    <option value="' + cod1_siglas + '">' + cod1_siglas + '</option>\
                                                    @foreach ($codigoTipoMisionSiglas as $data)\
                                                        <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>\
                                                    @endforeach\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="col-sm-3">\
                                            <div class="form-group">\
                                                <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>\
                                                <select id="codigo1" name="codigo1" class="form-control codigo selectCod">\
                                                <option value="' + cod1_numero + '">' + cod1_numero + '</option>\
                                                @foreach ($codigoMision as $data)\
                                                    <option value="{{ $data->codigo }}">{{ $data->codigo }}</option>\
                                                @endforeach\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="col-sm-3">\
                                            <div class="form-group">\
                                                <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>\
                                                <select id="condicion1" name="condicion1" class="form-control condicion selectCod">\
                                                    <option value="' + cod1_condicion + '">' + cod1_condicion +
                                        '</option>\
                                                    <option value="DCV">DCV</option>\
                                                    <option value="DCI">DCI</option>\
                                                    <option value="DWV">DWV</option>\
                                                    <option value="DWI">DWI</option>\
                                                    <option value="NCV">NCV</option>\
                                                    <option value="NCI">NCI</option>\
                                                    <option value="NWV">NWV</option>\
                                                    <option value="NWI">NWI</option>\
                                                    <option value="DCVG">DCVG</option>\
                                                    <option value="DCIG">DCIG</option>\
                                                    <option value="DWVG">DWVG</option>\
                                                    <option value="DWIG">DWIG</option>\
                                                    <option value="NCVG">NCVG</option>\
                                                    <option value="NCIG">NCIG</option>\
                                                    <option value="NWVG">NWVG</option>\
                                                    <option value="NWIG">NWIG</option>\
                                                    <option value="DCVF">DCVF</option>\
                                                    <option value="DCIF">DCIF</option>\
                                                    <option value="DWVF">DWVF</option>\
                                                    <option value="DWIF">DWIF</option>\
                                                    <option value="NCVF">NCVF</option>\
                                                    <option value="NCIF">NCIF</option>\
                                                    <option value="NWVF">NWVF</option>\
                                                    <option value="NWIF">NWIF</option>\
                                                    <option value="DCVA">DCVA</option>\
                                                    <option value="DCIA">DCIA</option>\
                                                    <option value="DWVA">DWVA</option>\
                                                    <option value="DWIA">DWIA</option>\
                                                    <option value="NCVA">NCVA</option>\
                                                    <option value="NCIA">NCIA</option>\
                                                    <option value="NWVA">NWVA</option>\
                                                    <option value="NWIA">NWIA</option>\
                                                    <option value="DCVL">DCVL</option>\
                                                    <option value="DCIL">DCIL</option>\
                                                    <option value="DWVL">DWVL</option>\
                                                    <option value="DWIL">DWIL</option>\
                                                    <option value="NCVL">NCVL</option>\
                                                    <option value="NCIL">NCIL</option>\
                                                    <option value="NWVL">NWVL</option>\
                                                    <option value="NWIL">NWIL</option>\
                                                    <option value="DCVH">DCVH</option>\
                                                    <option value="DCIH">DCIH</option>\
                                                    <option value="DWVH">DWVH</option>\
                                                    <option value="DWIH">DWIH</option>\
                                                    <option value="NCVH">NCVH</option>\
                                                    <option value="NCIH">NCIH</option>\
                                                    <option value="NWVH">NWVH</option>\
                                                    <option value="NWIH">NWIH</option>\
                                                    <option value="DCVS">DCVS</option>\
                                                    <option value="DCIS">DCIS</option>\
                                                    <option value="DWVS">DWVS</option>\
                                                    <option value="DWIS">DWIS</option>\
                                                    <option value="NCVS">NCVS</option>\
                                                    <option value="NCIS">NCIS</option>\
                                                    <option value="NWVS">NWVS</option>\
                                                    <option value="NWIS">NWIS</option>\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <div class="col-sm-3">\
                                            <div class="form-group">\
                                                <small style="font-weight: bold; color:#67748e;">HV-1</small>\
                                                <input id="hv1" name="hv1" type="number" class="form-control hv blackInReadOnly calculateTimeCod1" style="text-transform: uppercase" value="' +
                                        hv1 + '">\
                                            </div>\
                                        </div>\
                                    </div>');

                                    $('.selectCod').select2();
                                    $('#btnAgregarCod').css('display', 'inline-block');

                                    $('.calculateTimeCod1').change(function() {
                                        calculateTimeCod(1);
                                    });
                                }
                            }
                        }).then(function() {
                            if (res.cod2 !== null && res.hv2 !== null && numCods === 1) {
                                const regex = /^([A-Za-z]+)-(\d+)([A-Za-z]+)$/;
                                const match = res.cod2.match(regex);
                                if (match !== null) {
                                    const cod2_siglas = match[1];
                                    const cod2_numero = match[2];
                                    const cod2_condicion = match[3];
                                    const hv2 = res.hv2;
                                    arrayHvCods.push(hv2);
                                    numCods = 2;

                                    $.ajax({
                                        type: "post",
                                        url: "{{ route('codigos_mision_json') }}",
                                        success: function(res) {
                                            if (res) {
                                                $('.div_cods').append('<div class="row">\
                                                    <small style="font-weight: bold; color:#67748e;">COD-2</small>\
                                                    <div class="col-sm-3">\
                                                        <div class="form-group">\
                                                            <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>\
                                                            <select id="siglas2" name="siglas2" class="form-control siglas selectCod">\
                                                                <option value="' + cod2_siglas + '">' + cod2_siglas + '</option>\
                                                                @foreach ($codigoTipoMisionSiglas as $data)\
                                                                    <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>\
                                                                @endforeach\
                                                            </select>\
                                                        </div>\
                                                    </div>\
                                                    <div class="col-sm-3">\
                                                        <div class="form-group">\
                                                            <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>\
                                                            <select id="codigo2" name="codigo2" class="form-control codigo selectCod">\
                                                            <option value="' + cod2_numero + '">' + cod2_numero + '</option>\
                                                            @foreach ($codigoMision as $data)\
                                                                <option value="{{ $data->codigo }}">{{ $data->codigo }}</option>\
                                                            @endforeach\
                                                            </select>\
                                                        </div>\
                                                    </div>\
                                                    <div class="col-sm-3">\
                                                        <div class="form-group">\
                                                            <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>\
                                                            <select id="condicion2" name="condicion2" class="form-control condicion selectCod">\
                                                                <option value="' + cod2_condicion + '">' + cod2_condicion +
                                                    '</option>\
                                                                <option value="DCV">DCV</option>\
                                                                <option value="DCI">DCI</option>\
                                                                <option value="DWV">DWV</option>\
                                                                <option value="DWI">DWI</option>\
                                                                <option value="NCV">NCV</option>\
                                                                <option value="NCI">NCI</option>\
                                                                <option value="NWV">NWV</option>\
                                                                <option value="NWI">NWI</option>\
                                                                <option value="DCVG">DCVG</option>\
                                                                <option value="DCIG">DCIG</option>\
                                                                <option value="DWVG">DWVG</option>\
                                                                <option value="DWIG">DWIG</option>\
                                                                <option value="NCVG">NCVG</option>\
                                                                <option value="NCIG">NCIG</option>\
                                                                <option value="NWVG">NWVG</option>\
                                                                <option value="NWIG">NWIG</option>\
                                                                <option value="DCVF">DCVF</option>\
                                                                <option value="DCIF">DCIF</option>\
                                                                <option value="DWVF">DWVF</option>\
                                                                <option value="DWIF">DWIF</option>\
                                                                <option value="NCVF">NCVF</option>\
                                                                <option value="NCIF">NCIF</option>\
                                                                <option value="NWVF">NWVF</option>\
                                                                <option value="NWIF">NWIF</option>\
                                                                <option value="DCVA">DCVA</option>\
                                                                <option value="DCIA">DCIA</option>\
                                                                <option value="DWVA">DWVA</option>\
                                                                <option value="DWIA">DWIA</option>\
                                                                <option value="NCVA">NCVA</option>\
                                                                <option value="NCIA">NCIA</option>\
                                                                <option value="NWVA">NWVA</option>\
                                                                <option value="NWIA">NWIA</option>\
                                                                <option value="DCVL">DCVL</option>\
                                                                <option value="DCIL">DCIL</option>\
                                                                <option value="DWVL">DWVL</option>\
                                                                <option value="DWIL">DWIL</option>\
                                                                <option value="NCVL">NCVL</option>\
                                                                <option value="NCIL">NCIL</option>\
                                                                <option value="NWVL">NWVL</option>\
                                                                <option value="NWIL">NWIL</option>\
                                                                <option value="DCVH">DCVH</option>\
                                                                <option value="DCIH">DCIH</option>\
                                                                <option value="DWVH">DWVH</option>\
                                                                <option value="DWIH">DWIH</option>\
                                                                <option value="NCVH">NCVH</option>\
                                                                <option value="NCIH">NCIH</option>\
                                                                <option value="NWVH">NWVH</option>\
                                                                <option value="NWIH">NWIH</option>\
                                                                <option value="DCVS">DCVS</option>\
                                                                <option value="DCIS">DCIS</option>\
                                                                <option value="DWVS">DWVS</option>\
                                                                <option value="DWIS">DWIS</option>\
                                                                <option value="NCVS">NCVS</option>\
                                                                <option value="NCIS">NCIS</option>\
                                                                <option value="NWVS">NWVS</option>\
                                                                <option value="NWIS">NWIS</option>\
                                                            </select>\
                                                        </div>\
                                                    </div>\
                                                    <div class="col-sm-3">\
                                                        <div class="form-group">\
                                                            <small style="font-weight: bold; color:#67748e;">HV-2</small>\
                                                            <input id="hv2" name="hv2" type="number" class="form-control hv blackInReadOnly calculateTimeCod2" style="text-transform: uppercase" value="' +
                                                    hv2 + '">\
                                                        </div>\
                                                    </div>\
                                                </div>');

                                                $('.selectCod').select2();
                                                $('#btnAgregarCod').css('display',
                                                    'inline-block');
                                                $('.calculateTimeCod2').change(function() {
                                                    calculateTimeCod(2);
                                                });
                                            }
                                        }
                                    }).then(function() {
                                        if (res.cod3 !== null && res.hv3 !== null && numCods ===
                                            2) {
                                            const regex = /^([A-Za-z]+)-(\d+)([A-Za-z]+)$/;
                                            const match = res.cod3.match(regex);
                                            if (match !== null) {
                                                const cod3_siglas = match[1];
                                                const cod3_numero = match[2];
                                                const cod3_condicion = match[3];
                                                const hv3 = res.hv3;
                                                arrayHvCods.push(hv3);
                                                numCods = 3;

                                                $.ajax({
                                                    type: "post",
                                                    url: "{{ route('codigos_mision_json') }}",
                                                    success: function(res) {
                                                        if (res) {
                                                            $('.div_cods').append('<div class="row">\
                                                                <small style="font-weight: bold; color:#67748e;">COD-3</small>\
                                                                <div class="col-sm-3">\
                                                                    <div class="form-group">\
                                                                        <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>\
                                                                        <select id="siglas3" name="siglas3" class="form-control siglas selectCod">\
                                                                            <option value="' + cod3_siglas + '">' +
                                                                cod3_siglas + '</option>\
                                                                            @foreach ($codigoTipoMisionSiglas as $data)\
                                                                                <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>\
                                                                            @endforeach\
                                                                        </select>\
                                                                    </div>\
                                                                </div>\
                                                                <div class="col-sm-3">\
                                                                    <div class="form-group">\
                                                                        <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>\
                                                                        <select id="codigo3" name="codigo3" class="form-control codigo selectCod">\
                                                                        <option value="' + cod3_numero + '">' +
                                                                cod3_numero + '</option>\
                                                                        @foreach ($codigoMision as $data)\
                                                                            <option value="{{ $data->codigo }}">{{ $data->codigo }}</option>\
                                                                        @endforeach\
                                                                        </select>\
                                                                    </div>\
                                                                </div>\
                                                                <div class="col-sm-3">\
                                                                    <div class="form-group">\
                                                                        <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>\
                                                                        <select id="condicion3" name="condicion3" class="form-control condicion selectCod">\
                                                                            <option value="' + cod3_condicion + '">' +
                                                                cod3_condicion +
                                                                '</option>\
                                                                            <option value="DCV">DCV</option>\
                                                                            <option value="DCI">DCI</option>\
                                                                            <option value="DWV">DWV</option>\
                                                                            <option value="DWI">DWI</option>\
                                                                            <option value="NCV">NCV</option>\
                                                                            <option value="NCI">NCI</option>\
                                                                            <option value="NWV">NWV</option>\
                                                                            <option value="NWI">NWI</option>\
                                                                            <option value="DCVG">DCVG</option>\
                                                                            <option value="DCIG">DCIG</option>\
                                                                            <option value="DWVG">DWVG</option>\
                                                                            <option value="DWIG">DWIG</option>\
                                                                            <option value="NCVG">NCVG</option>\
                                                                            <option value="NCIG">NCIG</option>\
                                                                            <option value="NWVG">NWVG</option>\
                                                                            <option value="NWIG">NWIG</option>\
                                                                            <option value="DCVF">DCVF</option>\
                                                                            <option value="DCIF">DCIF</option>\
                                                                            <option value="DWVF">DWVF</option>\
                                                                            <option value="DWIF">DWIF</option>\
                                                                            <option value="NCVF">NCVF</option>\
                                                                            <option value="NCIF">NCIF</option>\
                                                                            <option value="NWVF">NWVF</option>\
                                                                            <option value="NWIF">NWIF</option>\
                                                                            <option value="DCVA">DCVA</option>\
                                                                            <option value="DCIA">DCIA</option>\
                                                                            <option value="DWVA">DWVA</option>\
                                                                            <option value="DWIA">DWIA</option>\
                                                                            <option value="NCVA">NCVA</option>\
                                                                            <option value="NCIA">NCIA</option>\
                                                                            <option value="NWVA">NWVA</option>\
                                                                            <option value="NWIA">NWIA</option>\
                                                                            <option value="DCVL">DCVL</option>\
                                                                            <option value="DCIL">DCIL</option>\
                                                                            <option value="DWVL">DWVL</option>\
                                                                            <option value="DWIL">DWIL</option>\
                                                                            <option value="NCVL">NCVL</option>\
                                                                            <option value="NCIL">NCIL</option>\
                                                                            <option value="NWVL">NWVL</option>\
                                                                            <option value="NWIL">NWIL</option>\
                                                                            <option value="DCVH">DCVH</option>\
                                                                            <option value="DCIH">DCIH</option>\
                                                                            <option value="DWVH">DWVH</option>\
                                                                            <option value="DWIH">DWIH</option>\
                                                                            <option value="NCVH">NCVH</option>\
                                                                            <option value="NCIH">NCIH</option>\
                                                                            <option value="NWVH">NWVH</option>\
                                                                            <option value="NWIH">NWIH</option>\
                                                                            <option value="DCVS">DCVS</option>\
                                                                            <option value="DCIS">DCIS</option>\
                                                                            <option value="DWVS">DWVS</option>\
                                                                            <option value="DWIS">DWIS</option>\
                                                                            <option value="NCVS">NCVS</option>\
                                                                            <option value="NCIS">NCIS</option>\
                                                                            <option value="NWVS">NWVS</option>\
                                                                            <option value="NWIS">NWIS</option>\
                                                                        </select>\
                                                                    </div>\
                                                                </div>\
                                                                <div class="col-sm-3">\
                                                                    <div class="form-group">\
                                                                        <small style="font-weight: bold; color:#67748e;">HV-3</small>\
                                                                        <input id="hv3" name="hv3" type="number" class="form-control hv blackInReadOnly calculateTimeCod3" style="text-transform: uppercase" value="' +
                                                                hv3 + '">\
                                                                    </div>\
                                                                </div>\
                                                            </div>');

                                                            $('.selectCod').select2();
                                                            $('#btnAgregarCod').css(
                                                                'display',
                                                                'inline-block');
                                                            $('.calculateTimeCod3').change(function() {
                                                                calculateTimeCod(3);
                                                            });
                                                        }
                                                    }
                                                }).then(function() {
                                                    if (res.cod4 !== null && res.hv4 !==
                                                        null && numCods === 3) {
                                                        const regex =
                                                            /^([A-Za-z]+)-(\d+)([A-Za-z]+)$/;
                                                        const match = res.cod4.match(regex);
                                                        if (match !== null) {
                                                            const cod4_siglas = match[1];
                                                            const cod4_numero = match[2];
                                                            const cod4_condicion = match[3];
                                                            const hv4 = res.hv4;
                                                            arrayHvCods.push(hv4);
                                                            numCods = 4;

                                                            $.ajax({
                                                                type: "post",
                                                                url: "{{ route('codigos_mision_json') }}",
                                                                success: function(
                                                                    res) {
                                                                    if (res) {
                                                                        $('.div_cods')
                                                                            .append('<div class="row">\
                                                                            <small style="font-weight: bold; color:#67748e;">COD-4</small>\
                                                                            <div class="col-sm-3">\
                                                                                <div class="form-group">\
                                                                                    <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>\
                                                                                    <select id="siglas4" name="siglas4" class="form-control siglas selectCod">\
                                                                                        <option value="' + cod4_siglas + '">' +
                                                                                cod4_siglas + '</option>\
                                                                                        @foreach ($codigoTipoMisionSiglas as $data)\
                                                                                            <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>\
                                                                                        @endforeach\
                                                                                    </select>\
                                                                                </div>\
                                                                            </div>\
                                                                            <div class="col-sm-3">\
                                                                                <div class="form-group">\
                                                                                    <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>\
                                                                                    <select id="codigo4" name="codigo4" class="form-control codigo selectCod">\
                                                                                    <option value="' + cod4_numero + '">' + cod4_numero + '</option>\
                                                                                    @foreach ($codigoMision as $data)\
                                                                                        <option value="{{ $data->codigo }}">{{ $data->codigo }}</option>\
                                                                                    @endforeach\
                                                                                    </select>\
                                                                                </div>\
                                                                            </div>\
                                                                            <div class="col-sm-3">\
                                                                                <div class="form-group">\
                                                                                    <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>\
                                                                                    <select id="condicion4" name="condicion4" class="form-control condicion selectCod">\
                                                                                        <option value="' + cod4_condicion + '">' +
                                                                                cod4_condicion +
                                                                                '</option>\
                                                                                        <option value="DCV">DCV</option>\
                                                                                        <option value="DCI">DCI</option>\
                                                                                        <option value="DWV">DWV</option>\
                                                                                        <option value="DWI">DWI</option>\
                                                                                        <option value="NCV">NCV</option>\
                                                                                        <option value="NCI">NCI</option>\
                                                                                        <option value="NWV">NWV</option>\
                                                                                        <option value="NWI">NWI</option>\
                                                                                        <option value="DCVG">DCVG</option>\
                                                                                        <option value="DCIG">DCIG</option>\
                                                                                        <option value="DWVG">DWVG</option>\
                                                                                        <option value="DWIG">DWIG</option>\
                                                                                        <option value="NCVG">NCVG</option>\
                                                                                        <option value="NCIG">NCIG</option>\
                                                                                        <option value="NWVG">NWVG</option>\
                                                                                        <option value="NWIG">NWIG</option>\
                                                                                        <option value="DCVF">DCVF</option>\
                                                                                        <option value="DCIF">DCIF</option>\
                                                                                        <option value="DWVF">DWVF</option>\
                                                                                        <option value="DWIF">DWIF</option>\
                                                                                        <option value="NCVF">NCVF</option>\
                                                                                        <option value="NCIF">NCIF</option>\
                                                                                        <option value="NWVF">NWVF</option>\
                                                                                        <option value="NWIF">NWIF</option>\
                                                                                        <option value="DCVA">DCVA</option>\
                                                                                        <option value="DCIA">DCIA</option>\
                                                                                        <option value="DWVA">DWVA</option>\
                                                                                        <option value="DWIA">DWIA</option>\
                                                                                        <option value="NCVA">NCVA</option>\
                                                                                        <option value="NCIA">NCIA</option>\
                                                                                        <option value="NWVA">NWVA</option>\
                                                                                        <option value="NWIA">NWIA</option>\
                                                                                        <option value="DCVL">DCVL</option>\
                                                                                        <option value="DCIL">DCIL</option>\
                                                                                        <option value="DWVL">DWVL</option>\
                                                                                        <option value="DWIL">DWIL</option>\
                                                                                        <option value="NCVL">NCVL</option>\
                                                                                        <option value="NCIL">NCIL</option>\
                                                                                        <option value="NWVL">NWVL</option>\
                                                                                        <option value="NWIL">NWIL</option>\
                                                                                        <option value="DCVH">DCVH</option>\
                                                                                        <option value="DCIH">DCIH</option>\
                                                                                        <option value="DWVH">DWVH</option>\
                                                                                        <option value="DWIH">DWIH</option>\
                                                                                        <option value="NCVH">NCVH</option>\
                                                                                        <option value="NCIH">NCIH</option>\
                                                                                        <option value="NWVH">NWVH</option>\
                                                                                        <option value="NWIH">NWIH</option>\
                                                                                        <option value="DCVS">DCVS</option>\
                                                                                        <option value="DCIS">DCIS</option>\
                                                                                        <option value="DWVS">DWVS</option>\
                                                                                        <option value="DWIS">DWIS</option>\
                                                                                        <option value="NCVS">NCVS</option>\
                                                                                        <option value="NCIS">NCIS</option>\
                                                                                        <option value="NWVS">NWVS</option>\
                                                                                        <option value="NWIS">NWIS</option>\
                                                                                    </select>\
                                                                                </div>\
                                                                            </div>\
                                                                            <div class="col-sm-3">\
                                                                                <div class="form-group">\
                                                                                    <small style="font-weight: bold; color:#67748e;">HV-4</small>\
                                                                                    <input id="hv4" name="hv4" type="number" class="form-control hv blackInReadOnly calculateTimeCod4" style="text-transform: uppercase" value="' +
                                                                                hv4 + '">\
                                                                                </div>\
                                                                            </div>\
                                                                        </div>');

                                                                        $('.selectCod')
                                                                            .select2();
                                                                        $('#btnAgregarCod')
                                                                            .css('display','none');
                                                                        $('.calculateTimeCod4').change(function() {
                                                                            calculateTimeCod(4);
                                                                        });
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }

                console.log(res)
                if (res.consumibles.length > 0) {
                    let data = res.consumibles
                    for (let index = 0; index < data.length; index++) {
                        newRowAdd =
                            '<div id="row" class="removInput"><div style="margin-bottom: 0;" class="input-group"><div style="padding:10px" class="col-sm-4"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CONSUMIBLES</small> <select name="consumibles[]"  class="form-control consumibles" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value="' +
                            data[index].id + '">' + data[index].consumible + '</option></select> </div></div>' +
                            '<div style="padding:10px" class="col-sm-3"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">UNIDADES</small> <select name="unidades[]" class="form-control unidades" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value="' +
                            data[index].id + '">' + data[index].unidad + '</option></select> </div></div>' +
                            '<div style="padding:10px" class="col-sm-3"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CANTIDAD</small><input value="' +
                            data[index].cantidad +
                            '" name="cantidad[]" type="number" class="form-control cantidad" style="height: 37px;border: 1px solid #a5a9bf7a;"></div></div>' +
                            '<div style="padding:10px" class="col-sm-1"><div style="margin-bottom: 0;" class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="DeleteRow" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

                        $('#newinput').append(newRowAdd);

                    }
                }


            }
            // function updateConsumo(response){
            //     let misionID = response
            //     var loop = $('input[name="cantidad[]"]').length
            //     var cantidad = []
            //     var consumiblesArray = []
            //     var unidadesArray = []
            //     $("input[name='cantidad[]']").each(function() {
            //         cantidad.push({
            //             cantidad:$(this).val(),
            //         });
            //     });
            //     $("select[name='consumibles[]']").find(":selected").each(function() {
            //         consumiblesArray.push({
            //             consumible:$(this).text(),
            //         });
            //     });
            //     $("select[name='unidades[]']").find(":selected").each(function() {
            //         unidadesArray.push({
            //             unidades:$(this).text(),
            //         });
            //     });
            //     var consumiblesDATA = []
            //     for (let index = 0; index < loop; index++) {
            //         consumiblesDATA.push({
            //             ov_ota_om:$('.ov_ota_om').val().toUpperCase(),
            //             fam0001_id:id_fam0001,
            //             fam0001_a1_mision_id:misionID,
            //             cantidad:cantidad[index].cantidad,
            //             consumiblesArray:consumiblesArray[index].consumible,
            //             unidadesArray:unidadesArray[index].unidades
            //         });
            //     }
            //     console.log(consumiblesDATA)
            //     if (loop>0) {
            //         //GUARDAR CONSUMIBLES
            //         $.ajax({
            //         url:"{{ route('store_a1_consumibles') }}",
            //         method:'POST',
            //         data:{
            //             consumiblesDATA: consumiblesDATA,
            //             },
            //             success:function(response){
            //                 if(response.success){
            //                     $("#newinput").remove();
            //                 }
            //             },
            //             error:function(error){
            //                 console.log(error)
            //             }
            //         });
            //     }
            // }
            function guardarConsumo(response) {
                //GUARDAR CONSUMIBLES A1 MISION
                let misionID = response
                var loop = $('input[name="cantidad[]"]').length
                var cantidad = []
                var consumiblesArray = []
                var unidadesArray = []
                $("input[name='cantidad[]']").each(function() {
                    cantidad.push({
                        cantidad: $(this).val(),
                    });
                });
                $("select[name='consumibles[]']").find(":selected").each(function() {
                    consumiblesArray.push({
                        consumible: $(this).text(),
                    });
                });
                $("select[name='unidades[]']").find(":selected").each(function() {
                    unidadesArray.push({
                        unidades: $(this).text(),
                    });
                });
                var consumiblesDATA = []
                for (let index = 0; index < loop; index++) {
                    consumiblesDATA.push({
                        ov_ota_om: $('.ov_ota_om').val().toUpperCase(),
                        fam0001_id: id_fam0001,
                        fam0001_a1_mision_id: misionID,
                        cantidad: cantidad[index].cantidad,
                        consumiblesArray: consumiblesArray[index].consumible,
                        unidadesArray: unidadesArray[index].unidades
                    });
                }
                console.log(consumiblesDATA)
                if (loop > 0) {
                    //GUARDAR CONSUMIBLES
                    $.ajax({
                        url: "{{ route('store_a1_consumibles') }}",
                        method: 'POST',
                        data: {
                            consumiblesDATA: consumiblesDATA,
                        },
                        success: function(response) {
                            if (response.success) {
                                $("#newinput").remove();
                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }

            }

            function data_vuelos(fam0001_id) {
                var id = fam0001_id;
                if (id) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('data_v_trip') }}',
                        data: {
                            "id": id
                        },
                        success: function(res) {
                            let data = res[0]
                            $("#v_trip").empty();
                            $("#v_trip").append('<option></option>');

                            $("#n_vuelo").empty();
                            $("#n_vuelo").append('<option></option>');

                            $.each(res, function(key, value) {
                                if (value.completado == 'cancelado') {
                                    $("#v_trip").append('<option class="load_v_trip" value="' +
                                        value.id + '" disabled>V' + value.vuelo +
                                        '(cancelada)</option>');
                                    $("#n_vuelo").append('<option class="load_n_trip" value="' +
                                        value.id + '" disabled>V' + value.vuelo +
                                        '(cancelada)</option>');
                                } else {
                                    $("#v_trip").append('<option class="load_v_trip" value="' +
                                        value.id + '">V' + value.vuelo + '</option>');
                                    $("#n_vuelo").append('<option class="load_n_trip" value="' +
                                        value.id + '">V' + value.vuelo + '</option>');
                                }
                            });
                        }
                    });
                }
            }

            function datos_tripulacion(res) {
                $.each(res, function(key, value) {
                    $('#B1_data').append(
                        "<tr id='delete_b1" + value.id + "'>\
                    <td style='padding-left: 20px;'>" + value.v_trip + "</td>\
                    <td style='padding-left: 20px;'>" + value.grado_nombre_data + "</td>\
                    <td style='padding-left: 20px;'>" + value.cedula + "</td>\
                    <td style='padding-left: 20px;'>" + value.codigo_funcion + "</td>\
                    <td style='padding-left: 20px;'>" + value.hv + "</td>\
                    <td style='padding-left: 20px;'><button value=" + value.id +
                        " style='background: #212529;color: white;' type='button' class='btn btn-success editar_B1_trip'>Editar</button><button value=" +
                        value.id +
                        " style='background:red;' class='btn btn-danger delete_b1_trip' type='button'><i style='font-size: 22px; color:white;' class='ti-trash'></i></button><button value=" +
                        value.id + " style='background:grey;' class='btn btn-danger copy_b1_tripulacion' type='button'><i style='font-size: 22px; color:white;' class='fa fa-copy'></i></button></td>\
                    </tr>");
                })
            }

            function guardarAterrizajes(response) {
                //GUARDAR ATERRIZAJES A1 MISION
                let misionIDHV = response
                var TipoAtr = []
                var cantidadAtr = []
                $("select[name='tipo_aterrizaje[]']").find(":selected").each(function() {
                    var dato = $(this).text()
                    var datos = dato.split(" - ")
                    var cod_aterr = datos[0]
                    TipoAtr.push({
                        TipoAtr: cod_aterr,
                    });
                });

                $("input[name='cantidad_atr[]']").each(function() {
                    cantidadAtr.push({
                        cantidadAtr: $(this).val(),
                    });
                });

                var loop = $('input[name="cantidad_atr[]"]').length
                var aterrizajeData = []
                for (let index = 0; index < loop; index++) {
                    aterrizajeData.push({
                        ov_ota_om: $('.ov_ota_om').val().toUpperCase(),
                        fam0001_id: id_fam0001,
                        fam0001_a1_mision_id: misionIDHV,
                        TIP_ATERRIZAJE: TipoAtr[index] === undefined ? null : TipoAtr[index].TipoAtr,
                        CANTIDAD: cantidadAtr[index] === undefined ? null : cantidadAtr[index].cantidadAtr
                    });
                }
                if (loop > 0) {
                    //GUARDAR ATERRIZAJE
                    $.ajax({
                        url: "{{ route('store_aterrizaje') }}",
                        method: 'POST',
                        data: {
                            aterrizajeData: aterrizajeData,
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log(response)
                                $("#operacionVuelo").remove();
                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }
            }

            function calculateTime() {
                var encend = $('.encend').val()
                var despeg = $('.despeg').val();
                var aterriz = $('.aterriz').val();
                var apag = $('.apag').val();

                var segEncend = new Date("01/01/2007 " + encend).getTime();
                var segDespeg = new Date("01/01/2007 " + despeg).getTime();

                // if($('.encend').val()!=""){
                //     var minDiffSeg = ((ssegDespeg - segEncend)/60)/1000;
                // }
                var minDiffSeg = 0.0
                if ($('.despeg').val() != "") {
                    var minDiffSeg = ((segDespeg - segEncend) / 60) / 1000;
                }

                var segAterriz = new Date("01/01/2007 " + aterriz).getTime();

                if ($('.aterriz').val() != "") {
                    if (segDespeg > segAterriz) {
                        alert('No puedes registrar una hora menor a la de Despegue')
                    } else {
                        var dataStep = ((segAterriz - segDespeg) / 60) / 1000;
                        minDiffSeg = dataStep + minDiffSeg
                    }
                }

                var segApag = new Date("01/01/2007 " + apag).getTime();

                if ($('.apag').val() != "") {
                    if (segAterriz > segApag) {
                        alert('No puedes registrar una hora menor a la de Aterrizaje')
                    }
                    var dataStep2 = ((segApag - segAterriz) / 60) / 1000;
                    minDiffSeg = dataStep2 + minDiffSeg
                }

                $(".pasar_calculo").val(((minDiffSeg * 0.1) / 6).toFixed(1));

                if (minDiffSeg > 0) {
                    $('#btnAgregarCod').css('display', 'inline-block');
                    if (numCods == 0) {
                        aggCod();
                    } else {
                        $('#hv1').val(((minDiffSeg * 0.1) / 6).toFixed(1));
                        sumTotalHv = ((minDiffSeg * 0.1) / 6).toFixed(1);
                        arrayHvCods = [];
                        arrayHvCods.push($('#hv1').val());
                    }
                }
            }
            $(".calculateTime").change(calculateTime);
            calculateTime();
            $('.sendingData').keyup(function() {
                $('.sameData').val($(this).val());
            });

            function edit_B1(res) {

                $('.load_id_trip').val(res.id)

                setTimeout(function() {
                    $(".funcion").val(res.funcion).trigger('change')
                }, 1400);
                setTimeout(function() {
                    $(".grado_nombre").val(res.grado_nombre_id).trigger('change')
                }, 1600);

                $('.tipo_despegue').val(res.tipo_despegue).trigger('change')

                $(".v_trip").val(res.fam0001_a1_mision_id).trigger('change')

                $('.codigo_trip').val(res.COD)
                $('.load_registro_hv').val(res.hv)
                $('.load_cedula_empleado').val(res.cedula)

                $('.cod1_trip').val(res.cod1)
                $('.registro_hv1').val(res.hv1)
                $('.cod2_trip').val(res.cod2)
                $('.registro_hv2').val(res.hv2)
                $('.cod3_trip').val(res.cod3)
                $('.registro_hv3').val(res.hv3)
                $('.cod4_trip').val(res.cod4)
                $('.registro_hv4').val(res.hv4)

                $('.edit_input_b1').prop('hidden', false);
                $('.add_edit_b1_input').prop('hidden', true);

            }

            function update_B1(B1Steps) {
                $(".actualizar_b1").click(function() {
                    $.ajax({
                        url: "{{ route('actualizar_b1') }}",
                        method: 'POST',
                        data: {
                            id: $(".load_id_trip").val(),
                            ov_ota_om: ($('.ov_ota_om').val()).toUpperCase(),
                            fam0001_id: id_fam0001,
                            fam0001_a1_mision_id: $('.v_trip').val(),
                            v_trip: $('.v_mision').val(),
                            //
                            grado_nombre_id: $('.grado_nombre').val(),
                            grado_nombre_data: $('.grado_nombre').find(":selected").text(),
                            funcion: $('.funcion').val(),
                            codigo_funcion: $('.funcion').find(":selected").text(),
                            //
                            cedula: $('.cedula_empleado').val(),
                            tipo_despegue: $('.tipo_despegue').val(),
                            COD: $('.codigo_trip').val(),
                            HV: $('.load_registro_hv').val(),

                            COD1: $('.cod1_trip').val(),
                            COD2: $('.cod2_trip').val(),
                            COD3: $('.cod3_trip').val(),
                            COD4: $('.cod4_trip').val(),

                            HV1: $('.registro_hv1').val(),
                            HV2: $('.registro_hv2').val(),
                            HV3: $('.registro_hv3').val(),
                            HV4: $('.registro_hv4').val(),

                            completado: B1Steps[0].completado == "completado" ? "completado" :
                                "paso3",
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response) {
                                console.log(response)
                                // misionID = $(".load_id_mision").val()
                                // guardarConsumo(misionID);
                                cleanB1()
                                $('.edit_input_b1').prop('hidden', true);
                                $('.add_edit_b1_input').prop('hidden', false);
                                Swal.fire({
                                    title: 'Actualizado!',
                                    text: 'Datos de Tripulación Actualizado Correctamente.',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                            }
                        }
                    });
                });
            }

            function updateClean_B1() {
                $(".update_b1_clean").click(function() {
                    cleanB1()
                    $('.edit_input_b1').prop('hidden', true);
                    $('.add_edit_b1_input').prop('hidden', false);
                });
            }

            function updateClean_A1() {
                $(".update_A1_clean").click(function() {
                    cleanA1()
                    $('.edit_input').prop('hidden', true);
                    $('.add_edit_input').prop('hidden', false);
                    $(".removInput").remove();
                    $(".div_cods").empty();
                    numCods = 0;
                    $('#btnAgregarCod').css('display', 'none');
                });
            }

            function datos_aterrizaje(response) {
                $.each(response, function(key, value) {
                    $('#A3_data').append(
                        "<tr id='delete_a3" + value.id + "'>\
                    <td style='padding-left: 20px;'>V" + value.n_vuelo + "</td>\
                    <td style='padding-left: 20px;'>" + value.apoyo_carga + "</td>\
                    <td style='padding-left: 20px;'>" + value.pesocargaTotal + "</td>\
                    <td style='padding-left: 20px;'>" + value.volCargaTotal + "</td>\
                    <td style='padding-left: 20px;'><button value=" + value.id +
                        " style='background: #212529;color: white;' type='button' class='btn btn-success editar_A3'>Editar</button><button value=" +
                        value.id + " style='background:red;' class='btn btn-danger borrar_A3' type='button'><i style='font-size: 22px; color:white;' class='ti-trash'></i></button></td>\
                    </tr>");
                })
            }

            function dalete_A3(id) {
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
                            url: "{{ route('delete_a3') }}",
                            method: 'POST',
                            data: {
                                id: id
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    cleanA3()
                                    $("#delete_a3" + id + "").remove();
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
            }

            function edit_A3(res) {
                $('.load_id_a3').val(res.id)

                $('.n_vuelo').val(res.n_vuelo).trigger('change')
                $('.apoyo_carga').val(res.apoyo_carga),
                    $('.pesocargaTotal').val(res.pesocargaTotal),
                    $('.volCargaTotal').val(res.volCargaTotal),
                    $('.seca').val(res.seca),
                    $('.liquida').val(res.liquida),
                    $('.comb').val(res.comb),
                    $('.ammto').val(res.ammto),
                    $('.tox_pel').val(res.tox_pel),
                    $('.mil').val(res.mil),
                    $('.gob').val(res.gob),
                    $('.no_gob').val(res.no_gob),
                    $('.civil').val(res.civil),
                    $('.cant_animales').val(res.cant_animales),
                    $('.carga').val(res.carga),
                    $('.pers').val(res.pers)

                $('.edit_input_a3').prop('hidden', false);
                $('.add_edit_carga_input').prop('hidden', true);
            }

            function update_A3(A3Steps) {
                $(".actualizar_A3").click(function() {
                    $.ajax({
                        url: "{{ route('actualizar_a3') }}",
                        method: 'POST',
                        data: {
                            id: $(".load_id_a3").val(),
                            ov_ota_om: ($('.ov_ota_om').val()).toUpperCase(),
                            fam0001_id: id_fam0001,
                            fam0001_a1_mision_id: $('.n_vuelo').val(),
                            n_vuelo: $('.n_vuelo').val(),
                            apoyo_carga: $('.apoyo_carga').val(),
                            pesocargaTotal: $('.pesocargaTotal').val(),
                            volCargaTotal: $('.volCargaTotal').val(),
                            seca: $('.seca').val(),
                            liquida: $('.liquida').val(),
                            comb: $('.comb').val(),
                            ammto: $('.ammto').val(),
                            tox_pel: $('.tox_pel').val(),
                            mil: $('.mil').val(),
                            gob: $('.gob').val(),
                            no_gob: $('.no_gob').val(),
                            civil: $('.civil').val(),
                            cant_animales: $('.cant_animales').val(),
                            carga: $('.carga').val(),
                            pers: $('.pers').val(),
                            completado: A3Steps[0].completado == "completado" ? "completado" :
                                "paso4",
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response) {
                                console.log(response)
                                cleanA3()
                                Swal.fire({
                                    title: 'Actualizado!',
                                    text: 'Datos de la Carga Actualizado Correctamente.',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: true,
                                });
                            }
                        }
                    });
                });
            }

            function updateClean_A3() {
                $(".update_a3_clean").click(function() {
                    cleanA3()
                    $('.edit_input_a3').prop('hidden', true);
                    $('.add_edit_carga_input').prop('hidden', false);
                });
            }

            $('.concluir_alerta').on('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '¿Estas Seguro de concluir la alerta?',
                    text: "¡Atención, no podrá revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).prop('disabled', true);
                        $.ajax({
                            url: "{{ route('concluir_alerta') }}",
                            method: 'POST',
                            data: {
                                id: id_fam0001
                            },
                            cache: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        title: 'La Alerta ha concluido!',
                                        text: '¡Atención!',
                                        icon: 'success',
                                        timer: 3000,
                                        showConfirmButton: true,
                                    });
                                    window.location.href =
                                        "{{ URL::to('/FormaFAM_status') }}/" +
                                        id_fam0001;
                                }
                            }
                        });
                    }
                });
            });

            function comprobar_status_misiones(id_fam0001) {

                $("#finish").prop('disabled', true);

                $.ajax({
                    url: "{{ route('comprobar_status_misiones') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id_fam0001
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Sin Misiones Pendientes',
                                text: '¡Atención!. Misiones pendientes: ' + response.data,
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            $("#finish").prop('disabled', false);
                        } else {
                            Swal.fire({
                                title: '¡Misiones o Alertas sin completar!',
                                text: '¡Atención!. Misiones pendientes: ' + response.data,
                                icon: 'error',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            $("#finish").prop('disabled', true);
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }

            function comprobar_horas_cod() {
                var hv = $(".registro_manual").val();
                var hv1 = $(".hv1").val();
                if (hv < hv1) {
                    alert('La hora no coincide con la hora de la misión');
                    $(".hv1").val(hv);
                } else {

                }
            }
            $(".hv1").change(comprobar_horas_cod);
            comprobar_horas_cod();

            $('#btnAgregarCod').click(function() {
                aggCod();
            });

            function aggCod() {
                //alert('agregarCod');

                numCods = numCods + 1;

                if (numCods == 1) {
                    var hvpas = $(".registro_manual").val();
                    arrayHvCods.push(hvpas);
                } else {
                    var hvpas = 0.0;
                    arrayHvCods.push(hvpas);
                }

                $('.div_cods').append('<div class="row">\
                    <small style="font-weight: bold; color:#67748e;">COD-' + numCods + '</small>\
                    <div class="col-sm-3">\
                        <div class="form-group">\
                            <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>\
                            <select id="siglas' + numCods + '" name="siglas' + numCods + '" class="form-control siglas selectCod">\
                                <option value=""></option>\
                                @foreach ($codigoTipoMisionSiglas as $data)\
                                    <option value="{{ $data->siglas }}">{{ $data->siglas }}</option>\
                                @endforeach\
                            </select>\
                        </div>\
                    </div>\
                    <div class="col-sm-3">\
                        <div class="form-group">\
                            <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>\
                            <select id="codigo' + numCods + '" name="codigo' + numCods + '" class="form-control codigo selectCod">\
                            <option value=""></option>\
                            @foreach ($codigoMision as $data)\
                                <option value="{{ $data->codigo }}">{{ $data->codigo }}</option>\
                            @endforeach\
                            </select>\
                        </div>\
                    </div>\
                    <div class="col-sm-3">\
                        <div class="form-group">\
                            <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>\
                            <select id="condicion' + numCods + '" name="condicion' + numCods + '" class="form-control condicion selectCod">\
                                <option value=""></option>\
                                <option value="DCV">DCV</option>\
                                <option value="DCI">DCI</option>\
                                <option value="DWV">DWV</option>\
                                <option value="DWI">DWI</option>\
                                <option value="NCV">NCV</option>\
                                <option value="NCI">NCI</option>\
                                <option value="NWV">NWV</option>\
                                <option value="NWI">NWI</option>\
                                <option value="DCVG">DCVG</option>\
                                <option value="DCIG">DCIG</option>\
                                <option value="DWVG">DWVG</option>\
                                <option value="DWIG">DWIG</option>\
                                <option value="NCVG">NCVG</option>\
                                <option value="NCIG">NCIG</option>\
                                <option value="NWVG">NWVG</option>\
                                <option value="NWIG">NWIG</option>\
                                <option value="DCVF">DCVF</option>\
                                <option value="DCIF">DCIF</option>\
                                <option value="DWVF">DWVF</option>\
                                <option value="DWIF">DWIF</option>\
                                <option value="NCVF">NCVF</option>\
                                <option value="NCIF">NCIF</option>\
                                <option value="NWVF">NWVF</option>\
                                <option value="NWIF">NWIF</option>\
                                <option value="DCVA">DCVA</option>\
                                <option value="DCIA">DCIA</option>\
                                <option value="DWVA">DWVA</option>\
                                <option value="DWIA">DWIA</option>\
                                <option value="NCVA">NCVA</option>\
                                <option value="NCIA">NCIA</option>\
                                <option value="NWVA">NWVA</option>\
                                <option value="NWIA">NWIA</option>\
                                <option value="DCVL">DCVL</option>\
                                <option value="DCIL">DCIL</option>\
                                <option value="DWVL">DWVL</option>\
                                <option value="DWIL">DWIL</option>\
                                <option value="NCVL">NCVL</option>\
                                <option value="NCIL">NCIL</option>\
                                <option value="NWVL">NWVL</option>\
                                <option value="NWIL">NWIL</option>\
                                <option value="DCVH">DCVH</option>\
                                <option value="DCIH">DCIH</option>\
                                <option value="DWVH">DWVH</option>\
                                <option value="DWIH">DWIH</option>\
                                <option value="NCVH">NCVH</option>\
                                <option value="NCIH">NCIH</option>\
                                <option value="NWVH">NWVH</option>\
                                <option value="NWIH">NWIH</option>\
                                <option value="DCVS">DCVS</option>\
                                <option value="DCIS">DCIS</option>\
                                <option value="DWVS">DWVS</option>\
                                <option value="DWIS">DWIS</option>\
                                <option value="NCVS">NCVS</option>\
                                <option value="NCIS">NCIS</option>\
                                <option value="NWVS">NWVS</option>\
                                <option value="NWIS">NWIS</option>\
                            </select>\
                        </div>\
                    </div>\
                    <div class="col-sm-3">\
                        <div class="form-group">\
                            <small style="font-weight: bold; color:#67748e;">HV-' + numCods + '</small>\
                            <input id="hv' + numCods + '" name="hv' + numCods +
                    '" type="number" class="form-control hv blackInReadOnly calculateTimeCod' + numCods +'" style="text-transform: uppercase" value="' +
                    hvpas + '">\
                        </div>\
                    </div>\
                </div>');

                $('.selectCod').select2({
                    placeholder: "Seleccione una opción"
                });

                if (numCods == 4) {
                    $('#btnAgregarCod').css('display', 'none');
                }

                $('.calculateTimeCod' + numCods).change((function(num) {
                    return function() {
                        calculateTimeCod(num);
                    }
                })(numCods));
            }

            function calculateTimeCod(numHvCod) {

                let tamanoArray = arrayHvCods.length;
                let sum = 0.0;
                let sum2 = 0.0;

                if ($('#hv1').val()) {
                    sum2 += parseFloat($('#hv1').val());
                }
                if ($('#hv2').val()) {
                    sum2 += parseFloat($('#hv2').val());
                }
                if ($('#hv3').val()) {
                    sum2 += parseFloat($('#hv3').val());
                }
                if ($('#hv4').val()) {
                    sum2 += parseFloat($('#hv4').val());
                }

                for (let i = 0; i < tamanoArray; i++) {
                    sum = sum += parseFloat(arrayHvCods[i]);
                }

                if(sum2 > sum){
                    alert('Error, la suma de las horas (COD) es mayor a la hora de vuelo total');
                    for (let i = 0; i < tamanoArray; i++) {
                        $('.calculateTimeCod' + numHvCod).val(0.0);
                    }
                } else {
                    sumTotalHv = sum2;
                }
            }
        });
    </script>
@endsection
