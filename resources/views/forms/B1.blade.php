<div class="row">
    <div class="pt-4">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">V-TRIP<h6>
                    <select id="v_trip" name="v_trip" class="form-control v_trip load_v_trip">
                        <option value=""></option>
                        {{-- @foreach($A1_mision as $data) 
                            <option value="{{$data->id}}">V{{$data->vuelo}}</option>
                        @endforeach --}}
                    </select>
                    <input hidden="true" name="v_mision" type="text" class="form-control v_mision load_v_mision"> 
                </div>
            </div>
            <div style="padding-top: 30px;" class="col-sm-6">
                <div class="row" id="v_data" hidden="true">
                    <div class="col-4">
                        <div class="form-group">
                            <h6 style="color: #212529;">DESDE: <span style="color: #67748e;" class="load_vuelo_desde"> </span></h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <h6 style="color: #212529;">HASTA: <span style="color: #67748e;" class="load_vuelo_hasta"> </span></h6>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">FUNCIÓN<h6>
                    <select id="funcion" name="funcion" class="form-control funcion load_funcion">
                        <option value=""></option>
                        @foreach($funcion as $data) 
                            <option value="{{$data->id}}">{{$data->codigo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">GRADO NOMBRE Y APELLIDO<h6>
                    <select name="grado_nombre" class="form-control grado_nombre load_grado_nombre">
                        <option value=""></option>
                    </select>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="pt-1">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">FUNCIÓN<h6>
                    <select id="funcion" name="funcion" class="form-control funcion load_funcion">
                        <option value=""></option>
                        @foreach($funcion as $data) 
                            <option value="{{$data->id}}">{{$data->codigo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">GRADO NOMBRE Y APELLIDO<h6>
                    <select id="empleado_vuelo" name="grado_nombre" class="form-control grado_nombre load_grado_nombre">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div style="padding-top: 30px;" class="col-sm-4">
                <div class="form-group">
                    <h6 style="color: #212529;">CEDULA: <span style="color: #67748e; font-size: 14px;" class="load_cedula_empleado"> </span></h6>
                    <input hidden="true" name="cedula_empleado" type="text" class="form-control cedula_empleado"> 
                </div>
            </div>
        </div>
    </div>
    
    <div class="row pb-1">
        <div class="col-sm-6">
            <h6 style="font-size:13px; margin: 0;">OPERACIONES EN VUELO Y/O ENTRENAMIENTO</h6>
            <input style="color:white; background:#38496a;" type='button' id="OV_ADD" class='btn btn-info' value="AGREGAR"/>
            <h6 style="color: #212529;font-size: 14px;">COD: <span style="color: #67748e;" class="load_codigo_tripulacion"> </span></h6>
            <input hidden="true" name="codigo_trip" type="text" class="form-control codigo_trip">
        </div>
        {{-- <div class="col-4">
            <div class="form-group">
                <h6 style="color: #212529;">COD: <span style="color: #67748e;" class="load_codigo_tripulacion"> </span></h6>
            </div>
        </div> --}}
        <div class="row">
            <div id="nuevaOperacionVuelo" class="col-12"></div>
            {{-- <div style="padding-left: 20px;" class="col-sm-3">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">TOTAL HV<h6>
                    <input name="TOTAL_HV" type="number" class="form-control TOTAL_HV load_TOTAL_HV" style="text-transform: uppercase"> 
                </div>
            </div> --}}
        </div> 
    </div>
    <div class="row pb-1">
        <div class="col-sm-6">
            <h6 style="font-size:13px; margin: 0;">DESPEGUE</h6>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <small style="font-weight: bold; color:#67748e;">TIPO<small></small></small>
                    <select name="tipo_despegue" class="form-control tipo_despegue load_tipo_despegue">
                        <option value=""></option>
                        @foreach($despegue as $data) 
                            <option value="{{$data->codigo}}">{{$data->codigo}} - {{$data->tipo_despegue}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> 
    </div>
    <div class="row pb-1">
        <div class="col-sm-6">
            <h6 style="font-size:13px; margin: 0;">ATERRIZAJES</h6>
            <input style="color:white; background:#38496a;" type='button' id="ATR_ADD" class='btn btn-info' value="AGREGAR"/>
        </div>
        <div class="row">
            <div id="nuevoAterrizaje" class="col-12"></div>
            {{-- <div class="col-sm-6">
                <div class="form-group">
                    <small style="font-weight: bold; color:#67748e;">TIPO<small></small></small>
                    <select name="tipo_aterrizaje" class="form-control tipo_aterrizaje load_tipo_aterrizaje">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <small style="font-weight: bold; color:#67748e;">CANT<small></small></small>
                    <input name="tipo_cantidad" type="number" class="form-control tipo_cantidad load_tipo_cantidad" style="text-transform: uppercase"> 
                </div>
            </div> --}}
        </div> 
    </div>
    <div style="padding-top:5px" class="row">
        <button style="background: green;color: white;" type="button" class="btn btn-success enviar_b1_tripulacion add_edit_b1_input">Agregar tripulacion</button>
        {{-- <button hidden="true" style="background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success edit_input actualizar_b1_mision">ACTUALIZAR</button> --}}
    </div>
    <div class="row pt-3">
        <div class="col-sm-4">
            <h6 style="font-size:13px; margin: 0;"> LISTA DATOS DE LA TRIPULACUIÓN DE VUELO<small></small></h6> 
        </div>
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead style="background: #e1e1e0;">
                    <tr>
                        {{-- <th class="text-uppercase font-weight-bolder"><h6>N°</h6></th> --}}
                        <th class="text-uppercase font-weight-bolder"><h6>V-TRIP</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>GRADO NOMBRE Y APELLIDO</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>CEDULA</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>FUNCION</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>TOTAL HV</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>ACCIONES</h6></th>
                    </tr>
                </thead>
                <tbody id="B1_data">

                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>