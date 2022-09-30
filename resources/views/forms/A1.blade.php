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
                        <select name="ordenada_por" class="form-control ordenada_por">
                            <option value=""></option>
                            @foreach($vueloOrdenadaPor as $data) 
                                <option value="{{$data->id}}">{{$data->autoridad_orden_vuelo}} - {{$data->codigo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">EN APOYO A<small></small></small>
                        <select name="en_apoyo" class="form-control en_apoyo">
                            <option value=""></option>
                            @foreach($enApoyo as $data) 
                                <option value="{{$data->id}}">{{$data->nombre_apoyo}} - {{$data->codigo}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CÓDIGO<small></small></small>
                        <input name="codigo" style="text-transform: uppercase" type="text" class="form-control codigo"> 
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
                        <select name="ruta_desde" class="form-control ruta_desde">
                            <option value=""></option>
                            @foreach($bases as $data) 
                                <option value="{{$data->id}}">{{$data->descripcion}} - {{$data->siglas}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HASTA<small></small></small>
                        <select name="ruta_hasta" class="form-control ruta_hasta">
                            <option value=""></option>
                            @foreach($bases as $data) 
                                <option value="{{$data->id}}">{{$data->descripcion}} - {{$data->siglas}}</option>
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
                        <input name="encend" type="text" class="form-control encend" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">DESPEG<small></small></small>
                        <input name="despeg" type="text" class="form-control despeg" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">ATERRIZ<small></small></small>
                        <input name="aterriz" type="text" class="form-control aterriz" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">APAG<small></small></small>
                        <input name="apag" type="text" class="form-control apag" style="text-transform: uppercase"> 
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
                        <input name="registro_manual" type="text" class="form-control registro_manual" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HOROMETRO A LA FECHA<small></small></small>
                        <input name="horometro" type="text" class="form-control horometro" style="text-transform: uppercase"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">IND X CADA VUELO<small></small></small>
                        <input name="ind_vuelo" type="text" class="form-control ind_vuelo" style="text-transform: uppercase"> 
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
                        <input name="toque_desp" type="number" class="form-control toque_desp"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">LOW GO<small></small></small>
                        <input name="low_go" type="number" class="form-control low_go"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TOTAL<small></small></small>
                        <input name="total" type="number" class="form-control total"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <h6 style="font-size:13px; margin: 0;">CICLOS TREN<small></small></h6> 
                <input name="ciclos_tren" type="number" class="form-control ciclos_tren"> 
            </div>
            <div class="col-sm-4">
                <h6 style="font-size:13px; margin: 0;">CONSUMIBLES<small></small></h6> 
                <input style="color:white; background:#38496a;" type='button' id="rowAdder" class='btn btn-info' value="AGREGAR"/>
            </div>
        </div>
        
        <div style="padding-top: 13px;" class="row">
            <div class="col-sm-4">
                <h6 style="font-size:13px; margin: 0;"> REGISTRAR CONSUMIBLES<small></small></h6> 
            </div>
            {{-- <div class="row">   
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CONSUMIBLES<small></small></small>
                        <input name="fecha" type="text" class="form-control fecha load_fecha"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">UNIDADES<small></small></small>
                        <input name="fecha" type="text" class="form-control fecha load_fecha"> 
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CANTIDAD<small></small></small>
                        <input name="fecha" type="text" class="form-control fecha load_fecha"> 
                    </div>
                </div>
            </div> --}}
            <div id="newinput" class="col-12"></div>
        </div>
        <div style="padding-top:20px" class="row">
            <hr>
            <button style="background: green;color: white;" type="button" class="btn btn-success enviar_a1_mision">Agregar vuelo</button>
        </div>
    </div>
    <div class="row p-t-5">
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
                        <th class="text-uppercase font-weight-bolder">ACCIONES</th>
                    </tr>
                </thead>
                <tbody id="A1_data">

                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>