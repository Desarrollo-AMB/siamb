<div class="row justify-content-center">

    @role('aviacion_grupo_aereo|administrador')
        @if ( $programacion == 0 )

            <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
                <div class="card mb-0">
                    <div class="card-body text-center p-2">
                        <a href="{{ route('dao.programacionesListas') }}">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-book" aria-hidden="true"></i>
                            </div>
                            <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                <small class="font-weight-bolder mb-1">
                                    Programaciones Realizadas
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
                <div class="card mb-0">
                    <div class="card-body text-center p-2">
                        <a href="{{route('revertirSinproP', ['unidad' => $unidad])}}">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                            </div>
                            <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                <small class="font-weight-bolder mb-1">
                                    Revertir sin Programación
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
                <div class="card mb-0">
                    <div class="card-body text-center p-2">
                        <a href="{{ route('dao.imprimirProgramacionGrupoAereo', ['unidad' => $unidad]) }}">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-download" aria-hidden="true"></i>
                            </div>
                            <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                <small class="font-weight-bolder mb-1">
                                    Descargar Programación
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>

        @elseif ( $programacion == 1 )

            <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
                <div class="card mb-0">
                    <div class="card-body text-center p-2">
                        <a href="{{ route('dao.programacionesListas') }}">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-book" aria-hidden="true"></i>
                            </div>
                            <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                <small class="font-weight-bolder mb-1">
                                    Programaciones Realizadas
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
                <div class="card mb-0">
                    <div class="card-body text-center p-2">
                        <a href="#" id="enviarSinProgramacion">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                            </div>
                            <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                <small class="font-weight-bolder mb-1">
                                    Sin Programación
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </small>
                            </p>
                        </a>
                        <input id="unidadEnv" name="unidadEnv" type="hidden" value="{{ $unidad }}">
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
                <div class="card mb-0">
                    <div class="card-body text-center p-2">
                        <a href="{{ route('dao.imprimirProgramacionGrupoAereo', ['unidad' => $unidad]) }}">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-download" aria-hidden="true"></i>
                            </div>
                            <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                <small class="font-weight-bolder mb-1">
                                    Descargar Programación
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
                <div class="card mb-0">
                    <div class="card-body text-center p-2">
                        <a href="{{ route('dao.nuevaProgramacion') }}">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            </div>
                            <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                                <small class="font-weight-bolder mb-1">
                                    Agregar Programación
                                    <span class="text-success text-sm font-weight-bolder"></span>
                                </small>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endrole
    @role('aviacion_dao|administrador')

        <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
            <div class="card mb-0">
                <div class="card-body text-center p-2">
                    <a href="{{ route('dao.programacionesListas') }}">
                        <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                            <i class="fas fa-book" aria-hidden="true"></i>
                        </div>
                        <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                            <small class="font-weight-bolder mb-1">
                                Programaciones Realizadas
                                <span class="text-success text-sm font-weight-bolder"></span>
                            </small>
                        </p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
            <div class="card mb-0">
                <div class="card-body text-center p-2">
                    <a href="{{ route('dao.imprimirProgramacion', ['tipo' => 'ce']) }}">
                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                            <i class="fas fa-download" aria-hidden="true"></i>
                        </div>
                        <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                            <small class="font-weight-bolder mb-1">
                                Descargar Programación<br><br>
                                Caza - Entrenamiento
                                <span class="text-success text-sm font-weight-bolder"></span>
                            </small>
                        </p>
                    </a>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-md-2 col-sm-2 mb-xl-0 mb-2">
            <div class="card mb-0">
                <div class="card-body text-center p-2">
                    <a href="{{ route('dao.imprimirProgramacion', ['tipo' => 'th']) }}">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fas fa-download" aria-hidden="true"></i>
                        </div>
                        <p style="line-height: 0.5; margin-top:8px; margin-bottom: 0.3rem;">
                            <small class="font-weight-bolder mb-1">
                                Descargar Programación<br><br>
                                Transporte - Ala Rotatoria
                                <span class="text-success text-sm font-weight-bolder"></span>
                            </small>
                        </p>
                    </a>
                </div>
            </div>
        </div>

    @endrole


</div>

