@extends('layouts.user_type.auth')
@section('title', 'Parte')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger mx-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success mx-4" role="alert">
            <span class="text-white">{{ $message }}</span>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Parte General</h5>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                @include('sireh.personal.militar.parte._barra_auxiliar')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card_responsive">
                <div class="d-flex flex-row justify-content-between">
                    <div class="card" style="width: 30rem;">
                        <img src="{{ asset('imagenes/images.jpg') }}" alt="mi foto">
                        <div class="card-body">
                            <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col" class="center" colspan="2">Parte General</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th>Personal</th>

                                        <td>{{ $nomina_count }}</td>
                                    </tr>
                                    @foreach ($parte_generales as $parte_general)
                                        <tr>
                                            <th>Presente</th>
                                            <td>{{ $parte_general->total1 }}</td>
                                        </tr>
                                        <tr>
                                            <th>faltan</th>
                                            <td>{{ $ausentes_count }}</td>
                                        </tr>
                                        <tr>
                                            <th>Servicio en la Unidad</th>
                                            <td>{{ $parte_general->total2 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Servicio feura de la unidad</th>
                                            <td>{{ $parte_general->total3 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Retardado</th>
                                            <td>{{ $parte_general->total4 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Permiso</th>
                                            <td>{{ $parte_general->total5 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Comisión País</th>
                                            <td>{{ $parte_general->total6 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Comisíon Exterior</th>
                                            <td>{{ $parte_general->total7 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Curso País</th>
                                            <td>{{ $parte_general->total8 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Curso Exterior</th>
                                            <td>{{ $parte_general->total9 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ausente sin Causa Justificada</th>
                                            <td>{{ $parte_general->total10 }}</td>
                                        </tr>

                                        <tr>
                                            <th>Consulta</th>
                                            <td>{{ $parte_general->total12 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Reposo</th>
                                            <td>{{ $parte_general->total13 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Hospiatalizado</th>
                                            <td>{{ $parte_general->total14 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Desertor</th>
                                            <td>{{ $parte_general->total15 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Privado de Libertad</th>
                                            <td>{{ $parte_general->total16 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Otro</th>
                                            <td>{{ $parte_general->total17 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table_responsive">
                                <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="center" colspan="8">Parte por categoira</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categorias as $categoria)
                                            <tr>
                                                <th>Oficial Efectivo Comando</th>
                                                <td>{{ $categoria->comando }}</td>
                                            </tr>
                                            <tr>
                                                <th>Oficial Efectivo Tecnico</th>
                                                <td>{{ $categoria->tecnico }}</td>
                                            </tr>
                                            <tr>
                                                <th>Efectivo Comado de tropa</th>
                                                <td>{{ $categoria->tropacmd }}</td>
                                            </tr>
                                            <tr>
                                                <th>Oficial Asimilado Tecnico</th>
                                                <td>{{ $categoria->asimiladotc }}</td>
                                            </tr>
                                            <tr>
                                                <th>Oficial Asimilado</th>
                                                <td>{{ $categoria->asimilado }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tropa Profesional</th>
                                                <td>{{ $categoria->trp }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </thead>
                                </table>
                                <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="center" colspan="4">Parte por Grado</th>
                                        </tr>
                                        <tr>
                                            <th>Grado</th>
                                            <th>CDO.</th>
                                            <th>CDO.TRP</th>
                                            <th>TECN</th>
                                            <th>ASIM</th>
                                            <th>AS TEC</th>
                                            <th>TRP</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grados as $grado)
                                            <tr>
                                                <th>G/J</th>
                                                <td>{{ $grado->coGJ }}</td>
                                                <td>{{ $grado->ctrpGJ }}</td>
                                                <td>{{ $grado->tecGJ }}</td>
                                                <td>{{ $grado->asGJ }}</td>
                                                <td>{{ $grado->AStecGJ }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalGJ }}</td>
                                            </tr>
                                            <tr>
                                                <th>M/J</th>

                                                <td>{{ $grado->coMJ }}</td>
                                                <td>{{ $grado->ctrpMJ }}</td>
                                                <td>{{ $grado->tecMJ }}</td>
                                                <td>{{ $grado->asMJ }}</td>
                                                <td>{{ $grado->AStecMJ }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalMJ }}</td>
                                            </tr>
                                            <tr>
                                                <th>G/D</th>
                                                <td>{{ $grado->coGD }}</td>
                                                <td>{{ $grado->ctrpGD }}</td>
                                                <td>{{ $grado->tecGD }}</td>
                                                <td>{{ $grado->asGD }}</td>
                                                <td>{{ $grado->AStecGD }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalGD }}</td>
                                            </tr>
                                            <tr>
                                                <th>G/B</th>
                                                <td>{{ $grado->coGB }}</td>
                                                <td>{{ $grado->ctrpGB }}</td>
                                                <td>{{ $grado->tecGB }}</td>
                                                <td>{{ $grado->asGB }}</td>
                                                <td>{{ $grado->AStecGB }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalGB }}</td>
                                            </tr>
                                            <tr>
                                                <th>CNEL </th>
                                                <td>{{ $grado->coCNEL }}</td>
                                                <td>{{ $grado->ctrpCNEL }}</td>
                                                <td>{{ $grado->tecCNEL }}</td>
                                                <td>{{ $grado->asCNEL }}</td>
                                                <td>{{ $grado->AStecCNEL }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalCNEL }}</td>
                                            </tr>
                                            <tr>
                                                <th>TCNEL</th>
                                                <td>{{ $grado->coTCNEL }}</td>
                                                <td>{{ $grado->ctrpTCNEL }}</td>
                                                <td>{{ $grado->tecTCNEL }}</td>
                                                <td>{{ $grado->asTCNEL }}</td>
                                                <td>{{ $grado->AStecTCNEL }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalTCNEL }}</td>
                                            </tr>
                                            <tr>
                                                <th>MAY</th>
                                                <td>{{ $grado->coMY }}</td>
                                                <td>{{ $grado->ctrpMY }}</td>
                                                <td>{{ $grado->tecMY }}</td>
                                                <td>{{ $grado->asMY }}</td>
                                                <td>{{ $grado->AStecMY }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalMY }}</td>
                                            </tr>
                                            <tr>
                                                <th>CAP</th>
                                                <td>{{ $grado->coCAP }}</td>
                                                <td>{{ $grado->ctrpCAP }}</td>
                                                <td>{{ $grado->tecCAP }}</td>
                                                <td>{{ $grado->asCAP }}</td>
                                                <td>{{ $grado->AStecCAP }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalCAP }}</td>
                                            </tr>
                                            <tr>
                                                <th>PTTE</th>
                                                <td>{{ $grado->coPTTE }}</td>
                                                <td>{{ $grado->ctrpPTTE }}</td>
                                                <td>{{ $grado->tecPTTE }}</td>
                                                <td>{{ $grado->asPTTE }}</td>
                                                <td>{{ $grado->AStecPTTE }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalPTTE }}</td>
                                            </tr>
                                            <tr>
                                                <th>TTE</th>
                                                <td>{{ $grado->coTTE }}</td>
                                                <td>{{ $grado->ctrpTTE }}</td>
                                                <td>{{ $grado->tecTTE }}</td>
                                                <td>{{ $grado->asTTE }}</td>
                                                <td>{{ $grado->AStecTTE }}</td>
                                                <td>0</td>
                                                <td>{{ $grado->totalTTE }}</td>
                                            </tr>
                                            <tr>
                                                <th>S/S</th>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ $grado->SS }}</td>
                                                <td>{{ $grado->SS }}</td>
                                            </tr>
                                            <tr>
                                                <th>S/A</th>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ $grado->SA }}</td>
                                                <td>{{ $grado->SA }}</td>
                                            </tr>
                                            <tr>
                                                <th>SM/1ERA</th>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ $grado->SM1 }}</td>
                                                <td>{{ $grado->SM1 }}</td>
                                            </tr>
                                            <tr>
                                                <th>SM/2DA</th>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ $grado->SM2 }}</td>
                                                <td>{{ $grado->SM2 }}</td>
                                            </tr>
                                            <tr>
                                                <th>SM/3RA</th>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ $grado->SM3 }}</td>
                                                <td>{{ $grado->SM3 }}</td>
                                            </tr>
                                            <tr>
                                                <th>S/1ERO</th>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ $grado->S1 }}</td>
                                                <td>{{ $grado->S1 }}</td>
                                            </tr>
                                            <tr>
                                                <th>S/2DO</th>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>{{ $grado->S2 }}</td>
                                                <td>{{ $grado->S2 }}</td>
                                            </tr>
                                            <tr>
                                                <th>TOTAL</th>
                                                <td>{{ $grado->totalCOM }}</td>
                                                <td>{{ $grado->totalCMDTRP }}</td>
                                                <td>{{ $grado->totalTEC }}</td>
                                                <td>{{ $grado->totalASIM }}</td>
                                                <td>{{ $grado->totalASTEC }}</td>
                                                <td>{{ $grado->totalTRP }}</td>
                                                <td>{{ $grado->TOTAL }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
