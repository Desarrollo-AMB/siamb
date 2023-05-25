<div class="row">
    <div style="margin-bottom:0; padding-bottom:0;" class="card">
        <h6 aria-expanded="true" data-toggle="collapse" href="#collapseStepOne"
            style="background: #0188aacf;color: white;padding:8px" class="card-header">
            <div class="d-flex justify-content-between align-items-end">
                <div>
                    <a class="btn-sm btn-light btn-sm mb-0" href="{{ route('dao.ver_programacion') }}">
                        <i class="ti-arrow-left" aria-hidden="true"><title>Volver</title></i> &nbsp; Volver
                    </a>&nbsp;&nbsp;
                    Nuevo Vuelo del día:
                    <input readonly="true" class="fecha" id="fecha_cabecera" type="date" style="background-color: transparent; border: none !important; color: white;" value="">
                </div>
            </div>
        </h6>
        <div class="card-body panel-collapse collapse show" id="collapseStepOne" style="padding: 15px 10px 0;">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <h6>DATOS AERONAVE</h6>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <div class="col-sm-4 mb-2 mb-sm-0">
                    <div class="form-group ov-ota-om-header">
                        <!-- <h6>OV / OTA / OM <small></small></h6> -->
                        <div class="form-check form-check-inline">
                            <input name="ov_ota_om" class="form-check-input ov_ota_om" type="radio" id="ov" value="OV" required="true" checked>
                            <label class="form-check-label" for="ov"><h6 style="color: #212529;">OV / <small></small><span style="color: #67748e;"> </span></h6></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="ov_ota_om" class="form-check-input ov_ota_om" type="radio" id="ota" value="OTA">
                            <label class="form-check-label" for="ota"><h6 style="color: #212529;">OTA / <small></small><span style="color: #67748e;"> </span></h6></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="ov_ota_om" class="form-check-input ov_ota_om" type="radio" id="om" value="OM">
                            <label class="form-check-label" for="om"><h6 style="color: #212529;">OM : <small></small><span style="color: #67748e;"> <span style="color: #67748e;" id="ov_ota_om"> </span></span></h6></label>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <h6 style="color: #212529;">Unidad y Componente: <small></small><span style="color: #67748e;"
                            id="unidad_componente"> {{ $unidad[0]->unidad }} - {{ $componentes[0]->organismo }} </span></h6>
                </div>
            </div>
        </div>
    </div>
</div>
