@extends('layouts.user_type.auth')

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
            <form action="" method="">
                <div class="card mb-4 mx-4">
                    <div class="card-header px-2 pt-2 pb-2">
                        <a class="btn-sm btn-primary btn-sm mb-0" href="{{ route('dao.aeronaves') }}">
                            <i class="ti-arrow-left" aria-hidden="true"><title>Volver</title></i> &nbsp; Volver
                        </a>
                    </div>
                    <div class="card-header px-2 pt-2 pb-2">
                        <h5>Editar disponibilidad de Aeronave: <span>{{ $aeronave->aeronave }} de matricula: {{ $aeronave->matricula }}</span></h5>
                        <input id="id_matricula" type="hidden" value="{{ $aeronave->id }}">
                    </div>
                    <div class="card-body px-2 pt-2 pb-2">
                        @role('aviacion_grupo_aereo')
                            <div class="row">
                                <div class="col-3">
                                    <select name="estatus" id="estatus" class="form-control estatus">
                                        <option value="{{ $aeronave->estatus }}">{{ $aeronave->estatus }}</option>
                                        <option value="DISPONIBLE">DISPONIBLE</option>
                                        <option value="DISPONIBLE PARA EL COMBATE">DISPONIBLE PARA EL COMBATE</option>
                                        <option value="INDISPONIBLE">INDISPONIBLE</option>
                                        <option value="SINIESTRADA">SINIESTRADA</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select name="porcentaje" id="porcentaje" class="form-control porcentaje">
                                        <option value="{{ $aeronave->porcentaje }}">{{ $aeronave->porcentaje }}%</option>
                                        <option value="10">10%</option>
                                        <option value="20">20%</option>
                                        <option value="40">40%</option>
                                        <option value="50">50%</option>
                                        <option value="60">60%</option>
                                        <option value="70">70%</option>
                                        <option value="80">80%</option>
                                        <option value="90">90%</option>
                                        <option value="100">100%</option>
                                    </select>
                                </div>
                                <div class="col-7">
                                    <input type="text" name="observacion" id="observacion"
                                    class="form-control observacion" width="100%"
                                    value="{{ $aeronave->observacion }}">
                                </div>
                            </div>
                        @endrole
                        @role('aviacion_dao|administrador')
                            <div class="row">
                                <div class="col-3">
                                    <select disabled name="estatus" id="estatus" class="estatus">
                                        <option value="{{ $aeronave->estatus }}">{{ $aeronave->estatus }}</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select disabled name="porcentaje" id="porcentaje" class="porcentaje">
                                        <option value="{{ $aeronave->porcentaje }}">{{ $aeronave->porcentaje }}%</option>
                                    </select>
                                </div>
                                <div class="col-7">
                                    <input readonly type="text" name="observacion" id="observacion"
                                    class="form-control observacion" width="100%"
                                    value="{{ $aeronave->observacion }}">
                                </div>
                            </div>
                        @endrole
                    </div>
                </div>
                <div class="card mb-4 mx-4">
                    <div class="card-body px-2 pt-2 pb-2">
                        @role('aviacion_grupo_aereo')
                            <div class="pull-right">
                                <button style="float: right; background: rgb(122, 151, 231);color: rgb(0, 0, 0);"
                                    type="button" class="btn btn-success"
                                    id="actualizar_aeronave_estatus">ACTUALIZAR</button>
                            </div>
                        @endrole
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            //PASO 1 Convierto en select2 los campos que lo necesitan
            $('.estatus').select2();
            $('.porcentaje').select2();


            $("#actualizar_aeronave_estatus").click(function(e) {

                e.preventDefault();

                var id_matricula = $('#id_matricula').val();
                var estatus = $('.estatus').val();
                var porcentaje = $('.porcentaje').val();
                var observacion = $('.observacion').val();

                if (estatus === "" || porcentaje === "" || observacion === "") {
                    Swal.fire({
                        title: 'Atención!',
                        text: 'Debes completar ciertos campos para continuar.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                } else {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        }
                    });

                    // enviar los datos
                    $.ajax({
                        url: "{{ route('dao.actuDisponibilidadAeronave') }}",
                        method: "POST",
                        data: {
                            id: id_matricula,
                            estatus: estatus,
                            porcentaje_disponibilidad: porcentaje,
                            observacion: observacion
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Disponibilidad Actualizada con éxito!',
                                text: '¡EN ALAS VENCEREMOS!',
                                icon: 'success',
                                timer: 6000,
                                showConfirmButton: true,
                            });
                            window.location.href = "{{ URL::to('/dao/edit-disp-aeronaves') }}/" + id_matricula;
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }

            });

        });

    </script>
@endsection
