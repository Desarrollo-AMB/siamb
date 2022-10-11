<div class="row">
    <div class="pt-4">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">V-TRIP<h6>
                    <select name="v_trip" class="form-control v_trip load_v_trip">
                        <option value=""></option>
                        @foreach($A1_mision as $data) 
                            <option value="{{$data->id}}">{{$data->ordenada_por}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">FUNCIÓN<h6>
                    <select name="funcion" class="form-control funcion load_funcion">
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
            </div>
        </div>
    </div>
    <div class="row pb-1">
        <div class="col-sm-6">
            <h6 style="font-size:13px; margin: 0;">OPERACIONES EN VUELO Y/O ENTRENAMIENTO</h6>
            <input style="color:white; background:#38496a;" type='button' id="OV_ADD" class='btn btn-info' value="AGREGAR"/>
        </div>
        <div class="row">
            <div id="nuevaOperacionVuelo" class="col-12"></div>
            <div class="col-sm-3">
                <div class="form-group">
                    <h6 style="font-weight: bold; color:#67748e;">TOTAL HV<h6>
                    <input name="TOTAL_HV" type="number" class="form-control TOTAL_HV load_TOTAL_HV" style="text-transform: uppercase"> 
                </div>
            </div>
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
                            <option value="{{$data->id}}">{{$data->tipo_despegue}}</option>
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
</div>