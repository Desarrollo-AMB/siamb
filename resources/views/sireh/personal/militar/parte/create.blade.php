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

  @if ($message = Session::get('success_message'))
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
                            <h5 class="mb-0">Parte</h5>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <form id="form-registros">
                                @csrf

                                <label for="fecha" style="display: inline-block; width: 80px; text-align: left; font-size: 16px;">Fecha:</label>
                                        <input type="date" id="fecha" name="fecha" class="form-control" style="display: text-align: right; w width: 80px; " value="{{ date('Y-m-d')}}" required>
                                <div class="card-body">
                                        <table id="nomina-table"
                                            class="table table-sm table-bordered table-hover w-100 nowrap" >
                                            <thead>
                                                <tr>
                                                    <th>Grado</th>
                                                    <th>Nombre </th>
                                                    <th>Apellido</th>
                                                    <th>Ubicacion</th>
                                                    <th>Situacion</th>
                                                    <th>Observacion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($nominas as $nomina)
                                                    <tr>
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
                                                        <td>{{ $nomina->descripcion }}</td>
                                                        <td>
                                                            <select name="sitaucion" id=""
                                                                class="form-control select2">
                                                                <option
                                                                    value="presente"{{ $nomina->situacion == 'Presente' ? 'selected' : '' }}>
                                                                    Presente</option>
                                                                <option
                                                                    value="comision"{{ $nomina->situacion == 'Comision' ? 'selected' : '' }}>
                                                                    comision</option>
                                                                <option
                                                                    value="Reposo"{{ $nomina->situacion == 'Reposo' ? 'selected' : '' }}>
                                                                    Reposo</option>
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
        $(document).ready(function() {

            $('#nomina-table').DataTable({

            });
            new $.fn.DataTable.FixedHeader( table );

        });

        $(document).ready(function() {
            $('#btn-guardar').click(function() {
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
                store(nominas);
            });
        });

        function store(nominas) {
            $.ajax({
                url: "{{ route('sireh.personal.militar.parte') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nominas: nominas,
                    fecha: $('#fecha').val(),
                },
                success: function(response) {
                    if (response.error) {
                        $('#mensaje').removeClass('alert-success').addClass('alert-danger').html(response.error).show();
                    } else {
                        $('#mensaje').removeClass('alert-danger').addClass('alert-success').html('Parte fue ingresado con éxito.').show();
                    }
                },
                error: function(response) {
                    $('#mensaje').removeClass('alert-success').addClass('alert-danger').html('Ha ocurrido un error al guardar los datos.').show();
                }
            });
        }
        </script>

    <script>
        $(function() {
            $('.select2').select2();

        });
    </script>
@endsection
