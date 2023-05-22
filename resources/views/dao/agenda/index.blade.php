@extends('layouts.user_type.auth')
@section('title', 'FAM0001')
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
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <hr class="horizontal dark my-0">
                @include('dao.agenda._barra_auxiliar')
                <hr class="horizontal dark my-0">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Agenda del día: <span id="fecha_cabecera" class="mb-0"></span></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse" aria-expanded="false" aria-controls="flush-collapse" id="">
                                                    <span class="text-sm">Agenda de Vuelos</span>
                                                </button>
                                            </h2>
                                            <div id="flush-collapse" class="accordion-collapse collapse" aria-labelledby="flush-heading" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table id="table" class="table table-sm table-bordered table-hover nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th>SISTEMA</th>
                                                                    <th>UNIDAD</th>
                                                                    <th>SITUACION</th>
                                                                    <th>OBSERVACION</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($programacion as $programa)
                                                                    <tr>
                                                                        <td>{{ $programa->sistema }}</td>
                                                                        <td>{{ $programa->unidad }}</td>
                                                                        <td>{{ $programa->situacion }}</td>
                                                                        <td>{{ $programa->observacion }}</td>
                                                                        <td class="font-weight-normal">
                                                                            @role('aviacion_grupo_aereo|administrador')
                                                                            <a href="{{route('dao.agenda.edit', $programa->id)}}"  class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar Vuelo">
                                                                                <i class="fas fa-edit text-secondary" aria-hidden="true"></i>
                                                                            </a>
                                                                            @endrole
                                                                        </td>
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
                            </div>
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
            $('#table').DataTable({
                responsive: true
            });

            var fechaActual = new Date().toISOString().slice(0, 10);
            var fecha_inv = fechaActual.split('-').reverse().join('-');
            $('#fecha_cabecera').text(fecha_inv);
        });
    </script>
@endsection



