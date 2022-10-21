<div class="row">

    <div class="row pt-4">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold;">Nº VUELO<h6>
                    <select id="n_vuelo" name="n_vuelo" class="form-control n_vuelo load_n_vuelo">
                        <option value=""></option>
                    </select>
                    {{-- <input hidden="true" name="v_mision" type="text" class="form-control v_mision load_v_mision">  --}}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <h6 style="font-weight: bold;">EN APOYO A</h6>
                    <input readonly="true" name="apoyo_carga" type="text" class="form-control apoyo_carga load_apoyo_carga" style="text-transform: uppercase"> 
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold;">PESO(Kg)</h6>
                    <input name="pesocargaTotal" type="number" class="form-control pesocargaTotal load_pesocargaTotal"> 
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <h6 style="font-weight: bold;">VOL(m³)<h6>
                    <input name="volCargaTotal" type="number" class="form-control volCargaTotal load_volCargaTotal"> 
                </div>
            </div>
        </div>
    </div>

    <div class="row pb-2">
        <div class="row">
            <h6 style="font-size:13px; margin: 0;">TIPO DE CARGA</h6>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <small style="font-weight: bold;">SECA(Kg)</small>
                    <input name="seca" type="number" class="form-control seca load_seca">    
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <small style="font-weight: bold;">LíQUIDA(Lts)</small>
                    <input name="liquida" type="number" class="form-control liquida load_liquida">    
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <small style="font-weight: bold;">COMB(Lts)</small>
                    <input name="comb" type="number" class="form-control comb load_comb">    
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <small style="font-weight: bold;">AMMTO(Kg)</small>
                    <input name="ammto" type="number" class="form-control ammto load_ammto">    
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <small style="font-weight: bold;">TOX/PEL(Kg)</small>
                    <input name="tox_pel" type="number" class="form-control tox_pel load_tox_pel">    
                </div>
            </div>
        </div>
        <br>
    </div>

    <div class="row pb-2">
        <div class="row">
            <h6 style="font-size:13px; margin: 0;">PERSONAS CANTIDAD</h6>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <small style="font-weight: bold;">MIL</small>
                    <input name="mil" type="number" class="form-control mil load_mil">    
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <small style="font-weight: bold;">GOB</small>
                    <input name="gob" type="number" class="form-control gob load_gob">    
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <small style="font-weight: bold;">NO GOB</small>
                    <input name="no_gob" type="number" class="form-control no_gob load_no_gob">    
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <small style="font-weight: bold;">CIVIL</small>
                    <input name="civil" type="number" class="form-control civil load_civil">    
                </div>
            </div>
        </div>
        <br>
    </div>

    <div class="row pb-2">
        <div class="col-3">
            <div class="row">
                <h6 style="font-size:13px; margin: 0;">ANIMALES</h6>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <small style="font-weight: bold;">CANTIDAD</small>
                        <input name="cant_animales" type="number" class="form-control cant_animales load_cant_animales">    
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <h6 style="font-size:13px; margin: 0;">LANZAMIENTO</h6>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold;">CARGA(Kg)</small>
                        <input name="carga" type="number" class="form-control carga load_carga">    
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <small style="font-weight: bold;">PERS(CANT)</small>
                        <input name="pers" type="number" class="form-control pers load_pers">    
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>

    <div style="padding-top:5px" class="row">
        <div  class="pull-right">
            <button style="float: right; background: green;color: white;" type="button" class="btn btn-success enviar_a3 add_edit_carga_input">Agregar Carga</button>
            <div>
                <button hidden="true" style="float: right; background: rgb(189, 0, 0);color: white;" type="button" class="btn btn-danger edit_input_carga update_carga_clean">X</button>
                <button hidden="true" style="float: right; background: rgb(122, 151, 231);color: rgb(0, 0, 0);" type="button" class="btn btn-success edit_input_carga actualizar_carga">ACTUALIZAR</button>
            </div>
            <input hidden="true" name="id_trip" type="text" class="form-control id_trip load_id_trip"> 
        </div>
    </div>
    <hr>
    <div class="row pt-3">
        <div class="col-sm-4">
            <h6 style="font-size:13px; margin: 0;">LISTA DATOS DE CARGA Y PASAJEROS<small></small></h6> 
        </div>
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead style="background: #e1e1e0;">
                    <tr>
                        {{-- <th class="text-uppercase font-weight-bolder"><h6>N°</h6></th> --}}
                        <th class="text-uppercase font-weight-bolder"><h6>Nº VUELO</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>EN APOYO A</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>CARGA TOTAL PESO/VOL</h6></th>
                        <th class="text-uppercase font-weight-bolder"><h6>ACCIONES</h6></th>
                    </tr>
                </thead>
                <tbody id="A3_data">

                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>