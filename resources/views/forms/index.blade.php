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
                                        <h3 class="wizard-title">FAM-0002A</h3>
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
                                                        <i class="ti-user"></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">Datos</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#account" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-settings"></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">A1 - DATOS DE LA MISIÓN</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#dddd" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-map"></i>
                                                    </div>
                                                    <p style="font-size:11px; color: #707885">B1 - DATOS DE LA TRIPULACIÓN DE VUELO</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#address" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-map"></i>
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
                                                            <input name="date" type="date" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>2. OV / OTA / OM <small>(requerido)</small></h6>
                                                            <input name="lastname" type="text" class="form-control" placeholder="">
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
                                                            <select class="aeronaves form-control" name="aeronaves">
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
                                                            <select name="country" class="form-control">
                                                                <option >Seleccionar.. </option>
                                                                <option value="Afghanistan"> DF/002 </option>
                                                                <option value="Albania"> UIUD-33 </option>
                                                                <option value="Algeria"> 23CDW </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>5. MATRICULA <small></small></h6>
                                                            <select name="country" class="form-control">
                                                                <option>Seleccionar..</option>
                                                                @foreach($matriculas as $data) 
                                                                    <option value="{{$data->id}}">{{$data->matricula}}</option>
                                                                @endforeach
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
                                                            <select name="country" class="form-control">
                                                                <option>Seleccionar..</option>
                                                                @foreach($unidad as $data) 
                                                                    <option value="{{$data->id}}"><strong>{{$data->codigos}}</strong> - {{$data->unidad}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>8. BASE / ESTACION / PAIS / LUGAR<small></small></h6>
                                                            <input name="lastname" type="text" class="form-control" placeholder="">
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
                                            <h5 class="info-text"> What are you doing? (checkboxes) </h5>
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Design">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-paint-roller"></i>
                                                                <p>Design</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Code">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-pencil-alt"></i>
                                                                <p>Code</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Develop">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-star"></i>
                                                                <p>Develop</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="dddd">
                                            <h5 class="info-text"> What are you doing? (checkboxes) </h5>
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Design">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-paint-roller"></i>
                                                                <p>Design</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Code">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-pencil-alt"></i>
                                                                <p>Code</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="choice" data-toggle="wizard-checkbox">
                                                            <input type="checkbox" name="jobb" value="Develop">
                                                            <div class="card card-checkboxes card-hover-effect">
                                                                <i class="ti-star"></i>
                                                                <p>Develop</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="address">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5 class="info-text"> Are you living in a nice area? </h5>
                                                </div>
                                                <div class="col-sm-7 col-sm-offset-1">
                                                    <div class="form-group">
                                                        <label>Street Name</label>
                                                        <input type="text" class="form-control" placeholder="5h Avenue">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Street Number</label>
                                                        <input type="text" class="form-control" placeholder="242">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-1">
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" class="form-control" placeholder="New York...">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Country</label><br>
                                                        <select name="country" class="form-control">
                                                            <option value="Afghanistan"> Afghanistan </option>
                                                            <option value="Albania"> Albania </option>
                                                            <option value="Algeria"> Algeria </option>
                                                            <option value="American Samoa"> American Samoa </option>
                                                            <option value="Andorra"> Andorra </option>
                                                            <option value="Angola"> Angola </option>
                                                            <option value="Anguilla"> Anguilla </option>
                                                            <option value="Antarctica"> Antarctica </option>
                                                            <option value="...">...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Siguiente' />
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
    $(document).ready(function() {
        $('.aeronaves').select2();
    });
</script>
@endsection