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
                                                    <div class="icon-circle">
                                                        <i class="ti-files" ></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">DATOS AERONAVE</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#a1" data-toggle="tab">
                                                    <div class="icon-circle">
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
                                                            <input name="fecha" type="date" class="form-control fecha" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>OV / OTA / OM <small></small></h6>
                                                            <input name="ov_ota_om" style="text-transform: uppercase" type="text" class="form-control ov_ota_om" placeholder="">
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

                                                            <select class="selectpicker form-control aeronave_modelo load_aeronave" id="naves" name="aeronave_modelo">
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
                                            <input style="background: linear-gradient(310deg,#506793,#273244);" type='button' class='btn btn-next btn-fill btn-info btn-wd enviar' name='next' value='Siguiente' />
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
    // });
    $(document).ready(function () {
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

        $.ajax({
            url:"{{ route('steps') }}",
            method:'POST',
            data:{ 
                _token:'{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(response){
                if(response.length>0){
                    console.log(response[0]);
                    let famSteps = response[0]
                    if (famSteps.completado === "completado") {
                        //completado
                    }else{
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
                                console.log(famSteps.base_estacion)
                                e.preventDefault();
                                //$("#collapseStepOne").collapse({toggle: false});

                                $(".load_fecha").val(famSteps.fecha).css('border-color','#66b700c4');
                                $(".load_ov_ota_om").val(famSteps.ov_ota_om).css('border-color','#66b700c4');
                                $(".load_componente_organismo").css('border-color','#66b700c4').find(":selected").text(famSteps.componente_organismo)
                                $(".load_unidad").css('border-color','#66b700c4').find(":selected").text(famSteps.unidad)

                                $(".load_aeronave").css('border-color','#66b700c4').find(":selected").text(famSteps.aeronave_modelo)
                                $(".load_serial").css('border-color','#66b700c4').find(":selected").text(famSteps.serial)
                                $(".load_matricula").css('border-color','#66b700c4').find(":selected").text(famSteps.matricula)

                                $(".load_estacion").css('border-color','#66b700c4').find(":selected").text(famSteps.base_estacion)
                                $(".load_jefe_maquina").val(famSteps.jefe_maquina).css('border-color','#66b700c4');
                            })
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
            
            //PRIMER PASO
            // var dataHeader = [
            //     {
            //         fecha: fecha,
            //         ov_ota_om: ov_ota_om.toUpperCase(),
            //         componente_organismo: componente_organismo,
            //         unidad: unidad,
            //         aeronave_modelo: aeronave_modelo,
            //         serial: serial,
            //         matricula: matricula,
            //         base_estacion: base_estacion,
            //         jefe_maquina: jefe_maquina,
            //         completado: "paso1",
            //     }
            // ]
            //VALIDAR
            if(ov_ota_om===""){
                console.log('no puedes guardar datos vacios')
            }else{
                //ENVIAR
                $.ajax({
                url:"{{ route('store') }}",
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
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            }
            
        });
        
        //AGREGAR CONSUMIBLES
        $("#rowAdder").click(function () {
            newRowAdd =
            '<div id="row"><div class="input-group"><div style="padding:10px" class="col-sm-4"><div class="form-group"><small style="font-weight: bold; color:#67748e;">CONSUMIBLES<small></small></small><input name="consumibles" type="text" class="form-control" style="border: 1px solid #a5a9bf7a;"></div></div>'+
            '<div style="padding:10px" class="col-sm-3"><div class="form-group"><small style="font-weight: bold; color:#67748e;">UNIDADES<small></small></small><input name="unidades" type="text" class="form-control" style="border: 1px solid #a5a9bf7a;"></div></div>'+
            '<div style="padding:10px" class="col-sm-3"><div class="form-group"><small style="font-weight: bold; color:#67748e;">CANTIDAD<small></small></small><input name="cantidad" type="text" class="form-control" style="border: 1px solid #a5a9bf7a;"></div></div>'+
            '<div style="padding:10px" class="col-sm-1"><div class="form-group"><button style="margin-top: 20px; background:red;" class="btn btn-danger" id="DeleteRow" type="button"><i style="font-size: 22px; color:white;" class="ti-trash"></i></button></div></div></div></div>';

            $('#newinput').append(newRowAdd);
        });

        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })

    });


</script>
@endsection