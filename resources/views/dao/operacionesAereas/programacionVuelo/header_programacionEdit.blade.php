<div class="row">
    <div style="margin-bottom:0; padding-bottom:0;" class="card">
        <h6 aria-expanded="true" data-toggle="collapse" href="#collapseStepOne"
            style="background: #0188aacf;color: white;padding:8px" class="card-header">
            <a class="btn-sm btn-light btn-sm mb-0" href="{{ route('dao.ver_programacion') }}">
                <i class="ti-arrow-left" aria-hidden="true"><title>Volver</title></i> &nbsp; Volver
            </a>&nbsp;&nbsp;
            Nuevo Vuelo del día:
            <input readonly="true" class="fecha" id="fecha_cabecera" type="date" style="background-color: transparent; border: none !important; color: white;" value="">
        </h6>
        <div class="card-body panel-collapse collapse show" id="collapseStepOne" style="padding: 15px 10px 0;">
            <div class="row">
                <h6>DATOS AERONAVE:
                    <span style="color: #67748e;" id="aeronave"></span>
                </h6>
            </div>
            <div class="row">
                <div class="col-4">
                    <h6 style="color: #212529;">OV / OTA / OM: <span style="color: #67748e;"
                        id="ov_ota_om"></span></h6>
                </div>
                <div class="col-8">
                    <h6 style="color: #212529;">Unidad y Componente: <span style="color: #67748e;"
                            id="unidad_componente"></span></h6>
                </div>
            </div>
        </div>
    </div>
</div>
