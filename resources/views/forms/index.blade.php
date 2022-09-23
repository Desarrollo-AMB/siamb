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
                                        <p class="category">Generar Ordenes de Vuelo.</p>
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
                                                    <p style="font-size:11px; color: #707885">Datos</p>
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
                                                            <h6>1. FECHA <small></small></h6>
                                                            <input name="date" type="date" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>2. OV / OTA / OM <small></small></h6>
                                                            <input type="text" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>3. AERONAVE / MODELO</h6>
                                                            {{-- <select name="country" class="form-control">
                                                                <option>Seleccionar..</option>
                                                                @foreach($aeronaveModelos as $naves) 
                                                                    <option value="{{$naves->id}}">{{$naves->aeronave}} / {{$naves->modelo}}</option>
                                                                @endforeach
                                                            </select> --}}
                                                            {{-- <select class="aeronaves form-control" name="aeronaves">
                                                                @foreach($aeronaveModelos as $naves) 
                                                                    <option value="{{$naves->id}}">{{$naves->aeronave}} / {{$naves->modelo}}</option>
                                                                @endforeach
                                                            </select> --}}

                                                            <select class="selectpicker form-control" id="naves" name="selectpicker">
                                                                <option>Seleccionar..</option>
                                                                @foreach($aeronaveModelos as $naves) 
                                                                    <option value="{{$naves->id}}">{{$naves->aeronave}} / {{$naves->modelo}}</option>
                                                                @endforeach
                                                            </select>
                                                              
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>4. SERIAL</h6>
                                                            <select name="country" id="serial" class="form-control">
                                                                <option>Seleccionar..</option>
                                                                @foreach($matriculas as $data) 
                                                                    @if ($data->serial==null)
                                                                    @else
                                                                    <option value="{{$data->id}}">{{$data->serial}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>5. MATRICULA <small></small></h6>
                                                            <select name="country" id="matricula" class="form-control">
                                                                {{-- <option>Seleccionar..</option>
                                                                @foreach($matriculas as $data) 
                                                                    <option value="{{$data->id}}">{{$data->matricula}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>6. COMPONENTE / ORGANISMO <small></small></h6>
                                                            <select name="country" class="form-control">
                                                                <option>Seleccionar..</option>
                                                                @foreach($componentes as $data) 
                                                                    <option value="{{$data->id}}">{{$data->componente}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>7. UNIDAD<small></small></h6>
                                                            <select name="country" class="form-control" id="grupos_unidades">
                                                                {{-- <option>Seleccionar..</option>
                                                                @foreach($unidad as $data) 
                                                                    <option value="{{$data->id}}"><strong>{{$data->codigos}}</strong> - {{$data->unidad}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>8. BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                                            <select name="country" class="form-control">
                                                                <option>Seleccionar..</option>
                                                                @foreach($bases as $data) 
                                                                    <option value="{{$data->id}}">{{$data->siglas}} - {{$data->descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-sm-offset-1">
                                                        <div class="form-group">
                                                            <h6>9. JEFE DE MAQUINA EN LINEA DE VUELO <small></small></h6>
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
                                            <h5 class="info-text">paso dos</h5>
                                            {{-- <div class="form-group">
                                                <label for="country">Country:</label>
                                                <select name="country" id="country" class="form-control">
                                                    @foreach($aeronaveModelos as $naves) 
                                                        <option value="{{$naves->id}}">{{$naves->aeronave}} / {{$naves->modelo}}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
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
        $("#naves").change(function(){
            var id = $(this).val();
            if(id){
                $.ajax({
                    type:'GET',
                    url:'{{ route("matriculas") }}',
                    data:{"id" : id },
                    success:function(res){
                        $("#matricula").empty();
                        $("#matricula").append('<option>Seleccionar..</option>');
                        $.each(res,function(key,value){
                            $("#matricula").append('<option value="'+value.id+'">'+value.matricula+'</option>');
                        });
                    }
                }); 
                $.ajax({
                    type:'GET',
                    url:'{{ route("grupos_unidades") }}',
                    data:{"id" : id },
                    success:function(res){
                        console.log(res);
                        $("#grupos_unidades").empty();
                        $("#grupos_unidades").append('<option>Seleccionar..</option>');
                        $.each(res,function(key,value){
                            $("#grupos_unidades").append('<option value="'+value.id+'">'+value.unidad+'</option>');
                        });
                    }
                }); 
            }
        });
    });


</script>
@endsection