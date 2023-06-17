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
                        <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>
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
                                <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>
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
                <div class="col-sm-6">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">DESDE</small>
                        <select name="ruta_desde" class="form-control ruta_desde load_ruta_desde">
                            <option value=""></option>
                            <option value="LOCAL">LOCAL</option>
                                @foreach($aeropuertos as $data)
                                    {{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}
                                    <option title="{{$data->nombre}}" value="{{$data->codigo_icao}}">{{$data->codigo_icao}}</option>
                                @endforeach
                                    <option value="">_______PARROQUIA__________</option>
                                @foreach ($parroquias as $data)
                                    <option value="{{ mb_strtoupper($data->parroquia) }}">{{ mb_strtoupper($data->parroquia) }}
                                    </option>
                                @endforeach
                                    <option value="">_______BASE__________</option>
                                @foreach ($bases as $data)
                                    <option value="{{ $data->descripcion }}">{{ $data->descripcion }} -
                                    ({{ $data->siglas }})</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HASTA</small>
                        <select name="ruta_hasta" class="form-control ruta_hasta load_ruta_hasta">
                            <option value=""></option>
                            <option value="LOCAL">LOCAL</option>
                                @foreach($aeropuertos as $data)
                                    {{-- <option value="{{$data->siglas}}">{{$data->descripcion}} - {{$data->siglas}}</option> --}}
                                    <option title="{{$data->nombre}}" value="{{$data->codigo_icao}}">{{$data->codigo_icao}}</option>
                                @endforeach
                                    <option value="">_______PARROQUIA__________</option>
                                @foreach ($parroquias as $data)
                                    <option value="{{ mb_strtoupper($data->parroquia) }}">{{ mb_strtoupper($data->parroquia) }}
                                    </option>
                                @endforeach
                                    <option value="">_______BASE__________</option>
                                @foreach ($bases as $data)
                                    <option value="{{ $data->descripcion }}">{{ $data->descripcion }} -
                                    ({{ $data->siglas }})</option>
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
                        <input readonly="true" name="registro_manual" type="text" class="form-control registro_manual load_registro_manual pasar_calculo blackInReadOnly" style="text-transform: uppercase">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HOROMETRO A LA FECHA</small>
                        <input name="horometro" type="number" class="form-control horometro load_horometro" {{--style="text-transform: uppercase"--}}>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">IND X CADA VUELO</small>
                        <input name="ind_vuelo" type="number" class="form-control ind_vuelo load_ind_vuelo" {{--style="text-transform: uppercase"--}}>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pb-1">
            <div class="row">
                <small style="font-weight: bold; color:#67748e;">COD-1</small>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>
                        <select id="siglas1" name="siglas1" class="form-control siglas">
                            <option value=""></option>
                            @foreach($codigoTipoMisionSiglas as $data)
                                <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>
                        <select id="codigo1" name="codigo1" class="form-control codigo">
                        <option value=""></option>
                            @foreach($codigoMision as $data)
                                <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>
                        <select id="condicion1" name="condicion1" class="form-control condicion select2">
                            <option value=""></option>
                            <option value="DCV">DCV</option>
                            <option value="DCI">DCI</option>
                            <option value="DWV">DWV</option>
                            <option value="DWI">DWI</option>
                            <option value="NCV">NCV</option>
                            <option value="NCI">NCI</option>
                            <option value="NWV">NWV</option>
                            <option value="NWI">NWI</option>
                            <option value="DCVG">DCVG</option>
                            <option value="DCIG">DCIG</option>
                            <option value="DWVG">DWVG</option>
                            <option value="DWIG">DWIG</option>
                            <option value="NCVG">NCVG</option>
                            <option value="NCIG">NCIG</option>
                            <option value="NWVG">NWVG</option>
                            <option value="NWIG">NWIG</option>
                            <option value="DCVF">DCVF</option>
                            <option value="DCIF">DCIF</option>
                            <option value="DWVF">DWVF</option>
                            <option value="DWIF">DWIF</option>
                            <option value="NCVF">NCVF</option>
                            <option value="NCIF">NCIF</option>
                            <option value="NWVF">NWVF</option>
                            <option value="NWIF">NWIF</option>
                            <option value="DCVA">DCVA</option>
                            <option value="DCIA">DCIA</option>
                            <option value="DWVA">DWVA</option>
                            <option value="DWIA">DWIA</option>
                            <option value="NCVA">NCVA</option>
                            <option value="NCIA">NCIA</option>
                            <option value="NWVA">NWVA</option>
                            <option value="NWIA">NWIA</option>
                            <option value="DCVL">DCVL</option>
                            <option value="DCIL">DCIL</option>
                            <option value="DWVL">DWVL</option>
                            <option value="DWIL">DWIL</option>
                            <option value="NCVL">NCVL</option>
                            <option value="NCIL">NCIL</option>
                            <option value="NWVL">NWVL</option>
                            <option value="NWIL">NWIL</option>
                            <option value="DCVH">DCVH</option>
                            <option value="DCIH">DCIH</option>
                            <option value="DWVH">DWVH</option>
                            <option value="DWIH">DWIH</option>
                            <option value="NCVH">NCVH</option>
                            <option value="NCIH">NCIH</option>
                            <option value="NWVH">NWVH</option>
                            <option value="NWIH">NWIH</option>
                            <option value="DCVS">DCVS</option>
                            <option value="DCIS">DCIS</option>
                            <option value="DWVS">DWVS</option>
                            <option value="DWIS">DWIS</option>
                            <option value="NCVS">NCVS</option>
                            <option value="NCIS">NCIS</option>
                            <option value="NWVS">NWVS</option>
                            <option value="NWIS">NWIS</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HV-1</small>
                        <input id="hv1" name="hv1" type="number" class="form-control hv blackInReadOnly hv1" style="text-transform: uppercase" step="0.1" pattern="\d+(\.\d{1})?" title="Ingrese solo números con un decimal" value="0.0">
                    </div>
                </div>
            </div>
        {{--<div class="row">
                <small style="font-weight: bold; color:#67748e;">COD-2</small>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>
                        <select id="siglas2" name="siglas2" class="form-control siglas">
                            <option value=""></option>
                            @foreach($codigoTipoMisionSiglas as $data)
                                <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>
                        <select id="codigo2" name="codigo2" class="form-control codigo">
                        <option value=""></option>
                            @foreach($codigoMision as $data)
                                <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>
                        <select id="condicion2" name="condicion2" class="form-control condicion select2">
                            <option value=""></option>
                            <option value="DCV">DCV</option>
                            <option value="DCI">DCI</option>
                            <option value="DWV">DWV</option>
                            <option value="DWI">DWI</option>
                            <option value="NCV">NCV</option>
                            <option value="NCI">NCI</option>
                            <option value="NWV">NWV</option>
                            <option value="NWI">NWI</option>
                            <option value="DCVG">DCVG</option>
                            <option value="DCIG">DCIG</option>
                            <option value="DWVG">DWVG</option>
                            <option value="DWIG">DWIG</option>
                            <option value="NCVG">NCVG</option>
                            <option value="NCIG">NCIG</option>
                            <option value="NWVG">NWVG</option>
                            <option value="NWIG">NWIG</option>
                            <option value="DCVF">DCVF</option>
                            <option value="DCIF">DCIF</option>
                            <option value="DWVF">DWVF</option>
                            <option value="DWIF">DWIF</option>
                            <option value="NCVF">NCVF</option>
                            <option value="NCIF">NCIF</option>
                            <option value="NWVF">NWVF</option>
                            <option value="NWIF">NWIF</option>
                            <option value="DCVA">DCVA</option>
                            <option value="DCIA">DCIA</option>
                            <option value="DWVA">DWVA</option>
                            <option value="DWIA">DWIA</option>
                            <option value="NCVA">NCVA</option>
                            <option value="NCIA">NCIA</option>
                            <option value="NWVA">NWVA</option>
                            <option value="NWIA">NWIA</option>
                            <option value="DCVL">DCVL</option>
                            <option value="DCIL">DCIL</option>
                            <option value="DWVL">DWVL</option>
                            <option value="DWIL">DWIL</option>
                            <option value="NCVL">NCVL</option>
                            <option value="NCIL">NCIL</option>
                            <option value="NWVL">NWVL</option>
                            <option value="NWIL">NWIL</option>
                            <option value="DCVH">DCVH</option>
                            <option value="DCIH">DCIH</option>
                            <option value="DWVH">DWVH</option>
                            <option value="DWIH">DWIH</option>
                            <option value="NCVH">NCVH</option>
                            <option value="NCIH">NCIH</option>
                            <option value="NWVH">NWVH</option>
                            <option value="NWIH">NWIH</option>
                            <option value="DCVS">DCVS</option>
                            <option value="DCIS">DCIS</option>
                            <option value="DWVS">DWVS</option>
                            <option value="DWIS">DWIS</option>
                            <option value="NCVS">NCVS</option>
                            <option value="NCIS">NCIS</option>
                            <option value="NWVS">NWVS</option>
                            <option value="NWIS">NWIS</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HV-2</small>
                        <input id="hv2" name="hv2" type="number" class="form-control hv blackInReadOnly" style="text-transform: uppercase" value="0.0">
                    </div>
                </div>
            </div>
            <div class="row">
                <small style="font-weight: bold; color:#67748e;">COD-3</small>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>
                        <select id="siglas3" name="siglas3" class="form-control siglas">
                            <option value=""></option>
                            @foreach($codigoTipoMisionSiglas as $data)
                                <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>
                        <select id="codigo3" name="codigo3" class="form-control codigo">
                        <option value=""></option>
                            @foreach($codigoMision as $data)
                                <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>
                        <select id="condicion3" name="condicion3" class="form-control condicion select2">
                            <option value=""></option>
                            <option value="DCV">DCV</option>
                            <option value="DCI">DCI</option>
                            <option value="DWV">DWV</option>
                            <option value="DWI">DWI</option>
                            <option value="NCV">NCV</option>
                            <option value="NCI">NCI</option>
                            <option value="NWV">NWV</option>
                            <option value="NWI">NWI</option>
                            <option value="DCVG">DCVG</option>
                            <option value="DCIG">DCIG</option>
                            <option value="DWVG">DWVG</option>
                            <option value="DWIG">DWIG</option>
                            <option value="NCVG">NCVG</option>
                            <option value="NCIG">NCIG</option>
                            <option value="NWVG">NWVG</option>
                            <option value="NWIG">NWIG</option>
                            <option value="DCVF">DCVF</option>
                            <option value="DCIF">DCIF</option>
                            <option value="DWVF">DWVF</option>
                            <option value="DWIF">DWIF</option>
                            <option value="NCVF">NCVF</option>
                            <option value="NCIF">NCIF</option>
                            <option value="NWVF">NWVF</option>
                            <option value="NWIF">NWIF</option>
                            <option value="DCVA">DCVA</option>
                            <option value="DCIA">DCIA</option>
                            <option value="DWVA">DWVA</option>
                            <option value="DWIA">DWIA</option>
                            <option value="NCVA">NCVA</option>
                            <option value="NCIA">NCIA</option>
                            <option value="NWVA">NWVA</option>
                            <option value="NWIA">NWIA</option>
                            <option value="DCVL">DCVL</option>
                            <option value="DCIL">DCIL</option>
                            <option value="DWVL">DWVL</option>
                            <option value="DWIL">DWIL</option>
                            <option value="NCVL">NCVL</option>
                            <option value="NCIL">NCIL</option>
                            <option value="NWVL">NWVL</option>
                            <option value="NWIL">NWIL</option>
                            <option value="DCVH">DCVH</option>
                            <option value="DCIH">DCIH</option>
                            <option value="DWVH">DWVH</option>
                            <option value="DWIH">DWIH</option>
                            <option value="NCVH">NCVH</option>
                            <option value="NCIH">NCIH</option>
                            <option value="NWVH">NWVH</option>
                            <option value="NWIH">NWIH</option>
                            <option value="DCVS">DCVS</option>
                            <option value="DCIS">DCIS</option>
                            <option value="DWVS">DWVS</option>
                            <option value="DWIS">DWIS</option>
                            <option value="NCVS">NCVS</option>
                            <option value="NCIS">NCIS</option>
                            <option value="NWVS">NWVS</option>
                            <option value="NWIS">NWIS</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HV-3</small>
                        <input id="hv3" name="hv3" type="number" class="form-control hv blackInReadOnly" style="text-transform: uppercase" value="0.0">
                    </div>
                </div>
            </div>
            <div class="row">
                <small style="font-weight: bold; color:#67748e;">COD-4</small>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">TIPO MISIÓN</small>
                        <select id="siglas4" name="siglas4" class="form-control siglas">
                            <option value=""></option>
                            @foreach($codigoTipoMisionSiglas as $data)
                                <option value="{{$data->siglas}}">{{$data->siglas}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CÓDIGO</small>
                        <select id="codigo4" name="codigo4" class="form-control codigo">
                        <option value=""></option>
                            @foreach($codigoMision as $data)
                                <option title="{{$data->nombre}}" value="{{$data->codigo}}">{{$data->codigo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">CONDICIÓN VUELO</small>
                        <select id="condicion4" name="condicion4" class="form-control condicion select2">
                            <option value=""></option>
                            <option value="DCV">DCV</option>
                            <option value="DCI">DCI</option>
                            <option value="DWV">DWV</option>
                            <option value="DWI">DWI</option>
                            <option value="NCV">NCV</option>
                            <option value="NCI">NCI</option>
                            <option value="NWV">NWV</option>
                            <option value="NWI">NWI</option>
                            <option value="DCVG">DCVG</option>
                            <option value="DCIG">DCIG</option>
                            <option value="DWVG">DWVG</option>
                            <option value="DWIG">DWIG</option>
                            <option value="NCVG">NCVG</option>
                            <option value="NCIG">NCIG</option>
                            <option value="NWVG">NWVG</option>
                            <option value="NWIG">NWIG</option>
                            <option value="DCVF">DCVF</option>
                            <option value="DCIF">DCIF</option>
                            <option value="DWVF">DWVF</option>
                            <option value="DWIF">DWIF</option>
                            <option value="NCVF">NCVF</option>
                            <option value="NCIF">NCIF</option>
                            <option value="NWVF">NWVF</option>
                            <option value="NWIF">NWIF</option>
                            <option value="DCVA">DCVA</option>
                            <option value="DCIA">DCIA</option>
                            <option value="DWVA">DWVA</option>
                            <option value="DWIA">DWIA</option>
                            <option value="NCVA">NCVA</option>
                            <option value="NCIA">NCIA</option>
                            <option value="NWVA">NWVA</option>
                            <option value="NWIA">NWIA</option>
                            <option value="DCVL">DCVL</option>
                            <option value="DCIL">DCIL</option>
                            <option value="DWVL">DWVL</option>
                            <option value="DWIL">DWIL</option>
                            <option value="NCVL">NCVL</option>
                            <option value="NCIL">NCIL</option>
                            <option value="NWVL">NWVL</option>
                            <option value="NWIL">NWIL</option>
                            <option value="DCVH">DCVH</option>
                            <option value="DCIH">DCIH</option>
                            <option value="DWVH">DWVH</option>
                            <option value="DWIH">DWIH</option>
                            <option value="NCVH">NCVH</option>
                            <option value="NCIH">NCIH</option>
                            <option value="NWVH">NWVH</option>
                            <option value="NWIH">NWIH</option>
                            <option value="DCVS">DCVS</option>
                            <option value="DCIS">DCIS</option>
                            <option value="DWVS">DWVS</option>
                            <option value="DWIS">DWIS</option>
                            <option value="NCVS">NCVS</option>
                            <option value="NCIS">NCIS</option>
                            <option value="NWVS">NWVS</option>
                            <option value="NWIS">NWIS</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold; color:#67748e;">HV-4</small>
                        <input id="hv4" name="hv4" type="number" class="form-control hv blackInReadOnly" style="text-transform: uppercase" value="0.0">
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="row div_cods">

        </div>

        <div class="row">
            <div class="pull-right">
                <button id="btnAgregarCod" type="button" class="btn btn-primary btn-sm btnAgregarCod" style="float: right; background: green;color: black;">Agregar</button>
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
                        <input name="toque_desp" type="number" class="form-control toque_desp load_toque_desp sendingData">
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
                    <input name="ciclos_tren" type="number" class="form-control ciclos_tren load_ciclos_tren sameData">
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
                <h6 style="font-size:13px; margin: 0;">CONSUMIBLES</h6><input style="color:white; background:#38496a;" type='button' id="rowAdder" class='btn btn-info' value="AGREGAR CONSUMIBLES"/>
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
            <div id="botonera" class="pull-right">
                @if ($fam0001data->alerta == 1)
                    <button style="float: right; background: green;color: white;" type="button" class="btn btn-success enviar_a1_mision add_edit_input">Agregar Misión Aeronave Alerta</button>
                    <button style="float: right; background: yellow;color: black;" type="button" class="btn btn-warning concluir_alerta">Concluir Alerta</button>
                @endif
                <button hidden="true" style="float: right; background: rgb(189, 0, 0);color: white;" type="button" class="btn btn-danger edit_input update_A1_clean">X</button>
                <button hidden="true" style="float: right; background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success edit_input actualizar_a1_mision">ACTUALIZAR</button>
            </div>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-sm-4">
            <h6 style="font-size:13px; margin: 0;"> LISTA DE MISIONES</h6>
        </div>
        <div class="card">
            <div class="table-responsive">
                <table id="responsiveA1" class="table align-items-center mb-0">
                    <thead style="background: #e1e1e0;">
                        <tr>
                            <th class="text-uppercase font-weight-bolder"><h6>N°</h6></th>
                            <th class="text-uppercase font-weight-bolder"><h6>ORDENADO</h6></th>
                            <th class="text-uppercase font-weight-bolder"><h6>TIPO MISIÓN</h6></th>
                            <th class="text-uppercase font-weight-bolder"><h6>DESDE</h6></th>
                            <th class="text-uppercase font-weight-bolder"><h6>HASTA</h6></th>
                            <th class="text-uppercase font-weight-bolder"><h6>ACCIONES</h6></th>
                        </tr>
                    </thead>
                    <tbody id="A1_data_check">

                    </tbody>
                    <tbody id="A1_data">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
