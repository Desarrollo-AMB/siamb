<div class="row">
    <div style="margin-bottom:0; padding-bottom:0;" id="step_one" class="card" hidden="true">
        <h6 aria-expanded="true" data-toggle="collapse" href="#collapseStepOne" style="background: #08acc9;color: white;padding:8px" class="card-header">
            PASOS COMPLETADOS
            <span id="alerta" class="text-warning">
                @if ($esAlerta == 1)
                    <label class="badge bg-warning" style="color:black;">AERONAVE ALERTA</label>
                @endif
            </span>
        </h6>
        <div class="card-body panel-collapse collapse show"  id="collapseStepOne" style="padding: 15px 10px 0;">
            <div class="row">
                <h6>DATOS AERONAVE: <span id="aeronave_span"></span></h6>
            </div>
            <div class="row">
            <div class="col-3">
                <h6 style="color: #212529;">OV / OTA / OM: <small></small><span style="color: #67748e;" id="ov_ota_om"> </span></h6>
            </div>
            <div class="col-6">
                <h6 style="color: #212529;">Componente: <small></small><span style="color: #67748e;" id="aeronave_modelo"> </span></h6>
            </div>
            <div class="col-2">
                <h6 style="color: #212529;">Fecha: <small></small><span style="color: #67748e;" id="fecha"> </span></h6>
            </div>
            {{-- <div class="show_step_two">
                <div class="row">
                    <h6>A1 MISION</h6>
                </div>
                <div class="row">
                <div class="col-3">
                    <h6 style="color: #212529;">OV / OTA / OM: <small></small><span style="color: #67748e;" id="ov_ota_om"> </span></h6>
                </div>
                <div class="col-6">
                    <h6 style="color: #212529;">Componente: <small></small><span style="color: #67748e;" id="aeronave_modelo"> </span></h6>
                </div>
                <div class="col-2">
                    <h6 style="color: #212529;">Fecha: <small></small><span style="color: #67748e;" id="fecha"> </span></h6>
                </div>
            </div> --}}

            </div>
        </div>
    </div>
</div>

