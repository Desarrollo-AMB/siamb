@extends('layouts.user_type.auth')
@section('title', 'Cargar Nomina')
@section('style')

@endsection
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success mx-4" role="alert">
    <span class="text-white">{{ $message }}</span>
</div>
@endif
@if ($message = Session::get('danger'))
<div class="alert alert-danger mx-4" role="alert">
    <span class="text-white">{{ $message }}</span>
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Partes</h5>
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
              
                    <div class="card mb-8 mx-auto bg-success text-dark" id="loading-dialog" style="width: 200px; display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
                        <div class="card-body text-center">
                            <div class="spinner-border text-dark" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2">Cargando...</p>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <div class="card-body">
                            <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reporte"
                                                        id="flexRadioDefault1" checked="checked" value="1">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Cargar Nomina
                                                    </label>
                                                </div>
                                               
                                            </div>
                                            <div class="col-lg-8 col-sm-6">
                                                <div id="Parametros1" class="parametros ">
                                                    <form id="form-import" action="{{route('carga.ArchivoExcel')}}" method="POST"
                                                    enctype="multipart/form-data">
                                                        @csrf
                                                        <input class="btn btn-secondary btn-sm mb-0" type="file"
                                                            name="archivo_excel">
                                                       
                                                        <h6 class="col-sm-3 col-form-label">Concepto</h6>
                                                        <div class="col-sm-9">
                                                            <select class="select2 form-control"
                                                                name="parametros[codigo_ubicacion]"
                                                                id="codigo_ubicacion">
                                                                <option value="">SELECCIONE...</option>
                                                                @foreach ($conceptoNominas as $row)
                                                                <option value="{{ $row->codigo_concepto}}">
                                                                    {{ $row->descripcion }}-({{ $row->codigo_concepto}})
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                        </div>
                                                        <div class="row">
                                                            <h6 class="col-sm-3 col-form-label">Tipo de Pago:</h6>
                                                            <div>
                                                                <div class="col-sm-9">
                                                                    <select class="select2 form-control"
                                                                        name="tipo_nomina"
                                                                        id="tipo_nomina">
                                                                        <option value="">SELECCIONE...</option>
                                                                        <option value="20">
                                                                          Personal Militar Profesional-(20) </option>
                                                                         <option value="17"> Personal Militar No Profesional-(17) </option>
                                                                         <option value="23"> Personal Alistado-(23) </option>
                                                                         <option value="EC"> Personal no Militar -(EC) </option>
                                                                    </select>
                                                                </div>   
                                                                <div class="row">
                                                                    <h6 class="col-sm-3 col-form-label">Fecha de Pago:</h6>
                                                                    <div>
                                                                <input type="date" class="form-control @error('fecha')
                                                                    is-invalid @enderror" name="fecha" value="">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <button class="btn btn-primary" type="button" onclick="confirmImport()">Importar Excel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reporte"
                                                        id="flexRadioDefault2" value="3">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        Otro
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <div id="Parametros3" class="parametros" style="display: none;">
                                                    <form action="" method="POST" class="row">
                                                        @csrf
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <h6 class="col-sm-3 col-form-label">Filtro:</h6>
                                                                <div class="col-sm-9">
                                                                    <select name="parametros[filtroBajas]"
                                                                        id="filtro_bajas" class="select2 form-control"
                                                                        disabled="disabled">
                                                                        <option value="">SELECCIONE...</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

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
    $(function() {
            $('.select2').select2();
            $("input[name$='reporte']").click(function() {
                var test = $(this).val();

                $("div.parametros").hide();
                $("div.parametros *").attr("disabled", true);
                //$("div.parametros").prop('disabled', 'disabled');
                $("#Parametros" + test).show();
                $("#Parametros" + test + ' *').prop("disabled", false);
            });
            $("#formDevolucion5").validate({
                rules: {
                    cedula: {
                        required: true,
                        minlength: 8
                    },
                },
                messages: {
                    cedula: "El parametro es obligatorio.",

                }
            });
        });
</script>
<script>
     function confirmImport() {
        if (confirm('¿Estás seguro de que deseas importar el archivo Excel?')) {
            mostrarCargando();
        }
    }

    function mostrarCargando() {
        document.getElementById('loading-dialog').style.display = 'block';
        document.getElementById('form-import').submit();
    }
    </script>
@endsection