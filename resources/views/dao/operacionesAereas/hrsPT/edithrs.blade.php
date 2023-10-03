@extends('layouts.user_type.auth')
@section('title', 'horas de vuelo')
@section('content')

<style>
    /* Estilos para los botones */
    .botones-absolute {
        position: absolute;
        bottom: 10px;
        left: 250px;
        right: 50px;
    }
</style>
@if ($message = Session::get('success'))
<div class="alert alert-success mx-4" role="alert">
    <span class="text-white">{{ $message }}</span>
</div>
@endif
@php
if ($datos->fecha_nacim != "") {
$fecha_nacim = date("d/m/Y", strtotime($datos->fecha_nacim));
}
else {
$fecha_nacim = "";
}

if ($datos->datos_militares->fecha_graduacion != "") {
$fecha_graduacion = date("d/m/Y", strtotime($datos->datos_militares->fecha_graduacion));
}
else {
$fecha_graduacion = "";
}

if ($datos->datos_militares->fecha_ultimo_ascenso != "") {
$fecha_ultimo_ascenso = date("d/m/Y", strtotime($datos->datos_militares->fecha_ultimo_ascenso));
}
else {
$fecha_ultimo_ascenso = "";
}

if ($datos->datos_militares->fecha_retiro != "") {
$fecha_retiro = date("d/m/Y", strtotime($datos->datos_militares->fecha_retiro));
}
else {
$fecha_retiro = "";
}
@endphp
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Carga de horas de vuelo </h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0"
                        href="{{ route('sireh.personal-militar.index') }}">Volver</a>
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

                <!-- FOTO DE PERFIL -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="avatar-wrapper">
                            <img class="profile-pic" src="{{ $datos->foto ? url($datos->foto): '' }}" disabled />

                            <input class="file-upload" type="file" accept="image/*" name="foto" id="foto" disabled />
                        </div>
                    </div>
                </div>

                <!-- DATOS PERSONALES -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                        <div class="card">
                            <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                <h5 class="card-title">Datos Personales</h5>
                            </div>

                            <input type="hidden" class="form-control" name="codigo_empleado"
                                value="{{ $datos->codigo_empleado }}">
                            <input type="hidden" class="form-control" name="id" value="{{ $datos->id }}">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                        <div class="form-group">
                                            <h6>Grado Militar:</h6>
                                            <select class=" form-control" name="grado_militar" id="grado_militar"
                                                disabled>
                                                <option value="">SELECCIONE...</option>
                                                @foreach ($grados_militares as $row)
                                                <option value="{{$row->codigo_grado}}" {{$datos->nomina->grado_militar
                                                    == $row->codigo_grado ? 'selected': '' }}>{{ $row->descripcion }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Cédula:</h6>
                                            <input id="cedula" type="text"
                                                class="form-control soloNumeros @error('cedula') is-invalid @enderror"
                                                name="cedula" value="{{ $datos->cedula }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Primer Nombre:</h6>
                                            {!! Form::text('nombre1', $datos->nombre1, array('placeholder' => 'No Posee
                                            Primer Nombre','class' => 'form-control soloLetras', 'id' =>
                                            'nombre1','disabled')) !!}
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Segundo Nombre:</h6>
                                            {!! Form::text('nombre2', $datos->nombre2, array('placeholder' => 'No Posee
                                            Segundo Nombre','class' => 'form-control soloLetras', 'id' =>
                                            'nombre2','disabled')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Primer Apellido:</h6>
                                            {!! Form::text('apellido1', $datos->apellido1, array('placeholder' => 'No
                                            Posee Primer Apellido','class' => 'form-control soloLetras', 'id' =>
                                            'apellido1','disabled')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Segundo Apellido:</h6>
                                            {!! Form::text('apellido2', $datos->apellido2, array('placeholder' => 'No
                                            Posee Segundo Apellido','class' => 'form-control soloLetras', 'id' =>
                                            'apellido2','disabled')) !!}
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Estado Civil:</h6>
                                            {!! Form::text('fecha_nacim', $datos->edo_civil, array('placeholder' => 'No
                                            Posee Fecha de Nacimiento','class' => 'form-control','disabled')) !!}

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Fecha Nacimiento:</h6>
                                            {!! Form::date('fecha_nacim', $datos->fecha_nacim, array('placeholder' =>
                                            'No Posee Fecha de Nacimiento','class' => 'form-control','disabled')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Telefono:</h6>
                                            {!! Form::text('telefono_cel', $datos->telefono_cel, array('placeholder' =>
                                            'Telefono','class' => 'form-control soloNumeros','disabled')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Telefono Casa:</h6>
                                            {!! Form::text('telefono', $datos->telefono, array('placeholder' =>
                                            'Telefono','class' => 'form-control soloNumeros','disabled')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <h6>Telefono Oficina:</h6>
                                            {!! Form::text('telefono_ofi', $datos->telefono_ofi, array('placeholder' =>
                                            'Telefono','class' => 'form-control soloNumeros','disabled')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                        <div class="form-group">
                                            <h6>Categoria:</h6>
                                            <select class=" form-control" name="categoria" id="categoria">
                                                <option value="">SELECCIONE...</option>
                                                @foreach ($categorias_militares as $row)
                                                @if ($row->tipo_emp == 'MIL' || $row->tipo_emp == 'TRP')
                                                <option value="{{$row->codigo_categoria}}" {{$datos->datos_militares ?
                                                    ($datos->datos_militares->codigo_categoria == $row->codigo_categoria
                                                    ? 'selected': '' ) : ''}}>{{ $row->descripcion }} </option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-2">
                            <div class="card">
                                <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                    <h5 class="card-title">Horas de vuelo</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Formulario original -->
                                    <form class="row g-3 requires-validation militar-form" name="militar" method="post" action="{{ route('dao.personal.hrsVuelo.updatehoras') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="cedula1" value="{{ $datos->cedula }}">
                                        <input type="hidden" name="codigo_empleado1" value="{{ $datos->codigo_empleado }}">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Funcion:</h6>
                                                <select class="select2 form-control funcion" name="funcion">
                                                    <option value="">SELECCIONE...</option>
                                                    @foreach ($funcion as $row)
                                                        <option value="{{ $row->id }}">{{ $row->funcion }} ({{ $row->codigo }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Aeronave:</h6>
                                                <select class="select2 form-control aeronave" name="aeronave">
                                                    <option value="">SELECCIONE...</option>
                                                    @foreach ($aeronaves as $aeronave)
                                                        <option value="{{ $aeronave->id }}">{{ $aeronave->aeronave }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Horas Diurnas:</h6>
                                                <input type="number" name="horasd" class="form-control soloNumeros horasDiurnas">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Horas Nocturnas:</h6>
                                                <input type="number" name="horasn" class="form-control soloNumeros horasNocturnas">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <h6>Total de horas:</h6>
                                                <input type="number" name="total" class="form-control soloNumeros totalHoras" readonly>
                                            </div>
                                        </div>
                                        <div class="botones-absolute">
                                            <button type="button" class="btn btn-secondary btn-duplicar" title="Duplicar">
                                                <i class="fab fa-creative-commons-share fa-lg"></i> 
                                            </button>
                                            <button type="button" class="btn btn-danger btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-actualizar" id="btn-actualizar">Actualizar</button>
                                        </div>
                                    </form>
            
                                    <!-- BOTONES -->
                                    
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
<script>
      $(function (){
        $('.select2').select2();

      
    });
    $(document).ready(function () {
    // Función para calcular la suma y actualizar el tercer input
    function calcularTotalHoras() {
        const formulario = $(this).closest('.militar-form');
        const horasDiurnas = parseInt(formulario.find('.horasDiurnas').val()) || 0;
        const horasNocturnas = parseInt(formulario.find('.horasNocturnas').val()) || 0;
        const totalHoras = horasDiurnas + horasNocturnas;
        formulario.find('.totalHoras').val(totalHoras);
    }
    // Duplicar el formulario
    $('.btn-duplicar').click(function () {
        const form = $('.militar-form:first').clone();

        // Limpia los valores de los campos clonados
        form.find('input.horasDiurnas').val('');
        form.find('input.horasNocturnas').val('');
        form.find('input.totalHoras').val('');

        // Inserta el formulario clonado antes del formulario original
        $('.militar-form:first').before(form);

        // Registra el evento input para los nuevos campos
        form.find('.horasDiurnas, .horasNocturnas').on('input', calcularTotalHoras);
        
        // Habilita el botón de eliminar en el formulario clonado
        form.find('.btn-eliminar').prop('disabled', false);
    });
    // Eliminar el formulario duplicado
    $(document).on('click', '.btn-eliminar', function () {
        const formularios = $('.militar-form');
        if (formularios.length > 1) {
            $(this).closest('.militar-form').remove();
        }
    });
    // Registra el evento input para los campos originales
    $('.horasDiurnas, .horasNocturnas').on('input', calcularTotalHoras);
});



    $(document).ready(function() {
        $('#grado_militar'); // Inicializar el select2

        // Deshabilitar el select
        $('#grado_militar').prop('disabled', true);
    });
    $(document).ready(function() {
        $('#categoria'); // Inicializar el select2

        // Deshabilitar el select
        $('#categoria').prop('disabled', true);
    });

</script>
@endsection