<div class="row justify-content-center">

    <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
        <div class="card mb-0">
            <div class="card-body text-center p-2">
                @if ($existe_parte == 2)
                    <a href="#" style="color: gray; pointer-events: none; text-decoration: none;">
                        <div class="icon icon-shape bg-gradient-secondary shadow text-center border-radius-md">
                            <i class="fas fa-plane-departure text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                            <small class="font-weight-bolder mb-1">
                                Programación de Vuelo
                                <span class="text-success text-sm font-weight-bolder"></span>
                            </small>
                        </p>
                    </a>
                @else
                    <a href="#" id="ver_prog">
                        <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                            <i class="fas fa-plane-departure text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                        <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                            <small class="font-weight-bolder mb-1">
                                Programación de Vuelo
                                <span class="text-success text-sm font-weight-bolder"></span>
                            </small>
                        </p>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
        <div class="card mb-0">
            <div class="card-body text-center p-2">
                <a href="{{ route('dao.vuelos.realizados.index') }}">
                    <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                        <i class="fa fa-plane text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                    <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                        <small class="font-weight-bolder mb-1">
                            Vuelos Realizados
                            <span class="text-success text-sm font-weight-bolder"></span>
                        </small>
                    </p>
                </a>
            </div>
        </div>
    </div>

</div>

