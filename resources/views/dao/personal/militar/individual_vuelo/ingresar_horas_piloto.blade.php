@extends('layouts.user_type.auth')
@section('title', 'Reportes')
@section('style')
    <style>

    </style>
@endsection
@section('content')

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
                            <h5 class="mb-0">Registro de horas acumuladas</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ URL::previous() }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
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
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="reporte"
                                                            id="flexRadioDefault1" checked="checked" value="1">
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            Horas de vuelo Acumuladas
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="col-lg-9 col-sm-6">
                                                    <div id="Parametros1" class="parametros ">
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <h6 class="col-sm-4 col-form-label">Seleccionar Tripulante:</h6>
                                                                <div class="col-sm-8">
                                                                    <select name="tripulanteSelect" id="tripulanteSelect" class="form-control select2">
                                                                        <option value="">Seleccionar</option>
                                                                        @foreach ($tripulantes as $tripulante)
                                                                            <option value="{{ $tripulante->codigo_empleado }}">
                                                                                {{ $tripulante->siglas }} - 
                                                                                {{ $tripulante->empleado->apellido1 }} 
                                                                                {{ $tripulante->empleado->nombre1 }} - (C.I):
                                                                                {{ $tripulante->empleado->cedula }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <br>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <button
                                                                id="btnEjecutar"
                                                                class="btn btn-primary btn-sm mb-1">Ejecutar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    </div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <input id="codigo_empleado_devuelo" name="codigo_empleado_devuelo" type="hidden" value="">
                                            <input id="grado_nombre_id" name="grado_nombre_id" type="hidden" value="">
                                            <input id="cedula" name="cedula" type="hidden" value="">
                                            <input id="funcion" name="funcion" type="hidden" value="">
                                            <input id="codigo_funcion" name="codigo_funcion" type="hidden" value="">
                                            <div class="row">
                                                <div class="col-lg-7 col-sm-7">
                                                    <div class="form-group">
                                                        <small style="font-weight: bold; color:#67748e;">Piloto o Tripulante:</small>
                                                        <input readonly id="grado_nombre_data" class="form-control" name="grado_nombre_data" type="text" value="" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-sm-5">
                                                    <div class="form-group">
                                                        <small style="font-weight: bold; color:#67748e;">Hora Total:</small>
                                                        <input id="hv" name="hv" class="form-control" type="number" value="" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-3">
                                                <div class="form-group">
                                                    <strong style="margin-bottom: 0; margin-top: 0; margin-left: 15px; margin-right: 15px;">DIURNO VFR:</strong>
                                                    <input id="hv1" name="hv1" class="form-control" type="number" value="" required>
                                                    <input id="cod1" name="cod1" class="form-control" type="hidden" value="DCV">
                                                </div>   
                                            </div>
                                            <div class="col-lg-3 col-sm-3">
                                                <div class="form-group">
                                                    <strong style="margin-bottom: 0; margin-top: 0; margin-left: 15px; margin-right: 15px;">DIURNO IFR:</strong>
                                                    <input id="hv2" name="hv2" class="form-control" type="number" value="" required>
                                                    <input id="cod2" name="cod2" class="form-control" type="hidden" value="DCI">
                                                </div>   
                                            </div>
                                            <div class="col-lg-3 col-sm-3">
                                                <div class="form-group">
                                                    <strong style="margin-bottom: 0; margin-top: 0; margin-left: 15px; margin-right: 15px;">NOCTURNO VFR:</strong>
                                                    <input id="hv3" name="hv3" class="form-control" type="number" value="" required>
                                                    <input id="cod3" name="cod3" class="form-control" type="hidden" value="NCV">
                                                </div>  
                                            </div>
                                            <div class="col-lg-3 col-sm-3">
                                                <div class="form-group">
                                                    <strong style="margin-bottom: 0; margin-top: 0; margin-left: 15px; margin-right: 15px;">NOCTURNO IFR:</strong>
                                                    <input id="hv4" name="hv4" class="form-control" type="number" value="" required>
                                                    <input id="cod4" name="cod4" class="form-control" type="hidden" value="NCI">
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button id="btnAgregarHoras" class="btn btn-dark btn-sm mb-1">Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            //PASO 1 Convierto en select2 los campos que lo necesitan
            $('.select2').select2();

            $(document).on('select2:open', () => {
                setTimeout(function() {
                    document.querySelector('.select2-container--open .select2-search__field').focus();
                }, 10);
            });

            function clean_B1() {
                $('#codigo_empleado_devuelo').val('');
                $('#grado_nombre_id').val('');
                $('#grado_nombre_data').val('');
                $('#cedula').val('');
                $('#funcion').val('');
                $('#codigo_funcion').val('');
                $('#hv').val('');
                $('#cod1').val('');
                $('#hv1').val('');
                $('#cod2').val('');
                $('#hv2').val('');
                $('#cod3').val('');
                $('#hv3').val('');
                $('#cod4').val('');
                $('#hv4').val('');
                $('#tripulanteSelect').val('').trigger('change'); // Establecer valor en blanco y activar el evento 'change'
            }

            $("#btnEjecutar").click(function() {

                var tripulanteSelect = $('#tripulanteSelect').val();

                //VALIDAR CAMPOS
                if (tripulanteSelect === "") {
                    Swal.fire({
                        title: 'Atención!',
                        text: 'Debes seleccionar a un Piloto o Tripulante.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                    console.log('no puedes guardar datos vacios')

                }
                else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('dao.ingresar.obtenerTripulante') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            codigo_empleado: $('#tripulanteSelect').val()
                        },
                        success: function(response) {
                            $tripulante = response.data;
    
                            $('#codigo_empleado_devuelo').val($tripulante.codigo_empleado);
                            $('#grado_nombre_id').val($tripulante.id_empleado_funcion);
                            $('#grado_nombre_data').val($tripulante.siglas + ' - ' + $tripulante.apellido1 + ' ' + $tripulante.nombre1 + ' - (C.I): ' + $tripulante.cedula);
                            $('#cedula').val($tripulante.cedula);
                            $('#funcion').val($tripulante.id_funcion);
                            $('#codigo_funcion').val($tripulante.codigo);
                            $('#hv').val($tripulante.hv);
                            $('#hv1').val($tripulante.hv1);
                            $('#hv2').val($tripulante.hv2);
                            $('#hv3').val($tripulante.hv3);
                            $('#hv4').val($tripulante.hv4);
    
                        },
                        error: function(error) {
                            console.log(error)
                            alert('error');
                        }
                    });
                }
            });

            $("#btnAgregarHoras").click(function() {

                var codigo_empleado = $('#codigo_empleado_devuelo').val();
                var grado_nombre_id = $('#grado_nombre_id').val();
                var grado_nombre_data = $('#grado_nombre_data').val();
                var cedula = $('#cedula').val();
                var funcion = $('#funcion').val();
                var codigo_funcion = $('#codigo_funcion').val();
                var hv = $('#hv').val();
                var cod1 = $('#cod1').val();
                var hv1 = $('#hv1').val();
                var cod2 = $('#cod2').val();
                var hv2 = $('#hv2').val();
                var cod3 = $('#cod3').val();
                var hv3 = $('#hv3').val();
                var cod4 = $('#cod4').val();
                var hv4 = $('#hv4').val();

                //VALIDAR CAMPOS
                if (codigo_empleado === "" ||
                    grado_nombre_id === "" ||
                    grado_nombre_data === "" ||
                    cedula === "" ||
                    funcion === "" || 
                    codigo_funcion === "" ||
                    hv === "" ||
                    hv1 === "" ||
                    hv2 === "" ||
                    hv3 === "" ||
                    hv4 === "") {
                    Swal.fire({
                        title: 'Atención!',
                        text: 'Debes llenar todos los campos.',
                        icon: 'warning',
                        timer: 3000,
                        showConfirmButton: true,
                    });
                    console.log('no puedes guardar datos vacios')

                }
                else {
                    //ENVIAR
                    $.ajax({
                        url: "{{ route('dao.store_b1_anterior') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            codigo_empleado: codigo_empleado,
                            grado_nombre_id: grado_nombre_id,
                            grado_nombre_data: grado_nombre_data,
                            cedula: cedula,
                            funcion: funcion,
                            codigo_funcion: codigo_funcion,
                            hv: hv,
                            cod1: cod1,
                            hv1: hv1,
                            cod2: cod2,
                            hv2: hv2,
                            cod3: cod3,
                            hv3: hv3,
                            cod4: cod4,
                            hv4: hv4
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Exitoso!',
                                text: 'Se agrego Correctamente.',
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: true,
                            });
                            clean_B1()
                        },
                        error: function(error) {
                            console.log(error)
                            alert('error');
                        }
                    });
                }
            });

        });
    </script>
@endsection
