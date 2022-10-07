<div class="row">
    <div style="padding-top:30px;">
        <div class="row">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">MISIÓN<small></small></h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">ORDENADA POR<small></small></small>
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
                        <small style="font-weight: bold; color:#67748e;">EN APOYO A<small></small></small>
                        <select name="en_apoyo" class="form-control en_apoyo load_en_apoyo">
                            <option value=""></option>
                            @foreach($enApoyo as $data) 
                                <option value="{{$data->codigo}}">{{$data->nombre_apoyo}} - {{$data->codigo}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CÓDIGO<small></small></small>
                        {{-- <input name="codigo" style="text-transform: uppercase" type="text" class="form-control codigo"> --}}
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
                <h6 style="font-size:13px; margin: 0;">RUTA<small></small></h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">DESDE<small></small></small>
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
                        <small style="font-weight: bold; color:#67748e;">HASTA<small></small></small>
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
        <div class="row">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">HORA DE LA AERONAVE<small></small></h6> 
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">ENCEND<small></small></small>
                        <input name="encend" type="time" class="form-control encend load_encend" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">DESPEG<small></small></small>
                        <input name="despeg" type="time" class="form-control despeg load_despeg" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">ATERRIZ<small></small></small>
                        <input name="aterriz" type="time" class="form-control aterriz load_aterriz" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">APAG<small></small></small>
                        <input name="apag" type="time" class="form-control apag load_apag" style="text-transform: uppercase"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">TIEMPO DE VUELO<small></small></h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">REGISTRO MANUAL<small></small></small>
                        <input name="registro_manual" type="text" class="form-control registro_manual load_registro_manual" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HOROMETRO A LA FECHA<small></small></small>
                        <input name="horometro" type="text" class="form-control horometro load_horometro" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">IND X CADA VUELO<small></small></small>
                        <input name="ind_vuelo" type="text" class="form-control ind_vuelo load_ind_vuelo" style="text-transform: uppercase"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h6 style="font-size:13px; margin: 0;">ATERRIZAJES<small></small></h6> 
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TOQUE Y DESP<small></small></small>
                        <input name="toque_desp" type="number" class="form-control toque_desp load_toque_desp"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">LOW GO<small></small></small>
                        <input name="low_go" type="number" class="form-control low_go load_low_go"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TOTAL<small></small></small>
                        <input name="total" type="number" class="form-control total load_total"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h6 style="font-size:13px; margin: 0;">CICLOS TREN<small></small></h6> 
                <input name="ciclos_tren" type="number" class="form-control ciclos_tren load_ciclos_tren"> 
            </div>
            <div class="col-sm-4">
                <h6 style="font-size:13px; margin: 0;">CONSUMIBLES<small></small></h6> 
                <input style="color:white; background:#38496a;" type='button' id="rowAdder" class='btn btn-info' value="AGREGAR"/>
            </div>
        </div>
        <input hidden="true" name="id_mision" type="text" class="form-control id_mision load_id_mision"> 
        <div style="padding-top: 13px;" class="row">
            <div class="col-sm-4">
                <h6 style="font-size:13px; margin: 0;"> REGISTRAR CONSUMIBLES<small></small></h6> 
            </div>
            <table class="table align-items-center mb-0">
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
            </table>
            <div id="newinput" class="col-12"></div>
        </div>
        <div style="padding-top:20px" class="row">
            <hr>
            <button style="background: green;color: white;" type="button" class="btn btn-success enviar_a1_mision add_edit_input">Agregar vuelo</button>
            <button hidden="true" style="background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success edit_input actualizar_a1_mision">ACTUALIZAR</button>
       
        </div>
    </div>
    <div class="row p-t-5">
        <div class="col-sm-4">
            <h6 style="font-size:13px; margin: 0;"> LISTA DE MISIONES<small></small></h6> 
        </div>
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
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