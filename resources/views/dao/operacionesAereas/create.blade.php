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
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="card-body px-2 pt-2 pb-2">
        <div class="row">
            <div class="col-8">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0 mb-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Programacion fin de Semana</h5>
                            </div>
                            <a class="btn btn-secondary btn-sm mb-0" href="{{ route('dao.agenda') }}">Volver</a>
                        </div>
                    </div>
                    <hr class="horizontal dark my-0">
                    <div class="card-body px-2 pt-2 pb-2">
                        {!! Form::open(['route' => 'dao.forms.storeProFin', 'method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="desde">Desde:</label>
                                    <input type="date" name="desde[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="hasta">Hasta:</label>
                                    <input type="date" name="hasta[]" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Sistema:</strong>
                                    <select class="select2 form-control" name="sistema[]" required>
                                        <option value="">Seleccione ...</option>
                                        @foreach ($aeronaveM as $data)
                                            <option value="{{ $data->modelo }} - {{ $data->matricula }}">{{ $data->modelo }} - {{ $data->matricula }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <strong>Unidad:</strong>
                                    {!! Form::text('unidad[]', $aeronave->aeronave, [
                                        'placeholder' => 'Unidad',
                                        'class' => 'form-control',
                                        'readonly' => 'readonly',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8">
                                <div class="form-group">
                                    <strong>Situacion:</strong>
                                    {!! Form::text('situacion[]', null, [
                                        'placeholder' => 'Situacion',
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-8">
                                <div class="form-group">
                                    <strong>Observacion:</strong>
                                    {!! Form::text('observacion[]', null, [
                                        'placeholder' => 'Observacion',
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div id="formularios-adicionales">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" id="agregar-formulario" class="btn btn-primary btn-sm">Agregar formulario</button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            var contadorFormularios = 0;

            function agregarFormulario() {
                contadorFormularios++;
                var nuevoFormulario = `
                    <div class="formulario-adicional mt-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="desde">Desde:</label>
                                            <input type="date" name="desde[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="hasta">Hasta:</label>
                                            <input type="date" name="hasta[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Sistema:</strong>
                                            <select class="select2 form-control" name="sistema[]" required>
                                                <option value="">Seleccione ...</option>
                                                @foreach ($aeronaveM as $data)
                                                    <option value="{{ $data->modelo }} - {{ $data->matricula }}">{{ $data->modelo }} - {{ $data->matricula }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Unidad:</strong>
                                            {!! Form::text('unidad[]', $aeronave->aeronave, [
                                                'placeholder' => 'Unidad',
                                                'class' => 'form-control',
                                                'readonly' => 'readonly',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <div class="form-group">
                                            <strong>Situacion:</strong>
                                            {!! Form::text('situacion[]', null, [
                                                'placeholder' => 'Situacion',
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8">
                                        <div class="form-group">
                                            <strong>Observacion:</strong>
                                            {!! Form::text('observacion[]', null, [
                                                'placeholder' => 'Observacion',
                                                'class' => 'form-control',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-danger btn-sm eliminar-formulario">Eliminar formulario</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#formularios-adicionales').append(nuevoFormulario);
                $('.formulario-adicional .select2').select2();
            }

            $(document).on('click', '.eliminar-formulario', function() {
                $(this).closest('.formulario-adicional').remove();
            });

            $('#agregar-formulario').click(function() {
                agregarFormulario();
            });
        });
    </script>
@endsection
