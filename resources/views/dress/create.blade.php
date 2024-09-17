@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success mx-4" role="alert">
    <span class="text-white">{{ $message }}</span>
</div>
@endif
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
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">DRES</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('users.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-form-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-form" role="tab" aria-controls="custom-tabs-form"
                                        aria-selected="false">Reporte RES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="custom-tabs-empleados-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-empleados" role="tab" aria-controls="custom-tabs-empleados"
                                        aria-selected="false">Personal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="custom-tabs-empleados2-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-empleados2" role="tab" aria-controls="custom-tabs-empleados2"
                                        aria-selected="false">Armamento</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="custom-tabs-empleados3-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-empleados3" role="tab" aria-controls="custom-tabs-empleados3"
                                        aria-selected="false">Equipos</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-form" role="tabpanel"
                                    aria-labelledby="custom-tabs-form-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">

                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                    {!! Form::open(array('route' => 'dres.armamento','method'=>'POST',
                                                    'id'=>'reporte')) !!}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="id1">N° Reporte:</label>
                                                                {!! Form::text('n_reporte', null, ['id' => 'id1', 'placeholder' => 'N° Reporte', 'class' => 'form-control', 'oninput' => 'actualizarInputs("id1", this.value)']) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>JRES:</strong>
                                                                <select name="JRES" id="" aria-placeholder='JRES'
                                                                    class="select2 form-control">
                                                                    <option value="">Seleccione ... </option>
                                                                    @foreach ($jres as $item)
                                                                    <option value="{{ $item->unidad }}">{{ $item->unidad
                                                                        }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Fecha de Reporte:</strong>
                                                                {!! Form::date('fechaR', null, array('placeholder' =>
                                                                'Fecha de Reporte','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Grupo fecho hora:</strong>
                                                                {!! Form::text('grupo_fecho_hora', null,
                                                                array('placeholder' => 'Grupo fecho hora','class' =>
                                                                'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Persona que Envia:</strong>
                                                                {!! Form::text('p_envia',null, array('placeholder' =>
                                                                'Persona que Envia','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Unida Involucrada:</strong>
                                                                <select name="unidad" class="select2 form-control"
                                                                    placeholder="Unida Involucrada">
                                                                    @foreach ($ubicaciones as $ubicacion)
                                                                    <option value="{{ $ubicacion['descripcion'] }}">{{
                                                                        $ubicacion['descripcion'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Ubicacion GPS:</strong>
                                                                {!! Form::text('gps', null,array('placeholder' =>
                                                                'Ubicacion GPS','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Cmdt Unidad:</strong>
                                                                {!! Form::text('cmdtU', null,array('placeholder' =>
                                                                'Comandante de Unidad','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Clase de Evento:</strong>
                                                                <select name="clase" class="select2 form-control"
                                                                    id="claseEvento" placeholder="Clase de Evento">
                                                                    <option value="">Seleccione ...</option>
                                                                    @foreach ($tipo_evento as $tipo)
                                                                    <option value="{{ $tipo }}">{{ $tipo }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Tipo de Evento:</strong>
                                                                <select name="tipo" class=" select2 form-control"
                                                                    id="tipoEvento" placeholder="Tipo de Evento"
                                                                    disabled>
                                                                    <!-- opciones cargadas dinámicamente por JavaScript -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong> Evento:</strong>
                                                                <textarea name="event" id="event" class="form-control"
                                                                    cols="30" rows="10"
                                                                    placeholder="Eventos"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong> Descripcion:</strong>
                                                                <textarea name="descripcion" id="descripcion"
                                                                    class="form-control" cols="30" rows="10"
                                                                    placeholder="Descripción"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong> Lugar de Ocurrencia:</strong>
                                                                <textarea name="lugarO" id="lugarO" class="form-control"
                                                                    cols="30" rows="10"
                                                                    placeholder="Lugar de Ocurrencia"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Fecha de Ocurrencia:</strong>
                                                                {!! Form::date('fechaO', null, array('placeholder' =>
                                                                'Fecha de Ocurrencia','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Situacion:</strong>
                                                                {!! Form::text('situacion', null, array('placeholder' =>
                                                                'Situacion','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Documentos Afectados:</strong>
                                                                {!! Form::text('documentos', null, array('placeholder'
                                                                => 'Documentos Afectados','class' => 'form-control'))
                                                                !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="custom-tabs-empleados" role="tabpanel"
                                    aria-labelledby="custom-tabs-empleados-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">
                                                <div class="card-header pb-0 mb-2">
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div>
                                                            <h5 class="mb-0">Personal </h5>
                                                        </div>
                                                        <a class="btn btn-secondary btn-sm mb-0"
                                                            href="{{ route('users.index') }}">Volver</a>
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                    {!! Form::open(array('route' => 'dres.personal','method'=>'POST',
                                                    'id'=>'reporte')) !!}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="id2">N° Reporte:</label>
                                                                {!! Form::text('n_reporte', null, ['id' => 'id2', 'placeholder' => 'N° Reporte', 'class' => 'form-control', 'onclick' => 'actualizarInputDesdeOtro("id1", "id2")']) !!}
                                                            </div>
                                                        </div>
                                                        <div id="formularios-container">
                                                            <!-- Contenedor principal donde se agregarán los formularios -->
                                                            <div class="formulario">
                                                                <!-- Primer formulario (original) -->
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Cédula:</strong>
                                                                        {!! Form::text('cedula[]', null,
                                                                        ['class'=>'cedula form-control',
                                                                        'placeholder'=>'Cédula']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Especialidad:</strong>
                                                                        {!! Form::text('especialidad[]', null,
                                                                        ['placeholder' => 'Categoría', 'class' =>
                                                                        'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Sexo:</strong>
                                                                        {!! Form::text('sexo[]', null,
                                                                        ['placeholder' => 'Categoría', 'class' =>
                                                                        'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Grado:</strong>
                                                                        {!! Form::text('grado[]', null,
                                                                        ['placeholder' => 'Categoría', 'class' =>
                                                                        'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Categoría:</strong>
                                                                        {!! Form::text('categoria[]', null,
                                                                        ['placeholder' => 'Categoría', 'class' =>
                                                                        'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Primer Nombre:</strong>
                                                                        {!! Form::text('nombre1[]', null,
                                                                        ['placeholder' => 'Primer Nombre', 'class'
                                                                        => 'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Segundo Nombre:</strong>
                                                                        {!! Form::text('nombre2[]', null,
                                                                        ['placeholder' => 'Segundo Nombre', 'class'
                                                                        => 'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Primer Apellido:</strong>
                                                                        {!! Form::text('apellido1[]', null,
                                                                        ['placeholder' => 'Primer Apellido', 'class'
                                                                        => 'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Segundo Apellido:</strong>
                                                                        {!! Form::text('apellido2[]', null,
                                                                        ['placeholder' => 'Segundo Apellido',
                                                                        'class' => 'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <strong>Relación:</strong>
                                                                        <textarea name="relacion[]"
                                                                            class="form-control"
                                                                            placeholder="Relación"
                                                                            rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <div class="form-group">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-form">Eliminar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-primary"
                                                                    id="add-form">Agregar Formulario</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="custom-tabs-empleados2" role="tabpanel"
                                    aria-labelledby="custom-tabs-empleados2-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">
                                                <div class="card-header pb-0 mb-2">
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div>
                                                            <h5 class="mb-0">Armamento</h5>
                                                        </div>

                                                    </div>
                                                </div>
                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                    {!! Form::open(array('route' => 'dres.equipo','method'=>'POST',
                                                    'id'=>'reporte')) !!}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="id3">N° Reporte:</label>
                                                                {!! Form::text('n_reporte', null, ['id' => 'id3', 'placeholder' => 'N° Reporte', 'class' => 'form-control', 'onclick' => 'actualizarInputDesdeOtro("id1", "id3")']) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Marca:</strong>
                                                                {!! Form::text('marca', null, array('placeholder' =>
                                                                'Marca','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Modelo:</strong>
                                                                {!! Form::text('modelo', null, array('placeholder' =>
                                                                'Modelo','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Serial:</strong>
                                                                {!! Form::text('serial', null, array('placeholder' =>
                                                                'Serial','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Unidad de Asignacion:</strong>
                                                                {!! Form::text('unidad_a', null,array('placeholder' =>
                                                                'Unidad de Asignacion','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Relacion:</strong>
                                                                <textarea class="form-control"
                                                                   name="relacion" id="exampleFormControlTextarea1"
                                                                    rows="3" placeholder="Relacion"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="custom-tabs-empleados3" role="tabpanel"
                                    aria-labelledby="custom-tabs-empleados3-tab">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="card mb-4 mx-4">
                                                <div class="card-header pb-0 mb-2">
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <div>
                                                            <h5 class="mb-0">Equipo</h5>
                                                        </div>
                                                        <a class="btn btn-secondary btn-sm mb-0"
                                                            href="{{ route('users.index') }}">Volver</a>
                                                    </div>
                                                </div>
                                                <hr class="horizontal dark my-0">
                                                <div class="card-body px-2 pt-2 pb-2">
                                                    {!! Form::open(array('route' => 'dres.material','method'=>'POST',
                                                    'id'=>'equipo')) !!}
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="id4">N° Reporte:</label>
                                                                {!! Form::text('n_reporte', null, ['id' => 'id4', 'placeholder' => 'N° Reporte', 'class' => 'form-control', 'onclick' => 'actualizarInputDesdeOtro("id1", "id4")']) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Tipo:</strong>
                                                                {!! Form::text('tipo', null, array('placeholder' =>
                                                                'Tipo','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Modelo:</strong>
                                                                {!! Form::text('modelo', null, array('placeholder' =>
                                                                'Modelo','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>Siglas o Serial:</strong>
                                                                {!! Form::text('serial',null, array('placeholder' =>
                                                                'Siglas','class' => 'form-control')) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
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
</div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(function() {
    $(document).ready(function() {
    // Inicializa select2 para los selects existentes al cargar la página
    inicializarSelect2();

    // Manejar el cambio en el primer select para cargar opciones en el segundo select
    $('#claseEvento').change(function() {
        // Obtener la clase seleccionada
        var claseSeleccionada = $(this).val();

        // Limpiar las opciones actuales en el segundo select
        $('#tipoEvento').empty().prop('disabled', true);

        // Realizar la solicitud Ajax para obtener los tipos de evento asociados a la clase
        $.ajax({
            url: '{{ route('dres.ruta.evento') }}',  // Reemplaza con la ruta correcta en tu servidor
            type: 'GET',
            data: { clase: claseSeleccionada },
            success: function(data) {
                // Agregar las nuevas opciones al segundo select
                data.forEach(function (evento) {
                    $('#tipoEvento').append('<option value="' + evento.evento + '">' + evento.evento + '</option>');
                });

                // Habilitar el segundo select si hay opciones disponibles
                $('#tipoEvento').prop('disabled', data.length === 0);
            },
            error: function() {
                console.error('Error al obtener los tipos de evento.');
            }
        });
    });
});

// Función para inicializar select2
function inicializarSelect2() {
    $('.select2').select2({
        dropdownAutoWidth: true,
        width: 'auto',
    });
}

// Función para clonar el formulario y reinicializar select2
document.getElementById('add-form').addEventListener('click', function() {
    // Clona el formulario original
    var originalForm = document.querySelector('.formulario');
    var clone = originalForm.cloneNode(true);

    // Limpia los valores de los campos en el clon
    clone.querySelectorAll('input, select, textarea').forEach(function(input) {
        input.value = '';
    });

    // Agrega el formulario clonado al contenedor
    document.getElementById('formularios-container').appendChild(clone);

    // Reinicializa Select2 solo en los selects del formulario clonado
    $(clone).find('.select2').select2({
        dropdownAutoWidth: true,
        width: 'auto',
    });
});

// Evento para manejar el cambio en los selects existentes y clonados
$('#formularios-container').on('change', '.select2', function() {
    // Aquí va el código para manejar el cambio si es necesario
});

// Autocompletar con AJAX
document.getElementById('formularios-container').addEventListener('input', function(event) {
    if (event.target.classList.contains('cedula')) {
        var cedula = event.target.value;
        var formulario = event.target.closest('.formulario');

        fetch('{{ route('dres.datos') }}?cedula=' + encodeURIComponent(cedula))
            .then(response => response.json())
            .then(data => {
                formulario.querySelector('input[name="nombre1[]"]').value = data.nombre1;
                formulario.querySelector('input[name="nombre2[]"]').value = data.nombre2;
                formulario.querySelector('input[name="apellido1[]"]').value = data.apellido1;
                formulario.querySelector('input[name="apellido2[]"]').value = data.apellido2;
                formulario.querySelector('input[name="categoria[]"]').value = data.categoria;
                formulario.querySelector('input[name="grado[]"]').value = data.grado;
                formulario.querySelector('input[name="sexo[]"]').value = data.sexo;
                formulario.querySelector('input[name="especialidad[]"]').value = data.especialidad;
            })
            .catch(error => console.error('Error:', error));
    }
});

// Función para eliminar un formulario
document.getElementById('formularios-container').addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-form')) {
        var formToRemove = event.target.closest('.formulario');
        formToRemove.remove();
    }
});
});



</script>
@endsection