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
                        @foreach ($datas as $datas)
                        <div>
                            <h5 class="mb-0">Aeronaves: {{$datas->ubicacion}}</h5>
                        </div>
                        @endforeach



                    </div>
                </div>
                <hr class="horizontal dark my-0">
                @include('dao.aeronaves._barra_auxiliarAe')
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
                                    <th scope="col" colspan="2">Parte de Aeronave</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                        <tr>
                                            <th>Aeronaves </th>
                                            <td>{{ $num->total }}</td>
                                        </tr>
                                        <tr>
                                            <th>Disponible </th>
                                            <td>{{ $num->total1 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Disponible para el Combate</th>
                                            <td>{{ $num->total2 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Indisponible </th>
                                            <td>{{ $num->total3 }}</td>
                                        </tr>
                                        <tr>
                                            <th>Siniestrada </th>
                                            <td>{{ $num->total4 }}</td>
                                        </tr>

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
                                    <th>Unidad</th>
                                    <th>Sistema </th>
                                    <th>Matricula</th>
                                    <th>Serial</th>
                                    <th>Situacion</th>
                                    <th>Observacion</th>
                                    <th>Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($list as $liste)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $liste->unidad }}</td>
                                    <td>{{ $liste->sistema }}</td>
                                    <td>{{ $liste->matricula }}</td>
                                    <td>{{ $liste->serial }}</td>
                                    <td>{{ $liste->situacion}}</td>
                                    <td>{{ $liste->observacion }}</td>
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
