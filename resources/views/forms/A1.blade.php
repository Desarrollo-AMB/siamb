<div class="row">
    <div style="padding-top:30px;">
        <div class="row">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">MISIÓN</h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">ORDENADA POR</small>
                        <select name="ordenada_por" class="form-control ordenada_por load_ordenado_por">
                            <option value=""></option>
                            @foreach($vueloOrdenadaPor as $data) 
                                <option value="{{$data->codigo}}">{{$data->autoridad_orden_vuelo}} - {{$data->codigo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">EN APOYO A</small>
                        <select name="en_apoyo" class="form-control en_apoyo load_en_apoyo">
                            <option value=""></option>
                            @foreach($enApoyo as $data) 
                                <option value="{{$data->codigo}}">{{$data->codigo}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">SIGLAS</small>
                        <select name="siglas" class="form-control siglas load_siglas">
                            <option value=""></option>
                            @foreach($codigoTipoMisionSiglas as $data) 
                                <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                            @endforeach
                        </select>  
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>
                        <select name="codigo" class="form-control codigo load_codigo">
                        <option value=""></option>
                            @foreach($codigoMision as $data) 
                                <option value="{{$data->codigo}}">{{$data->codigo}}</option>
                            @endforeach
                        </select>  
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">RUTA</h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">DESDE</small>
                        <select name="ruta_desde" class="form-control ruta_desde load_ruta_desde">
                            <option value=""></option>
                            @foreach($bases as $data) 
                                <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HASTA</small>
                        <select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta">
                            <option value=""></option>
                            @foreach($bases as $data) 
                                <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-1">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">HORA DE LA AERONAVE</h6> 
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">ENCEND</small>
                        <input name="encend" type="time" class="form-control encend load_encend calculateTime" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">DESPEG</small>
                        <input name="despeg" type="time" class="form-control despeg load_despeg calculateTime" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">ATERRIZ</small>
                        <input name="aterriz" type="time" class="form-control aterriz load_aterriz calculateTime" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">APAG</small>
                        <input name="apag" type="time" class="form-control apag load_apag calculateTime" style="text-transform: uppercase"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-1">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">TIEMPO DE VUELO</h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">REGISTRO MANUAL</small>
                        <input name="registro_manual" type="text" class="form-control registro_manual load_registro_manual pasar_calculo" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HOROMETRO A LA FECHA</small>
                        <input name="horometro" type="text" class="form-control horometro load_horometro" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">IND X CADA VUELO</small>
                        <input name="ind_vuelo" type="text" class="form-control ind_vuelo load_ind_vuelo" style="text-transform: uppercase"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-1">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">ATERRIZAJES</h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TOQUE Y DESP</small>
                        <input name="toque_desp" type="number" class="form-control toque_desp load_toque_desp"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">LOW GO</small>
                        <input name="low_go" type="number" class="form-control low_go load_low_go"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <small style="font-weight: bold; color:#67748e;">CICLOS TREN</small>
                    <input name="ciclos_tren" type="number" class="form-control ciclos_tren load_ciclos_tren"> 
                </div>
                {{-- <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TOTAL</small>
                        <input name="total" type="number" class="form-control total load_total"> 
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="row">
            <div style="padding-top: 18px" class="col-sm-12">
                <h6 style="font-size:13px; margin: 0;">A2 DATOS DE MISION</h6> 
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div style="margin-bottom: 0;" class="form-group">
                        <small style="font-weight: bold; color:#67748e;">EN APOYO A - NOMBRE ESPECÍFICO ENTE/PERSONA</small>
                        <select name="en_apoyo_A2" class="form-control en_apoyo_A2 load_en_apoyo_A2">
                            <option value=""></option>
                            @foreach($enApoyo as $data) 
                                <option value="{{$data->nombre_apoyo}}">{{$data->nombre_apoyo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style="margin-bottom: 0;" class="form-group">
                        <small style="font-weight: bold; color:#67748e;">DESCRIPCIÓN</small>
                        <input name="descripcion_A2" type="text" class="form-control descripcion_A2 load_descripcion_A2" style="text-transform: uppercase"> 
                    </div>
                </div>
            </div>
        </div>
        <input hidden="true" name="id_mision" type="text" class="form-control id_mision load_id_mision"> 
        <div style="padding: 10px;" class="row">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;"> REGISTRAR CONSUMIBLES</h6><input style="color:white; background:#38496a;" type='button' id="rowAdder" class='btn btn-info' value="AGREGAR"/>
            </div>
            {{-- <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase font-weight-bolder"><h6>N°</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>Consumible</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>Unidad</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>Cantidad</h6></th>
                    </tr>
                </thead>
                <tbody id="consumblesEdit">

                </tbody>
            </table> --}}
            <div id="newinput" class="col-12"></div>
            <hr>
        </div>
        <div style="padding-top:5px" class="row">
            <button style="background: green;color: white;" type="button" class="btn btn-success enviar_a1_mision add_edit_input">Agregar vuelo</button>
            <button hidden="true" style="background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success edit_input actualizar_a1_mision">ACTUALIZAR</button>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-sm-4">
            <h6 style="font-size:13px; margin: 0;"> LISTA DE MISIONES</h6> 
        </div>
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead style="background: #e1e1e0;">
                    <tr>
                        <th class="text-uppercase font-weight-bolder"><h6>N°</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>ORDENADO</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>EN APOYO</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>DESDE</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>HASTA</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>ACCIONES</h6></th>
                    </tr>
                </thead>
                <tbody id="A1_data">

                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>