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
                                        {{-- <h3 class="wizard-title">FAM-0002</h3>
                                        <p class="category">Generar Nueva FAM-0002.</p> --}}
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
                                                {{-- <br>
                                                <div style="padding-top: 30px;" class="col-sm-12">
                                                    <h5 style="float: left" class="info-text">FAM-0002A</h5>
                                                </div> --}}
                                                
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
                                                            <select name="componente_organismo" class="form-control componente_organismo load_componente_organismo">
                                                                <option value=""></option>
                                                                @foreach($componentes as $data) 
                                                                    <option value="{{$data->id}}">{{$data->componente}} - {{$data->organismo}}</option>
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
                                                            {{-- <select class="aeronaves form-control" name="aeronaves">
                                                                @foreach($aeronaveModelos as $naves) 
                                                                    <option value="{{$naves->id}}">{{$naves->aeronave}} / {{$naves->modelo}}</option>
                                                                @endforeach
                                                            </select> --}}

                                                            <select class="selectpicker form-control aeronaves aeronave_modelo load_aeronave" id="naves" name="aeronave_modelo">
                                                                <option value=""></option>
                                                                {{-- <option>Seleccionar..</option>
                                                                @foreach($aeronaveModelos as $naves) 
                                                                    <option value="{{$naves->id}}">{{$naves->aeronave}} / {{$naves->modelo}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>SERIAL</h6>
                                                            <select name="serial" id="serial" class="form-control serial load_serial">
                                                                <option value=""></option>
                                                                {{-- <option>Seleccionar..</option>
                                                                @foreach($matriculas as $data) 
                                                                    @if ($data->serial==null)
                                                                    @else
                                                                    <option value="{{$data->id}}">{{$data->serial}}</option>
                                                                    @endif
                                                                @endforeach --}}
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
                                                                {{-- <option>Seleccionar..</option>
                                                                @foreach($matriculas as $data) 
                                                                    <option value="{{$data->id}}">{{$data->matricula}}</option>
                                                                @endforeach --}}
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
                                                                    <option value="{{$data->empleado->codigo_empleado}}">{{$data->empleado->nombre1}} - {{$data->empleado->cedula}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="">
                                                        <input type='button' class='btn btn-info btn-wd enviar' name='enviar' value='enviar' />
                                                    </div> --}}
                                                </div>
                                                {{-- <div class="row">
                                                    <i id="step_save" style="font-size: 20px;" class="ti-save enviar"></i>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="a1">
                                            @include('forms.A1')
                                        </div>
                                        <div class="tab-pane" id="dddd">
                                            
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
    // $(document).ready(function() {
    //     $('.aeronaves').select2();
        //     $( "#dropdown" ).select2({
        //     theme: "bootstrap"
        // });
    // });
    $(document).ready(function () {
        // $('.aeronaves').select2();
        //     $( "#dropdown" ).select2({
        //     theme: "bootstrap"
        // });

        function cleanA1() {
            $('.ordenada_por').val('');
            $('.en_apoyo').val('');
            $('.codigo').val('');
            $('.ruta_desde').val('');
            $('.ruta_hasta').val('');
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
        }
        
        var id_fam0001;
        var fam0001_a1_mision_id;
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
                                $("#serial").append('<option class="load_serial" value="'+key.serial+'">'+value.serial+'</option>');
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
                                $("#matricula").append('<option class="load_matricula" value="'+key.matricula+'">'+value.matricula+'</option>');
                            });
                        }
                    }
                });
            }
        });
        //TRAER DATA DEL PRIMER STEP
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
                        //completado
                    }
                    if (famSteps.completado === "paso1") {
                        var dataHeader = 1;
                        //PASOS COMPLETADOS
                        if(dataHeader>0){
                            $('#step_one').prop('hidden', false);

                            //$('#step_save').prop('hidden', true);
                            $("#ov_ota_om").text(famSteps.ov_ota_om);
                            $("#aeronave_modelo").text(famSteps.aeronave_modelo);
                            $("#fecha").text(famSteps.fecha);

                            //CARGAR DATOS DE PASOS 
                            $(".loadSteps").click(function(e){
                                e.preventDefault();
                                //$("#collapseStepOne").collapse({toggle: false});
                                $('#stepInputData').prop('hidden', true);
                                $('#stepInputDataNext').prop('hidden', false);
                                $(".step_one_color").css('background','rgb(225 225 224)');

                                $(".load_fecha").val(famSteps.fecha).css('border-color','#66b700c4');
                                $(".load_ov_ota_om").val(famSteps.ov_ota_om).css('border-color','#66b700c4');
                                $(".load_componente_organismo").css('border-color','#66b700c4').find(":selected").text(famSteps.componente_organismo)
                                $(".load_unidad").css('border-color','#66b700c4').find(":selected").text(famSteps.unidad)

                                $(".load_aeronave").css('border-color','#66b700c4').find(":selected").text(famSteps.aeronave_modelo)
                                $(".load_serial").css('border-color','#66b700c4').find(":selected").text(famSteps.serial)
                                $(".load_matricula").css('border-color','#66b700c4').find(":selected").text(famSteps.matricula)

                                $(".load_estacion").css('border-color','#66b700c4').find(":selected").text(famSteps.base_estacion)
                                $(".load_jefe_maquina").val(famSteps.jefe_maquina).css('border-color','#66b700c4');
                                
                                //CARGAR PASO 2
                                let A1Steps = response.A1_data
                                if (A1Steps.length>0) {
                                    $(".step_two_color").css('background','rgb(225 225 224)');
                                    $.each(A1Steps, function (key, value){
                                    $('#A1_data').append(
                                        "<tr id='delete_a1_mision"+value.id+"'>\
                                        <td>V</td>\
                                        <td>"+value.ordenada_por+"</td>\
                                        <td>"+value.en_apoyo+"</td>\
                                        <td>"+value.ruta_desde+"</td>\
                                        <td>"+value.ruta_hasta+"</td>\
                                        <td><button  value="+value.id+" style='background: #212529;color: white;' type='button' class='btn btn-success editar_a1_mision'>Editar</button><button value="+value.id+" style='background:red;' class='btn btn-danger delete_a1_mision' type='button'><i style='font-size: 22px; color:white;' class='ti-trash'></i></button></td>\
                                        </tr>");
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
                                                    $(".load_ordenado_por").css('border-color','#66b700c4').find(":selected").text(res.ordenada_por)
                                                    $('.load_en_apoyo').css('border-color','#66b700c4').find(":selected").text(res.en_apoyo)
                                                    $('.load_codigo').css('border-color','#66b700c4').find(":selected").text(res.codigo)
                                                    $('.load_ruta_desde').css('border-color','#66b700c4').find(":selected").text(res.ruta_desde)
                                                    $('.load_ruta_hasta').css('border-color','#66b700c4').find(":selected").text(res.ruta_hasta)
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

                                                    $('.edit_input').prop('hidden', false);
                                                    $('.add_edit_input').prop('hidden', true);
                                                    
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
                                        console.log($(".load_ordenado_por").find(":selected").text())
                                        $.ajax({
                                            url:"{{ route('actualizar_a1_mision') }}",
                                            method:'POST',
                                            data:{
                                                id:$(".load_id_mision").val(),
                                                ordenada_por:$(".load_ordenado_por").find(":selected").text(),
                                                en_apoyo:$('.load_en_apoyo').find(":selected").text(),
                                                codigo:$('.load_codigo').find(":selected").text(),
                                                ruta_desde:$('.load_ruta_desde').find(":selected").text(),
                                                ruta_hasta:$('.load_ruta_hasta').find(":selected").text(),
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
                                                ov_ota_om:$('.ov_ota_om').val(),
                                                fam0001_id: id_fam0001,
                                                completado: "paso2",
                                            }, 
                                            cache: false,
                                            dataType: 'json',
                                            success: function(response){
                                                if(response){
                                                    console.log(response)
                                                    alert('Mision Actualziada correctamente')
                                                    cleanA1()
                                                }
                                            }
                                        });
                                    });
                                }
                            })
                        }
                    }
                    else{
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

        $(".enviar").click(function(e){
            e.preventDefault();
            var fecha = $('.fecha').val();
            var ov_ota_om = $('.ov_ota_om').val();
            var componente_organismo = $('.componente_organismo').find(":selected").text();
            var unidad = $('.unidad').find(":selected").text();
            var aeronave_modelo = $('.aeronave_modelo').find(":selected").text();
            var serial = $('.serial').find(":selected").text();
            var matricula = $('.matricula').find(":selected").text();
            var base_estacion = $('.base_estacion').find(":selected").text();
            var jefe_maquina = $('.jefe_maquina').find(":selected").val();
            
            //VALIDAR PASO UNO HEADER
            if(ov_ota_om===""){
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
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
            
        });

        $("#rowAdder").click(function () {
            //AGREGAR CONSUMIBLES
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
                        $(".consumibles").empty();
                        $(".consumibles").append('<option>Seleccionar..</option>');
                        $.each(response.consumibles ,function(key,value){
                            $(".consumibles").append('<option class="load_consumible" value="'+key.id+'">'+value.consumible+'</option>');
                        });
                        $(".unidades").empty();
                        $(".unidades").append('<option>Seleccionar..</option>');
                        $.each(response.unidades ,function(key,value){
                            $(".unidades").append('<option class="load_unidades" value="'+key.id+'">'+value.unidad+'</option>');
                        });
                    }
                }
            });
            newRowAdd =
            '<div id="row"><div class="input-group"><div style="padding:10px" class="col-sm-4"><div class="form-group"><small style="font-weight: bold; color:#67748e;">CONSUMIBLES<small></small></small> <select name="consumibles[]" id="consumibles" class="form-control consumibles" style="border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>'+
            '<div style="padding:10px" class="col-sm-3"><div class="form-group"><small style="font-weight: bold; color:#67748e;">UNIDADES<small></small></small> <select name="unidades[]" id="unidades" class="form-control unidades" style="border: 1px solid #a5a9bf7a;"><option value=""></option></select> </div></div>'+
            '<div style="padding:10px" class="col-sm-3"><div class="form-group"><small style="font-weight: bold; color:#67748e;">CANTIDAD<small></small></small><input name="cantidad[]" type="number" class="form-control cantidad" style="border: 1px solid #a5a9bf7a;"></div></div>'+
            '<div style="padding:10px" class="col-sm-1"><div class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="DeleteRow" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

            $('#newinput').append(newRowAdd);
        });

        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })

        $(".test").click(function(e){

            var consumiblesArray = []
            var length = $('input[name="cantidad[]"]').length

            $("input[name='cantidad[]']").each(cantidad => {
                $("select[name='consumibles[]']").each(consumible =>{cantidad.map(item =>{
                        consumiblesArray.push({
                            cantidad:item.val(),
                            consumible:consumible.text(),
                        });
                    })
                });
            });

            $("input[name='cantidad[]']").each(function() {
                consumiblesArray.push({
                    cantidad:$(this).val(),
                    consumible:$(this).text(),
                });
            });

            // $("select[name='consumibles[]']").find(":selected").each(function() {
            //     consumiblesArray.push({
            //         consumible:$(this).text(),
            //     });
            // });

            // $("select[name='consumibles[]']").find(":selected").each(function() {
            //     console.log($(this).text())
            // });


            // var data = $('input[name="cantidad[]"]')
            // var cantidad = $('input[name="cantidad[]"]')

            // $.each(cantidad, function (index, value) {
            //     consumiblesArray.push({
            //         data:data[index],
            //         cantidad:value,
            //     });
            // });

            // Juices.map((juice) => {
            //     Fruits.map((fruit) => {
            //         if(juice.juiceId === fruit.fruitId){
            //             finalArray.push({customer: juice.customer, fruit: fruit.name}) 
            //         }
            //     });
            // });
                   
            
            console.log(consumiblesArray)

            
           // var consuLegth = $('.consumibles').find(":selected").text();

            // $("input[name='consumibles[]']").find(":selected").each(function() {
            //     console.log($(this).text())
            // });
            // $("input[name='consumibles[]']").find(":selected").each(function() {
            //     console.log($(this).text())
            // });

            
            // $("input[name='cantidad[]']").each(function() {
            //     console.log($(this).val())
            // });

        })
        //VALIDAR GUARDAR A1 MISION
        $(".enviar_a1_mision").click(function(e){
            e.preventDefault();
            var ordenada_por = $('.ordenada_por').find(":selected").text();
            var en_apoyo = $('.en_apoyo').find(":selected").val();
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
                    ov_ota_om:$('.ov_ota_om').val(),
                    fam0001_id: id_fam0001,
                    completado: "paso2",
                    },
                    success:function(response){
                        if(response.success){
                            //limpiar
                            $('.ordenada_por').val('');
                            $('.en_apoyo').val('');
                            $('.codigo').val('');
                            $('.ruta_desde').val('');
                            $('.ruta_hasta').val('');
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
                            $("#A1_data tr").remove();
                            //$('#A1_data tbody').empty();
                            console.log(response.data)
                            let res = response.data;
                            fam0001_a1_mision_id = response.data.id;
                            $.each(res, function (key, value){
                            $('#A1_data').append(
                                "<tr>\
                                <td>V</td>\
                                <td>"+value.ordenada_por+"</td>\
                                <td>"+value.en_apoyo+"</td>\
                                <td>"+value.ruta_desde+"</td>\
                                <td>"+value.ruta_hasta+"</td>\
                                <td><button style='background: #212529;color: white;' type='button' class='btn btn-success'>Editar</button><button id='delete_a1_mision' value="+value.id+" style='background:red;' class='btn btn-danger delete_a1_mision' type='button'><i style='font-size: 22px; color:white;' class='ti-trash'></i></button></td>\
                                </tr>");
                            })
                            

                            //GUARDAR CONSUMIBLES A1 MISION
                            var consumiblesArray = []
                            // for (let index = 0; index < consumible.length; index++) {
                            //     consumiblesArray.push({
                            //         fam0001_id:id_fam0001,
                            //         ov_ota_om: $('.ov_ota_om').val(),
                            //         fam0001_a1_mision_id:fam0001_a1_mision_id,
                            //         consumible:$('.consumible').find(":selected").text(),
                            //         unidad:$('.unidad').find(":selected").text(),
                            //         cantidad:$('.cantidad').text(),
                            //     });
                            // }

                            // $.ajax({
                            // url:"{{ route('store_a1_consumibles') }}",
                            // method:'POST',
                            //     data:consumiblesArray,
                            //     success:function(response){
                            //         if(response.success){
                            //             console.log(response)
                            //         }
                            //     },
                            //     error:function(error){
                            //         console.log(error)
                            //     }
                            // });

                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
            
        });
        
        

    });


</script>
@endsection