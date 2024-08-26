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
                            <h5 class="mb-0">Parte</h5>
                        </div>
                        <a class="btn btn-bg-gradient-primary btn-sm mb-0 new_fly_bt"
                            href="{{ route('sireh.personal.militar.parte.reporte.reportes') }}">Reporte</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <form id="form-registros" >

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
                                                <th>Grado</th>
                                                <th>Nombre </th>
                                                <th>Apellido</th>
                                                <th>Cedula</th>
                                                <th>Ubicacion</th>
                                                <th>Situacion</th>
                                                <th>Observacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($nominas as $nomina)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $nomina->siglas }}
                                                        <input type="hidden" name="codigo_empleado"
                                                            value="{{ $nomina->codigo_empleado }}">
                                                        <input type="hidden" name="codigo_ubicacion"
                                                            value="{{ $nomina->codigo_ubicacion }}">
                                                        <input type="hidden" name="codigo_categoria"
                                                            value="{{ $nomina->codigo_categoria }}">
                                                        <input type="hidden" name="grado_militar"
                                                            value="{{ $nomina->grado_militar }}">
                                                    </td>
                                                    <td>{{ $nomina->nombre1 }}</td>
                                                    <td>{{ $nomina->apellido1 }}</td>
                                                    <td>{{$nomina->cedula}}</td>
                                                    <td>{{ $nomina->descripcion }}</td>
                                                    <td>
                                                        <select name="sitaucion" id=""
                                                            class="form-control select2">
                                                            <option
                                                                value="presente"{{ $nomina->situacion == 'Presente' ? 'selected' : '' }}>
                                                                Presente</option>

                                                                <option
                                                                value="Permiso"{{ $nomina->situacion == 'Permiso' ? 'selected' : '' }}>
                                                                Permiso</option>

                                                            <option
                                                                value="Servicio en la Unidad"{{ $nomina->situacion == 'Servicio en la Unidad' ? 'selected' : '' }}>
                                                                Servicio en la Unidad</option>
                                                            <option
                                                                value="Servicio fuera de la Unidad"{{ $nomina->situacion == 'Servicio fuera de la Unidad' ? 'selected' : '' }}>
                                                                Servicio fuera de la Unidad</option>
                                                            <option
                                                                value="Retardado"{{ $nomina->situacion == 'Retardado' ? 'selected' : '' }}>
                                                                Retardado</option>
                                                            <option
                                                                value="Comision Pais"{{ $nomina->situacion == 'Comision Pais' ? 'selected' : '' }}>
                                                                Comision Pais</option>
                                                            <option
                                                                value="Comision Exterior"{{ $nomina->situacion == 'Comision Exterior' ? 'selected' : '' }}>
                                                                Comision Exterior</option>
                                                            <option
                                                                value="Cusrso Exterior"{{ $nomina->situacion == 'Cusrso Exterior' ? 'selected' : '' }}>
                                                                Cusrso Exterior</option>
                                                            <option
                                                                value="Curso Pais"{{ $nomina->situacion == 'Curso Pais' ? 'selected' : '' }}>
                                                                Curso Pais</option>
                                                            <option
                                                                value="Curso Exterior"{{ $nomina->situacion == 'Curso Exterior' ? 'selected' : '' }}>
                                                                Curso Exterior</option>
                                                            <option
                                                                value="Ausente sin causa Justificada"{{ $nomina->situacion == 'Ausente sin causa Justificada' ? 'selected' : '' }}>


                                                            </option>
                                                            <option
                                                                value="Destacado fuera de la Unidad"{{ $nomina->situacion == 'Destacado fuera de la Unidad' ? 'selected' : '' }}>
                                                                Destacado fuera de la Unidad</option>
                                                            <option
                                                                value="Consulta"{{ $nomina->situacion == 'Consulta' ? 'selected' : '' }}>
                                                                Consulta</option>
                                                            <option
                                                                value="Reposo"{{ $nomina->situacion == 'Reposo' ? 'selected' : '' }}>
                                                                Reposo</option>
                                                            <option
                                                                value="Hospitalizado"{{ $nomina->situacion == 'Hospitalizado' ? 'selected' : '' }}>
                                                                Hospitalizado</option>
                                                            <option
                                                                value="Desertor"{{ $nomina->situacion == 'Desertor' ? 'selected' : '' }}>
                                                                Desertor</option>
                                                            <option
                                                                value="Privado de Libertad"{{ $nomina->situacion == 'Privado de Libertad' ? 'selected' : '' }}>
                                                                Privado de Libertad</option>
                                                            <option
                                                                value="Otro"{{ $nomina->situacion == 'Otro' ? 'selected' : '' }}>
                                                                Otro</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="observacion" id="observacion" cols="15" rows="1"></textarea>
                                                    </td>
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

        var nominas = [];
        $('#nomina-table tbody tr').each(function() {
            var nomina = {
                codigo_empleado: $(this).find('input[name="codigo_empleado"]').val(),
                codigo_ubicacion: $(this).find('input[name="codigo_ubicacion"]').val(),
                codigo_categoria: $(this).find('input[name="codigo_categoria"]').val(),
                grado_militar: $(this).find('input[name="grado_militar"]').val(),
                situacion: $(this).find('select[name="sitaucion"]').val(),
                observacion: $(this).find('textarea[name="observacion"]').val(),
            };
            nominas.push(nomina);
        });
        store(nominas, cargandoDiv);
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

function store(nominas, cargandoDiv) {
    $.ajax({
        url: "{{ route('sireh.personal.militar.parte') }}",
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            nominas: nominas,
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
