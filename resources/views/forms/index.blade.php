@extends('layouts.user_type.auth')
@section('title', 'form')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success mx-4" role="alert">
    <span class="text-white">{{ $message }}</span>
</div>
@endif
@section('styles')
<link href="template/wizard/css/paper-bootstrap-wizard.css" rel="stylesheet" /> 
@endsection
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="container">
                <div class="row">
                    <div style="margin: 0 auto;" class="col-sm-11 col-sm-offset-2">
                        @include('forms.step_one_card')
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="orange" id="wizardProfile">
                                <form action="" method="">
                                    <div class="wizard-header text-center">
                                    </div>
                                    <div class="wizard-navigation">
                                        <div class="progress-with-circle">
                                             <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#about" data-toggle="tab">
                                                    <div class="icon-circle step_one_color">
                                                        <i class="ti-files"></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">DATOS AERONAVE</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#a1" data-toggle="tab">
                                                    <div class="icon-circle step_two_color">
                                                        <i class="ti-flag-alt-2"></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">A1 - DATOS DE LA MISIÓN</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#dddd" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-user"></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">B1 - DATOS DE LA TRIPULACIÓN DE VUELO</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#address" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-package    "></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">A3 - DATOS DE CARGA Y PASAJEROS</p>
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
                                                            <input name="fecha" type="date" class="form-control fecha load_fecha" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>OV / OTA / OM <small></small></h6>
                                                            <input name="ov_ota_om" style="text-transform: uppercase" type="text" class="form-control ov_ota_om load_ov_ota_om" placeholder="" required="true">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>COMPONENTE / ORGANISMO <small></small></h6>
                                                            <select name="componente_organismo" class="form-control componente_organismo load_componente_organismo" id="organismo">
                                                                <option value="">Seleccionar..</option>
                                                                @foreach($componentes as $data) 
                                                                    <option value="{{$data->organismo}}">{{$data->componente}} - {{$data->organismo}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>UNIDAD<small></small></h6>
                                                            <select name="unidad" class="form-control unidad load_unidad" id="grupos">
                                                                <option value=""></option>
                                                                @foreach($unidad as $data) 
                                                                    <option value="{{$data->codigos}}"><strong>{{$data->codigos}}</strong> - {{$data->unidad}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>AERONAVE / MODELO</h6>
                                                            <select class="selectpicker form-control aeronaves aeronave_modelo load_aeronave" id="naves" name="aeronave_modelo">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>SERIAL</h6>
                                                            <select name="serial" id="serial" class="form-control serial serial_naves load_serial">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>MATRICULA <small></small></h6>
                                                            <select name="matricula" id="matricula" class="form-control matricula load_matricula">
                                                                <option value=""></option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                    <div class="col-sm-4 col-sm-offset-1">
                                                        <div class="form-group">
                                                            <h6>BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                                            <select name="base_estacion" class="form-control base_estacion load_estacion">
                                                                <option value=""></option>
                                                                @foreach($bases as $data) 
                                                                    <option value="{{$data->id}}">{{$data->descripcion}} - {{$data->siglas}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-sm-offset-1">
                                                        <div class="form-group">
                                                            <h6>JEFE DE MAQUINA EN LINEA DE VUELO <small></small></h6>
                                                            <select name="jefe_maquina" class="form-control jefe_maquina load_jefe_maquina">
                                                                <option value=""></option>
                                                                @foreach($jefeMaquina as $data) 
                                                                    <option value="{{$data->empleado->codigo_empleado}}">{{$data->empleado->cedula}} - {{$data->empleado->nombre1}}  {{$data->empleado->apellido1}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button value="" id="editar_paso1" hidden="true" style="background: rgb(190, 200, 227);color: rgb(0, 0, 0);" type="button" class="btn btn-fill btn-info btn-wd show_edit_paso1">ACTUALIZAR</button>
                                            
                                        </div>
                                        <div class="tab-pane" id="a1">
                                            @include('forms.A1')
                                        </div>
                                        <div class="tab-pane" id="dddd">
                                            @include('forms.B1')
                                        </div>
                                        <div class="tab-pane" id="address">
                                           
                                        </div>
                                    </div>
                                    <br>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input id="stepInputData" style="background: linear-gradient(310deg,#506793,#273244);" type='button' class='btn btn-next btn-fill btn-info btn-wd enviar' name='next' value='Guardar'/>
                                            <input id="stepInputDataNext" style="background: linear-gradient(310deg,#506793,#273244);" type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Siguiente'  hidden="true"/>
                                            
                                            <input type='button' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='Terminar' />
                                        </div>
    
                                        <div class="pull-left">
                                            <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Atras' />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- wizard container -->
                    </div>
                </div><!-- end row -->
            </div> <!--  big container -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        //PASO 1
        $('.componente_organismo').select2();
        $('#grupos').select2();
        $('#naves').select2();
        $('#serial').select2();
        $('#matricula').select2();
        $('.base_estacion').select2();
        $('.jefe_maquina').select2();
        //PASO 2
        $('.ordenada_por').select2();
        $('.en_apoyo').select2();
        $('.codigo').select2();
        $('.ruta_desde').select2();
        $('.ruta_hasta').select2();
        $('.en_apoyo_A2').select2();
        //PASO 3
        $('.v_trip').select2();
        $('.funcion').select2();
        $('.grado_nombre').select2();
        $('.tipo_despegue').select2();
  
        //LIMPIAR A1
        function cleanA1() {
            $('.ordenada_por').val('').trigger('change');
            $('.en_apoyo').val('').trigger('change');
            $('.codigo').val('').trigger('change');
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
        }
        
        var id_fam0001;
        var fam0001_a1_mision_id;

        //SELECT DINAMICOS PASO #1
        $("#grupos").change(function(){
            var id = $(this).val();
            if(id){
                $.ajax({
                    type:'GET',
                    url:'{{ route("aeronaves_grupos") }}',
                    data:{"unidad" : id },
                    success:function(res){
                        console.log(res);
                        $("#naves").empty();
                        $("#naves").append('<option>Seleccionar..</option>');
                        $.each(res,function(key,value){
                            $("#naves").append('<option class="load_aeronave" value="'+value.id+'">'+value.aeronave+' - '+value.modelo+'</option>');
                        });
                    }
                }); 
            }
        });
        $('#naves').on('change',function(){
            var naveId = $(this).val();  
            if(naveId){
                $.ajax({
                    type:"GET",
                    url:"{{ route('seriales') }}",
                    data : { "id" : naveId },
                    success:function(res){        
                        if(res){
                            $("#serial").empty();
                            $("#serial").append('<option>Seleccionar..</option>');
                            $.each(res,function(key,value){
                                $("#serial").append('<option class="load_serial" value="'+value.serial+'">'+value.serial+'</option>');
                            });
                        }
                    }
                });
                $.ajax({
                    type:"GET",
                    url:"{{ route('matriculas') }}",
                    data : { "id" : naveId },
                    success:function(res){        
                        if(res){
                            $("#matricula").empty();
                            $("#matricula").append('<option>Seleccionar..</option>');
                            $.each(res,function(key,value){
                                $("#matricula").append('<option class="load_matricula" value="'+value.matricula+'">'+value.matricula+'</option>');
                            });
                        }
                    }
                });
            }
        });

        //TRAER DATA DEL PRIMER PASO
        $.ajax({
            url:"{{ route('steps') }}",
            method:'POST',
            data:{ 
                _token:'{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(response){
                if(response.headerData.length>0){
                    let famSteps = response.headerData[0]
                    id_fam0001 = famSteps.id;
                    if (famSteps.completado === "completado") {
                        console.log('pasos completados')
                    }
                    if (famSteps.completado === "paso1") {
                        var dataHeader = 1;
                        //PASOS COMPLETADOS
                        if(dataHeader>0){
                            $('#step_one').prop('hidden', false);
                            $('.show_edit_paso1').prop('hidden', false);
                            $(".show_edit_paso1").val(famSteps.id);
                            $("#ov_ota_om").text(famSteps.ov_ota_om);
                            $("#aeronave_modelo").text(famSteps.componente_organismo);
                            $("#fecha").text(famSteps.fecha);

                            //CARGAR DATOS DE PASOS 
                            $('#stepInputData').prop('hidden', true);
                            $('#stepInputDataNext').prop('hidden', false);
                            $(".step_one_color").css({"border": "3px solid #309830","background":"rgb(68 147 68)","color": "white"});
                            
                            $(".load_fecha").val(famSteps.fecha)
                            $(".load_ov_ota_om").val(famSteps.ov_ota_om)

                            setTimeout(function() { 
                                $(".load_componente_organismo").val(famSteps.componente_organismo).trigger('change')
                            }, 1000);

                            $(".load_unidad").val(famSteps.unidad).trigger('change')

                            cargarAeronavesModelos(famSteps.unidad)
                            setTimeout(function() { 
                                $(".load_aeronave").val(famSteps.aeronave_modelo).trigger('change')
                            }, 1200);
                            
                            cargarSeriales(famSteps.aeronave_modelo)
                            setTimeout(function() { 
                                $(".load_serial").val(famSteps.serial).trigger('change')
                            }, 3000);
                            
                            cargarMatriculas(famSteps.aeronave_modelo)
                            setTimeout(function() { 
                                $(".load_matricula").val(famSteps.matricula).trigger('change')
                            }, 3000);
                            
                            $(".load_estacion").val(famSteps.base_estacion).trigger('change')
                            $(".load_jefe_maquina").val(famSteps.jefe_maquina).trigger('change')

                            //CARGAR PASO 2
                            let A1Steps = response.A1_data
                            if (A1Steps.length>0) {
                                $(".step_two_color").css({"border": "3px solid #309830","background":"rgb(68 147 68)","color": "white"});
                                
                                var counter = 1;
                                $.each(A1Steps, function (key, value){
                                $('#A1_data').append(
                                    "<tr id='delete_a1_mision"+value.id+"'>\
                                    <td>V"+counter+"</td>\
                                    <td>"+value.ordenada_por+"</td>\
                                    <td>"+value.en_apoyo+"</td>\
                                    <td>"+value.ruta_desde+"</td>\
                                    <td>"+value.ruta_hasta+"</td>\
                                    <td><button  value="+value.id+" style='background: #212529;color: white;' type='button' class='btn btn-success editar_a1_mision'>Editar</button><button value="+value.id+" style='background:red;' class='btn btn-danger delete_a1_mision' type='button'><i style='font-size: 22px; color:white;' class='ti-trash'></i></button></td>\
                                    </tr>");
                                    counter += 1;
                                })

                                //ELIMINAR MISION (METER EN HELPER)
                                $(".delete_a1_mision").click(function() {
                                    var id = $(this).val();
                                    console.log(id)
                                    $.ajax({
                                        url:"{{ route('delete_a1_mision') }}",
                                        method:'POST',
                                        data:{id:id},
                                        cache: false,
                                        dataType: 'json',
                                        success: function(response){
                                            if(response){
                                                cleanA1()
                                                $("#delete_a1_mision"+id+"").remove();
                                                alert('eliminacion correcta')
                                            }
                                        }
                                    });
                                });

                                //EDITAR MISION
                                $(".editar_a1_mision").click(function() {
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
                                                console.log(res)
                                                let consumblesEdit = response.consumibles
                                                console.log(consumblesEdit)
                                            }
                                            else{
                                                alert('Fallo en la peticion con el servidor')
                                            }
                                        }
                                    });
                                    
                                });
                                //ACTUALIZAR MISION (METER EN HELPER)
                                $(".actualizar_a1_mision").click(function() {
                                    console.log(id_fam0001)
                                    $.ajax({
                                        url:"{{ route('actualizar_a1_mision') }}",
                                        method:'POST',
                                        data:{
                                            id:$(".load_id_mision").val(),
                                            ordenada_por:$(".load_ordenado_por").val(),
                                            en_apoyo:$('.load_en_apoyo').val(),
                                            codigo:$('.load_codigo').val(),
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
                                            total:$('.load_total').val(),
                                            ciclos_tren:$('.load_ciclos_tren').val(),
                                            ov_ota_om:$('.ov_ota_om').val().toUpperCase(),
                                            fam0001_id: id_fam0001,
                                            en_apoyo_A2:$(".load_en_apoyo_A2").val(),
                                            descripcion_A2:$('.load_descripcion_A2').val(),
                                            completado: "paso2",
                                        }, 
                                        cache: false,
                                        dataType: 'json',
                                        success: function(response){
                                            if(response){
                                                misionID = $(".load_id_mision").val()
                                                guardarConsumo(misionID);
                                                console.log(response)
                                                cleanA1()
                                            }
                                        }
                                    });
                                });
                            }

                            //EDITAR PASO1 (METER EN HELPER)
                            $("#editar_paso1").click(function() {
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
                                        completado: "paso1",
                                        id:id_edit,
                                    },
                                    cache: false,
                                    dataType: 'json',
                                    success: function(response){
                                        if(response){
                                            console.log('editado')
                                            alert('Campos Editado Correctamente')
                                        }
                                        else{
                                            alert('Fallo en la peticion con el servidor')
                                        }
                                    }
                                });
                                
                            });
                            
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
        $(".enviar").click(function(e){
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

            console.log(serial)
            //VALIDAR PASO UNO HEADER
            if(ov_ota_om===""){
                alert('no puedes guardar el ov_ota_om vacio')
                console.log('no puedes guardar datos vacios')
            }else{
                //ENVIAR
                $.ajax({
                url:"{{ route('store_header') }}",
                method:'POST',
                data:{
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
                    success:function(response){
                        if(response.success){
                            console.log(response)
                            id_fam0001 = response.data.id;
                            $("#ov_ota_om").text(response.data.ov_ota_om);
                            $("#aeronave_modelo").text(componente_organismo);
                            $("#fecha").text(fecha);
                            $('#step_one').prop('hidden', false);
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
            
        });
        
        //PASO #2 - AGREGAR CONSUMIBLES
        $("#rowAdder").click(function () {
            $.ajax({
                url:"{{ route('consumibles') }}",
                method:'POST',
                data:{ 
                    _token:'{{ csrf_token() }}'
                },
                cache: false,
                dataType: 'json',
                success: function(response){
                    if(response){
                        $('#consumibles').select2();
                        $(".consumibles").empty();
                        $(".consumibles").append('<option>Seleccionar..</option>');
                        $.each(response.consumibles ,function(key,value){
                            $(".consumibles").append('<option class="load_consumible" value="'+key.id+'">'+value.consumible+'</option>');
                        });
                        
                        $('#unidades').select2();
                        $(".unidades").empty();
                        $(".unidades").append('<option>Seleccionar..</option>');
                        $.each(response.unidades ,function(key,value){
                            $(".unidades").append('<option class="load_unidades" value="'+key.id+'">'+value.unidad+'</option>');
                        });
                    }
                }
            });
            newRowAdd =
            '<div id="row"><div style="margin-bottom: 0;" class="input-group"><div style="padding:10px" class="col-sm-4"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CONSUMIBLES<small></small></small> <select name="consumibles[]" id="consumibles" class="form-control consumibles" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>'+
            '<div style="padding:10px" class="col-sm-3"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">UNIDADES<small></small></small> <select name="unidades[]" id="unidades" class="form-control unidades" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>'+
            '<div style="padding:10px" class="col-sm-3"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CANTIDAD<small></small></small><input name="cantidad[]" type="number" class="form-control cantidad" style="height: 37px;border: 1px solid #a5a9bf7a;"></div></div>'+
            '<div style="padding:10px" class="col-sm-1"><div style="margin-bottom: 0;" class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="DeleteRow" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

            $('#newinput').append(newRowAdd);
        });
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })

        //PASO #2 - GUARDAR A1 MISION
        $(".enviar_a1_mision").click(function(e){
            e.preventDefault();
            var ordenada_por = $('.ordenada_por').val();
            var en_apoyo = $('.en_apoyo').val();
            var codigo = $('.codigo').val();
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
            var total = $('.total').val();
            var ciclos_tren = $('.ciclos_tren').val();

            var en_apoyo_A2 = $('.en_apoyo_A2').val();
            var descripcion_A2 = $('.descripcion_A2').val();
            
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
                    en_apoyo:en_apoyo,
                    codigo:codigo.toUpperCase(),
                    ruta_desde:ruta_desde,
                    ruta_hasta:ruta_hasta,
                    encend:encend.toUpperCase(),
                    despeg:despeg.toUpperCase(),
                    aterriz:aterriz.toUpperCase(),
                    apag:apag.toUpperCase(),
                    registro_manual: registro_manual.toUpperCase(),
                    horometro:horometro.toUpperCase(),
                    ind_vuelo:ind_vuelo.toUpperCase(),
                    toque_desp:toque_desp,
                    low_go:low_go,
                    total:total,
                    ciclos_tren:ciclos_tren,
                    ov_ota_om:$('.ov_ota_om').val().toUpperCase(),
                    fam0001_id: id_fam0001,
                    en_apoyo_A2:en_apoyo_A2,
                    descripcion_A2:descripcion_A2.toUpperCase(),
                    completado: "paso2",
                    },
                    success:function(response){
                        if(response.success){
                            //limpiar
                            cleanA1()
                            $("#A1_data tr").remove();

                            let misionID = response.A1_id[0].id;
                            guardarConsumo(misionID);
                            
                            //MOSTRAR A1
                            let res = response.data;
                            var counter = 1;
                            $.each(res, function (key, value){
                            $('#A1_data').append(
                                "<tr id='delete_a1_mision"+value.id+"'>\
                                <td>V"+counter+"</td>\
                                <td>"+value.ordenada_por+"</td>\
                                <td>"+value.en_apoyo+"</td>\
                                <td>"+value.ruta_desde+"</td>\
                                <td>"+value.ruta_hasta+"</td>\
                                <td><button  value="+value.id+" style='background: #212529;color: white;' type='button' class='btn btn-success editar_a1_mision'>Editar</button><button value="+value.id+" style='background:red;' class='btn btn-danger delete_a1_mision' type='button'><i style='font-size: 22px; color:white;' class='ti-trash'></i></button></td>\
                                </tr>");
                                counter += 1;
                            })

                            //ELIMINAR MISION (METER EN HELPER)
                            $(".delete_a1_mision").click(function() {
                                var id = $(this).val();
                                console.log(id)
                                $.ajax({
                                    url:"{{ route('delete_a1_mision') }}",
                                    method:'POST',
                                    data:{id:id},
                                    cache: false,
                                    dataType: 'json',
                                    success: function(response){
                                        if(response){
                                            cleanA1()
                                            $("#delete_a1_mision"+id+"").remove();
                                            alert('eliminacion correcta')
                                        }
                                    }
                                });
                            });

                            //EDITAR MISION (METER EN HELPER)
                            $(".editar_a1_mision").click(function() {
                                var id_edit = $(this).val();
                                console.log(id_edit)
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
                                        }
                                        else{
                                            alert('Fallo en la peticion con el servidor')
                                        }
                                    }
                                });
                                
                            });

                            //ACTUALIZAR MISION (METER EN HELPER)
                            $(".actualizar_a1_mision").click(function() {
                                //console.log(id_fam0001)
                                //console.log($(".load_ordenado_por").find(":selected").text())
                                $.ajax({
                                    url:"{{ route('actualizar_a1_mision') }}",
                                    method:'POST',
                                    data:{
                                        id:$(".load_id_mision").val(),
                                        ordenada_por:$(".load_ordenado_por").val(),
                                        en_apoyo:$('.load_en_apoyo').val(),
                                        codigo:$('.load_codigo').val(),
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
                                        total:$('.load_total').val(),
                                        ciclos_tren:$('.load_ciclos_tren').val(),
                                        ov_ota_om:$('.ov_ota_om').val().toUpperCase(),
                                        fam0001_id: id_fam0001,

                                        en_apoyo_A2:$(".load_en_apoyo_A2").val(),
                                        descripcion_A2:$('.load_descripcion_A2').val(),

                                        completado: "paso2",
                                    }, 
                                    cache: false,
                                    dataType: 'json',
                                    success: function(response){
                                        if(response){
                                            console.log(response)
                                            misionID = $(".load_id_mision").val()
                                            guardarConsumo(misionID);
                                            cleanA1()
                                            alert('Mision Actualziada correctamente')
                                        }
                                    }
                                });
                            });
                             
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
            
        });

        //PASO #3 - BOTON AGREGAR OPERACIONES EN VUELO
        $("#OV_ADD").click(function () {
            $.ajax({
                url:"{{ route('codigos_mision_json') }}",
                method:'POST',
                data:{ 
                    _token:'{{ csrf_token() }}'
                },
                cache: false,
                dataType: 'json',
                success: function(response){
                    //console.log(response)
                    if(response){
                        $('#COD').select2();
                        //$(".COD").empty();
                        $(".COD").append('<option>Seleccionar..</option>');
                        $.each(response ,function(key,value){
                            $(".COD").append('<option class="load_COD" value="'+key.id+'">'+value.codigo+'</option>');
                        });
                    }
                }
            });
            nuevaOperacionVuelo =
            '<div id="operacionVuelo"><div style="margin-bottom: 0;" class="input-group"><div style="padding:10px" class="col-sm-4"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">COD<small></small></small> <select name="COD[]" id="COD" class="form-control COD load_COD" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>'+
            '<div style="padding:10px" class="col-sm-2"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">HV<small></small></small> <input type="number" name="HV[]" id="HV" class="form-control HV load_HV" style="height: 37px;border: 1px solid #a5a9bf7a;"></input> </div></div>'+
            '<div style="padding:10px" class="col-sm-1"><div style="margin-bottom: 0;" class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="BorrarOperacionVuelo" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

            $('#nuevaOperacionVuelo').append(nuevaOperacionVuelo);
        });
        $("body").on("click", "#BorrarOperacionVuelo", function () {
            $(this).parents("#operacionVuelo").remove();
        })
        //PASO #3 - BOTON AGREGAR ATERRIZAJES
        $("#ATR_ADD").click(function(){
            var numItems = jQuery('.operacionVuelo').length
            if(numItems <3){
                nuevoAterrizaje =
                '<div class="operacionVuelo" id="operacionVuelo"><div style="margin-bottom: 0;" class="input-group"><div style="padding:10px" class="col-sm-6"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">TIPO<small></small></small> <select name="tipo_aterrizaje[]" id="tipo_aterrizaje" class="form-control tipo_aterrizaje load_tipo_aterrizaje" style="height: 37px;border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>'+
                '<div style="padding:10px" class="col-sm-2"><div style="margin-bottom: 0;" class="form-group"><small style="font-weight: bold; color:#67748e;">CANTIDAD<small></small></small> <input type="number" name="cantidad[]" id="cantidad" class="form-control cantidad load_cantidad" style="height: 37px;border: 1px solid #a5a9bf7a;"></input> </div></div>'+
                '<div style="padding:10px" class="col-sm-1"><div style="margin-bottom: 0;" class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="BorrarAterrizaje" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

                $('#nuevoAterrizaje').append(nuevoAterrizaje);
            }else{
                alert('No puedes agregar mas de tres aterrizajes')
            }
        });
        $("body").on("click", "#BorrarAterrizaje", function () {
            $(this).parents("#operacionVuelo").remove();
        })
        
        //FUNCIONES HELPER
        function cargarAeronavesModelos(grupo_id) {
            if(grupo_id){
                $.ajax({
                    type:'GET',
                    url:'{{ route("aeronaves_grupos") }}',
                    data:{"unidad" : grupo_id },
                    success:function(res){
                        $("#naves").empty();
                        $("#naves").append('<option>Cargando..</option>');
                        $.each(res,function(key,value){
                            $("#naves").append('<option class="load_aeronave" value="'+value.id+'">'+value.aeronave+' - '+value.modelo+'</option>');
                        });
                    }
                }); 
                
            }
        }
        function cargarSeriales(naveId) {
            if(naveId){
                $.ajax({
                    type:"GET",
                    url:"{{ route('seriales') }}",
                    data : { "id" : naveId },
                    success:function(res){        
                        if(res){
                            $("#serial").empty();
                            $("#serial").append('<option>Cargando..</option>');
                            $.each(res,function(key,value){
                                $("#serial").append('<option class="load_serial" value="'+value.serial+'">'+value.serial+'</option>');
                            });
                        }
                    }
                });
            }
        }
        function cargarMatriculas(naveId) {
            if(naveId){
                $.ajax({
                    type:"GET",
                    url:"{{ route('matriculas') }}",
                    data : { "id" : naveId },
                    success:function(res){        
                        if(res){
                            $("#matricula").empty();
                            $("#matricula").append('<option>Seleccionar..</option>');
                            $.each(res,function(key,value){
                                $("#matricula").append('<option class="load_matricula" value="'+value.matricula+'">'+value.matricula+'</option>');
                            });
                        }
                    }
                });
            }
        }
        function edit_A1(res) {
            $(".load_ordenado_por").val(res.ordenada_por).trigger('change')
            $(".load_en_apoyo").val(res.en_apoyo).trigger('change')
            $(".load_codigo").val(res.codigo).trigger('change')
            $(".load_ruta_desde").val(res.ruta_desde).trigger('change')
            $(".load_ruta_hasta").val(res.ruta_hasta).trigger('change')

            $('.load_encend').css('border-color','#66b700c4').val(res.encend)
            $('.load_despeg').css('border-color','#66b700c4').val(res.despeg)
            $('.load_aterriz').css('border-color','#66b700c4').val(res.aterriz)
            $('.load_apag').css('border-color','#66b700c4').val(res.apag)
            $('.load_registro_manual').css('border-color','#66b700c4').val(res.registro_manual)
            $('.load_horometro').css('border-color','#66b700c4').val(res.horometro)
            $('.load_ind_vuelo').css('border-color','#66b700c4').val(res.ind_vuelo)
            $('.load_toque_desp').css('border-color','#66b700c4').val(res.toque_desp)
            $('.load_low_go').css('border-color','#66b700c4').val(res.low_go)
            $('.load_total').css('border-color','#66b700c4').val(res.total)
            $('.load_ciclos_tren').css('border-color','#66b700c4').val(res.ciclos_tren)
            $('.load_id_mision').val(res.id)

            $(".load_en_apoyo_A2").css('border-color','#66b700c4').val(res.en_apoyo_A2).trigger('change')
            $('.load_descripcion_A2').css('border-color','#66b700c4').val(res.descripcion_A2)
            
            $('.edit_input').prop('hidden', false);
            $('.add_edit_input').prop('hidden', true);

            // let consumblesEdit = response.consumibles
            // $.each(consumblesEdit, function (key, value){
            // $('#consumblesEdit').append(
            //     "<tr id='consumibles"+value.id+"'>\
            //     <td>"+counter+"</td>\
            //     <td>"+value.consumible+"</td>\
            //     <td>"+value.unidad+"</td>\
            //     <td>"+value.cantidad+"</td>\
            //     </tr>");
            //     counter += 1;
            // })
            
        }
        function guardarConsumo(response) {
            //GUARDAR CONSUMIBLES A1 MISION
            let misionID = response
            var loop = $('input[name="cantidad[]"]').length
            var cantidad = []
            var consumiblesArray = []
            var unidadesArray = []
            $("input[name='cantidad[]']").each(function() {
                cantidad.push({
                    cantidad:$(this).val(),
                });
            });
            $("select[name='consumibles[]']").find(":selected").each(function() {
                consumiblesArray.push({
                    consumible:$(this).text(),
                });
            });
            $("select[name='unidades[]']").find(":selected").each(function() {
                unidadesArray.push({
                    unidades:$(this).text(),
                });
            });
            var consumiblesDATA = []
            for (let index = 0; index < loop; index++) {
                consumiblesDATA.push({
                    ov_ota_om:$('.ov_ota_om').val().toUpperCase(),
                    fam0001_id:id_fam0001,
                    fam0001_a1_mision_id:misionID,
                    cantidad:cantidad[index].cantidad,
                    consumiblesArray:consumiblesArray[index].consumible,
                    unidadesArray:unidadesArray[index].unidades
                });
            } 
            console.log(consumiblesDATA)
            
            //GUARDAR CONSUMIBLES
            $.ajax({
            url:"{{ route('store_a1_consumibles') }}",
            method:'POST',
            data:{
                consumiblesDATA: consumiblesDATA,
                },
                success:function(response){
                    if(response.success){
                        console.log(response)
                        $("#newinput").remove();
                    }
                },
                error:function(error){
                    console.log(error)
                }
            });
            
        }
        
    });
</script>
@endsection