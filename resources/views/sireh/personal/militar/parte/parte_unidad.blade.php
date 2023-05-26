@extends('layouts.user_type.auth')
@section('title', 'Parte')
@section('content')
<style>
    .dark-gradient {
        background-image: linear-gradient(to bottom right, #122fb1c0, #1ae7ee, #2a159e94);
    }
</style>
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
<div class="card dark-gradient ">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">

                        <div>
                            <h5 class="mb-0">Parte: {{$datas->ubicacion}}</h5>
                        </div>


                    </div>
                </div>
                <hr class="horizontal dark my-0">
                @include('sireh.personal.militar.parte._barra_auxiliar1')
            </div>
        </div>
    </div>
        <div class="col-xl-5 col-sm-5 mb-xl-0 mb-6">
            <div class="card mb-4 mx-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2">Parte General</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Personal</th>

                                    <td>{{ $nomina_count }}</td>
                                </tr>
                                <tr>
                                    <th>Presente</th>
                                    <td>{{ $datas->total1 }}</td>
                                </tr>
                                <tr>
                                    <th>faltan</th>
                                    <td>{{ $ausentes_count }}</td>
                                </tr>
                                <tr>
                                    <th>Servicio en la Unidad</th>
                                    <td>{{ $datas->total2 }}</td>
                                </tr>
                                <tr>
                                    <th>Servicio feura de la unidad</th>
                                    <td>{{ $datas->total3 }}</td>
                                </tr>
                                <tr>
                                    <th>Retardado</th>
                                    <td>{{ $datas->total4 }}</td>
                                </tr>
                                <tr>
                                    <th>Permiso</th>
                                    <td>{{ $datas->total5 }}</td>
                                </tr>
                                <tr>
                                    <th>Comisión País</th>
                                    <td>{{ $datas->total6 }}</td>
                                </tr>
                                <tr>
                                    <th>Comisíon Exterior</th>
                                    <td>{{ $datas->total7 }}</td>
                                </tr>
                                <tr>
                                    <th>Curso País</th>
                                    <td>{{ $datas->total8 }}</td>
                                </tr>
                                <tr>
                                    <th>Curso Exterior</th>
                                    <td>{{ $datas->total9 }}</td>
                                </tr>
                                <tr>
                                    <th>Ausente sin Causa Justificada</th>
                                    <td>{{ $datas->total10 }}</td>
                                </tr>
                                <tr>
                                    <th>Consulta</th>
                                    <td>{{ $datas->total12 }}</td>
                                </tr>
                                <tr>
                                    <th>Reposo</th>
                                    <td>{{ $datas->total13 }}</td>
                                </tr>
                                <tr>
                                    <th>Hospiatalizado</th>
                                    <td>{{ $datas->total14 }}</td>
                                </tr>
                                <tr>
                                    <th>Desertor</th>
                                    <td>{{ $datas->total15 }}</td>
                                </tr>
                                <tr>
                                    <th>Privado de Libertad</th>
                                    <td>{{ $datas->total16 }}</td>
                                </tr>
                                <tr>
                                    <th>Otro</th>
                                    <td>{{ $datas->total17 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-sm-5 mb-xl-0 mb-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="2">Parte por categoría</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Oficial Efectivo Comando</th>
                                    <td>{{ $datas->comando }}</td>
                                </tr>
                                <tr>
                                    <th>Oficial Efectivo Tecnico</th>
                                    <td>{{ $datas->tecnico }}</td>
                                </tr>
                                <tr>
                                    <th>Efectivo Comado de tropa</th>
                                    <td>{{ $datas->tropacmd }}</td>
                                </tr>
                                <tr>
                                    <th>Oficial Asimilado Tecnico</th>
                                    <td>{{ $datas->asimiladotc }}</td>
                                </tr>
                                <tr>
                                    <th>Oficial Asimilado</th>
                                    <td>{{ $datas->asimilado }}</td>
                                </tr>
                                <tr>
                                    <th>Tropa Profesional</th>
                                    <td>{{ $datas->trp }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table id="table2" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="8">Parte por Grado</th>
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
                                <tr>
                                    <th>G/J</th>
                                    <td>{{ $datas->coGJ }}</td>
                                    <td>{{ $datas->ctrpGJ }}</td>
                                    <td>{{ $datas->tecGJ }}</td>
                                    <td>{{ $datas->asGJ }}</td>
                                    <td>{{ $datas->AStecGJ }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalGJ }}</td>
                                </tr>
                                <tr>
                                    <th>M/J</th>

                                    <td>{{ $datas->coMJ }}</td>
                                    <td>{{ $datas->ctrpMJ }}</td>
                                    <td>{{ $datas->tecMJ }}</td>
                                    <td>{{ $datas->asMJ }}</td>
                                    <td>{{ $datas->AStecMJ }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalMJ }}</td>
                                </tr>
                                <tr>
                                    <th>G/D</th>
                                    <td>{{ $datas->coGD }}</td>
                                        <td>{{ $datas->ctrpGD }}</td>
                                        <td>{{ $datas->tecGD }}</td>
                                        <td>{{ $datas->asGD }}</td>
                                        <td>{{ $datas->AStecGD }}</td>
                                        <td>0</td>
                                        <td>{{ $datas->totalGD }}</td>
                                </tr>
                                <tr>
                                    <th>G/B</th>
                                    <td>{{ $datas->coGB }}</td>
                                    <td>{{ $datas->ctrpGB }}</td>
                                    <td>{{ $datas->tecGB }}</td>
                                    <td>{{ $datas->asGB }}</td>
                                    <td>{{ $datas->AStecGB }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalGB }}</td>
                                </tr>
                                <tr>
                                    <th>CNEL </th>
                                    <td>{{ $datas->coCNEL }}</td>
                                    <td>{{ $datas->ctrpCNEL }}</td>
                                    <td>{{ $datas->tecCNEL }}</td>
                                    <td>{{ $datas->asCNEL }}</td>
                                    <td>{{ $datas->AStecCNEL }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalCNEL }}</td>
                                </tr>
                                <tr>
                                    <th>TCNEL</th>
                                    <td>{{ $datas->coTCNEL }}</td>
                                    <td>{{ $datas->ctrpTCNEL }}</td>
                                    <td>{{ $datas->tecTCNEL }}</td>
                                    <td>{{ $datas->asTCNEL }}</td>
                                    <td>{{ $datas->AStecTCNEL }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalTCNEL }}</td>
                                </tr>
                                <tr>
                                    <th>MAY</th>
                                    <td>{{ $datas->coMY }}</td>
                                    <td>{{ $datas->ctrpMY }}</td>
                                    <td>{{ $datas->tecMY }}</td>
                                    <td>{{ $datas->asMY }}</td>
                                    <td>{{ $datas->AStecMY }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalMY }}</td>
                                </tr>
                                <tr>
                                    <th>CAP</th>
                                    <td>{{ $datas->coCAP }}</td>
                                    <td>{{ $datas->ctrpCAP }}</td>
                                    <td>{{ $datas->tecCAP }}</td>
                                    <td>{{ $datas->asCAP }}</td>
                                    <td>{{ $datas->AStecCAP }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalCAP }}</td>
                                </tr>
                                <tr>
                                    <th>PTTE</th>
                                    <td>{{ $datas->coPTTE }}</td>
                                    <td>{{ $datas->ctrpPTTE }}</td>
                                    <td>{{ $datas->tecPTTE }}</td>
                                    <td>{{ $datas->asPTTE }}</td>
                                    <td>{{ $datas->AStecPTTE }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalPTTE }}</td>
                                </tr>
                                <tr>
                                    <th>TTE</th>
                                    <td>{{ $datas->coTTE }}</td>
                                    <td>{{ $datas->ctrpTTE }}</td>
                                    <td>{{ $datas->tecTTE }}</td>
                                    <td>{{ $datas->asTTE }}</td>
                                    <td>{{ $datas->AStecTTE }}</td>
                                    <td>0</td>
                                    <td>{{ $datas->totalTTE }}</td>
                                </tr>
                                <tr>
                                    <th>S/S</th>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $datas->SS }}</td>
                                    <td>{{ $datas->SS }}</td>
                                </tr>
                                <tr>
                                    <th>S/A</th>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $datas->SA }}</td>
                                    <td>{{ $datas->SA }}</td>
                                </tr>
                                <tr>
                                    <th>SM/1ERA</th>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $datas->SM1 }}</td>
                                    <td>{{ $datas->SM1 }}</td>
                                </tr>
                                <tr>
                                    <th>SM/2DA</th>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $datas->SM2 }}</td>
                                    <td>{{ $datas->SM2 }}</td>
                                </tr>
                                <tr>
                                    <th>SM/3RA</th>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $datas->SM3 }}</td>
                                    <td>{{ $datas->SM3 }}</td>
                                </tr>
                                <tr>
                                    <th>S/1ERO</th>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $datas->S1 }}</td>
                                    <td>{{ $datas->S1 }}</td>
                                </tr>
                                <tr>
                                    <th>S/2DO</th>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{ $datas->S2 }}</td>
                                    <td>{{ $datas->S2 }}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td>{{ $datas->TOTALcod }}</td>
                                    <td>{{ $datas->TOTALcmdtrp }}</td>
                                    <td>{{ $datas->TOTALtec }}</td>
                                    <td>{{ $datas->TOTALas }}</td>
                                    <td>{{ $datas->TOTALastec }}</td>
                                    <td>{{ $datas->TOTALtrp }}</td>
                                    <td>{{ $datas->TOTAL }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-sm-5 mb-xl-0 mb-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Grado</th>
                                    <th>Nombre1</th>
                                    <th>Apellido</th>
                                    <th>Cedula</th>
                                    <th>Categoria</th>
                                    <th>Situacion</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($list as $liste)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $liste->grado }}</td>
                                    <td>{{ $liste->nombres }}</td>
                                    <td>{{ $liste->apellido }}</td>
                                    <td>{{ $liste->cedula }}</td>
                                    <td>{{ $liste->categoria }}</td>
                                    <td>{{ $liste->situacion }}</td>
                                    <td></td>
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
@section('scripts')
@parent
<script>
    $(document).ready(function() {
    $('#list').DataTable();
});
</script>

@endsection
