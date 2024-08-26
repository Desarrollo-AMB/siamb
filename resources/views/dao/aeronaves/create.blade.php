@extends('layouts.user_type.auth')
@section('title', 'Parte')
@section('content')
<style>
    .text-danger {
    color: red;
}
</style>


    <div id="mensaje" name="mensaje" class="alert alert-success" style="margin: 10px 0 0 0;display:none; ">
    </div>

    {{--  <div id="mensaje2" name="mensaje2" class="alert alert-danger" style="margin: 10px 0 0 0; display:none;">

    </div>--}}
    <div class="card mb-8 mx-auto bg-warning" id="cargando" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
        <div class="card-body text-center">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
          <p class="mt-2">Cargando...</p>
        </div>
      </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Parte de Aeronaves</h5>
                        </div>
                        <a class="btn btn-bg-gradient-primary btn-sm mb-0 new_fly_bt"
                            href="{{ route('dao.aeronaves.parte_aeronave.ver') }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <form id="form-registros">

                                @csrf

                                <label for="fecha"
                                    style="display: inline-block; width: 80px; text-align: left; font-size: 16px;">Fecha:</label>
                                <input type="date" id="fecha" name="fecha" class="form-control"
                                    style="display: text-align: right; w width: 80px; " value="{{ date('Y-m-d') }}"
                                    required>
                                    <span id="fecha-error" class="text-danger" style="display: none;">El campo de fecha es requerido.</span>
                                <div class="card-body">


                                    <table id="nomina-table" class="table table-sm table-bordered table-hover w-100 nowrap">
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
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($aeronaves as $aeronave)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td><input type="hidden" name="unidad"
                                                        value="{{ $aeronave->unidad }}" >
                                                        <input type="hidden" name="id" value="{{ $aeronave->id }}">
                                                        <input type="hidden" name="ubicacion" value="{{ $aeronave->ubicacion }}">
                                                        {{ $aeronave->unidad }}</td>

                                                        <td><input type="hidden" name="sistema"
                                                            value="{{ $aeronave->sistema }}">{{ $aeronave->sistema }}</td>

                                                        <td><input type="hidden" name="matricula"
                                                            value="{{ $aeronave->matricula }}">{{ $aeronave->matricula }}</td>
                                                         <td>
                                                           <input type="hidden" name="serial"
                                                            value="{{ $aeronave->serial }}">{{ $aeronave->serial }}</td>
                                                    <td>
                                                        <select name="sitaucion" id=""
                                                            class="form-control select2">
                                                            <option
                                                                value="{{ $aeronave->situacion  }}">
                                                                {{ $aeronave->situacion }}
                                                            </option>
                                                            <option value="DISPONIBLE"{{ $aeronave->situacion == 'DISPONIBLE' ? 'selected' : '' }}>DISPONIBLE</option>
                                                            <option value="DISPONIBLE PARA EL COMBATE"{{ $aeronave->situacion == 'DISPONIBLE PARA EL COMBATE' ? 'selected' : '' }}>DISPONIBLE PARA EL COMBATE</option>
                                                            <option value="INDISPONIBLE"{{ $aeronave->situacion == 'INDISPONIBLE' ? 'selected' : '' }}>INDISPONIBLE</option>
                                                            <option value="SINIESTRADA"{{ $aeronave->situacion == 'SINIESTRADA' ? 'selected' : '' }}>SINIESTRADA</option>

                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="observacion" id="observacion" cols="15" rows="1" onkeyup="convertirAMayusculas(this)">{{$aeronave->observacion}}</textarea>
                                                    </td>
                                                    <td><textarea name= "porcentaje" id="porcentaje" cols="8" rows="1" onkeyup="convertirAMayusculas(this)">{{$aeronave->porcentaje}}</textarea>  </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar</button>
                            </form>
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
        $(function() {
            $('.select2').select2();

        });
        function convertirAMayusculas(elemento) {
        elemento.value = elemento.value.toUpperCase();
    }
    </script>

    <script>
        $(document).ready(function() {

            $('#nomina-table').DataTable({
                paging: false, // Desactivamos la paginación. Con esto evitamos que la tabla se divida en varias páginas
                fixedHeader: true, // Agregamos la opción de fixedHeader a la tabla
                scrollY: "900px", // Altura de la tabla
                scrollCollapse: true // Colapsar el tamaño de la tabla cuando no haya datos suficientes para llenar la altura
            });


        });

        function confirmarGuardar() {
    var confirmacion = confirm("¿Estás seguro de que deseas guardar los cambios? Esta acción no se puede deshacer.");

    if (confirmacion) {
        var cargandoDiv = $('#cargando');
        cargandoDiv.show();

        var aeronaves = [];
        $('#nomina-table tbody tr').each(function() {
            var aeronave = {
                id: $(this).find('input[name="id"]').val(),
                ubicacion: $(this).find('input[name="ubicacion"]').val(),
                unidad: $(this).find('input[name="unidad"]').val(),
                sistema: $(this).find('input[name="sistema"]').val(),
                matricula: $(this).find('input[name="matricula"]').val(),
                serial: $(this).find('input[name="serial"]').val(),
                situacion: $(this).find('select[name="sitaucion"]').val(),
                observacion: $(this).find('textarea[name="observacion"]').val(),
                porcentaje: $(this).find('textarea[name="porcentaje"]').val(),
            };
            aeronaves.push(aeronave);
        });
        store(aeronaves, cargandoDiv);
    }
}

$(document).ready(function() {
    $('#btn-guardar').click(function(event) {
        event.preventDefault();
        if ($('#fecha').val() === '') {
            $('#fecha-error').show();
        } else {
            $('#fecha-error').hide();
            confirmarGuardar();
        }
    });
});

function store(aeronaves, cargandoDiv) {
    $.ajax({
        url: "{{ route('dao.aeronaves.parte_aeronave.guadar') }}",
        method: 'post',
        data: {
            _token: '{{ csrf_token() }}',
            aeronaves: aeronaves,
            fecha: $('#fecha').val(),
        },
        success: function(response) {
            console.log(response);

            if (response.success) {
                var mensaje = document.getElementById("mensaje");

                $('#mensaje').show();
                setTimeout(function() {
                    mensaje.style.display = "none";
                }, 5000);
                $('#mensaje').removeClass('alert-danger').addClass('alert-success').html('Parte fue ingresado con éxito.').show();

            } else {
                var mensaje = document.getElementById("mensaje");

                $('#mensaje').show();
                setTimeout(function() {
                    mensaje.style.display = "none";
                }, 5000);
                $('#mensaje').removeClass('alert-success').addClass('alert-danger').html('Error ya Existe un parte.').show();

            }
        },
        complete: function() {
            cargandoDiv.hide();
        }
    });
}
    </script>


@endsection
