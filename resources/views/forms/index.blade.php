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
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="orange" id="wizardProfile">
                                <form action="" method="">
                                    <div class="wizard-header text-center">
                                        <h3 class="wizard-title">FAM-0002</h3>
                                        <p class="category">Generar Nueva FAM-0002.</p>
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
                                                <a href="#account" data-toggle="tab">
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
                                                <br>
                                                <div style="padding-top: 30px;" class="col-sm-12">
                                                    <h5 style="float: left" class="info-text">FAM-0002A</h5>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>FECHA <small></small></h6>
                                                            <input name="date" type="date" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>OV / OTA / OM <small></small></h6>
                                                            <input style="text-transform: uppercase" type="text" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>COMPONENTE / ORGANISMO <small></small></h6>
                                                            <select name="country" class="form-control">
                                                                <option>Seleccionar..</option>
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
                                                            <select name="grupos" class="form-control" id="grupos">
                                                                <option>Seleccionar..</option>
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

                                                            <select class="selectpicker form-control" id="naves" name="naves">
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
                                                            <select name="serial" id="serial" class="form-control">
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
                                                            <select name="matricula" id="matricula" class="form-control">
                                                            {{-- <option>Seleccionar..</option>
                                                                @foreach($matriculas as $data) 
                                                                    <option value="{{$data->id}}">{{$data->matricula}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                                            <select name="country" class="form-control">
                                                                <option>Seleccionar..</option>
                                                                @foreach($bases as $data) 
                                                                    <option value="{{$data->id}}">{{$data->descripcion}} - {{$data->siglas}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-sm-offset-1">
                                                        <div class="form-group">
                                                            <h6>JEFE DE MAQUINA EN LINEA DE VUELO <small></small></h6>
                                                            <input name="text" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-sm-3 col-sm-offset-1">
                                                        <div class="form-group">
                                                            <h6>CEDULA<small></small></h6>
                                                            <input name="text" type="text" class="form-control">
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="account">
                                            <h5 class="info-text">A1 - DATOS DE LA MISIÓN</h5>
                                            @include('forms.A1')
                                        </div>
                                        <div class="tab-pane" id="dddd">
                                            <h5 class="info-text">paso tres</h5>
                                            
                                        </div>
                                        <div class="tab-pane" id="address">
                                           
                                        </div>
                                    </div>
                                    <br>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input style="background: linear-gradient(310deg,#506793,#273244);" type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Siguiente' />
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
                            $("#naves").append('<option value="'+value.id+'">'+value.aeronave+'-'+value.modelo+'</option>');
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
                                $("#serial").append('<option value="'+key.serial+'">'+value.serial+'</option>');
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
                                $("#matricula").append('<option value="'+key.matricula+'">'+value.matricula+'</option>');
                            });
                        }
                    }
                });
            }
        });
    });


</script>
@endsection