<div class="row justify-content-center">

    <div class="col-xl-4 col-md-4 col-sm-4 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-9">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                            <h5 class="font-weight-bolder mb-0">
                                Programación de Vuelo
                                <span class="text-success text-sm font-weight-bolder"></span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <a href="{{ route('dao.ver_programacion') }}">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-plane-departure text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-4 col-sm-4 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-9">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                            <h5 class="font-weight-bolder mb-0">
                                Historico de vuelos
                                <span class="text-success text-sm font-weight-bolder"></span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <a href="{{ route('dao.forms.listado_pilotos') }}">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                <i class="fa fa-plane text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

