@extends('layouts.user_type.auth')
@section('title', 'Personal Militar')
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
                            <h5 class="mb-0">Reportes Personal Militar</h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ route('sireh.personal-militar.index') }}">Volver</a>
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
                                    <form action="{{ route('sireh.personal-militar.reportes.ejecutar')}}" method="POST">
                                        @csrf
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault1" checked="checked" value="1">
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                Reporte por Categoria
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-5">
                                                        <div id="Parametros1" class="parametros row">
                                                            <div class="col-8">
                                                                <div class="row">
                                                                    <h6 class="col-sm-5 col-form-label">Categoria:</h6>
                                                                    <select class="select2 form-control" name="parametros[categoria]" id="categoria">
                                                                        <option value="">SELECCIONE...</option>
                                                                        @foreach ($categorias_militares as $row)
                                                                            <option value="{{$row->codigo_categoria}}" >{{ $row->descripcion }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-8">
                                                                <h6 class="col-sm-5 col-form-label">Grado:</h6>
                                                                <select class="select2 form-control" name="parametros1[grados]" id="grados">
                                                                    <option value="00022">Todo los grados</option>
                                                                    @foreach ($grados_militares as $row)
                                                                        <option value="{{$row->codigo_grado}}" >{{ $row->descripcion }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault2" value="2">
                                                            <label class="form-check-label" for="flexRadioDefault2">
                                                                Reporte por Situacion
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div id="Parametros2" class="parametros row" style="display: none;">
                                                            <div class="col-8">
                                                                <h6 class="col-sm-5 col-form-label">Situación:</h6>
                                                                <select name="parametros[situacion]" id="situacion" class="select2 form-control" disabled="disabled">
                                                                    <option value="">SELECCIONE...</option>
                                                                    <option value="A">ACTIVO</option>
                                                                    <option value="S">SUSPENDIDO</option>
                                                                    <option value="E">EGRESADO</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-8">
                                                                <h6 class="col-sm-5 col-form-label">Ubicacion:</h6>
                                                                <select name="parametros1[ubications]" id="ubication" class="select2 form-control" disabled="disabled">
                                                                    <option value="00022">todas las unidades</option>
                                                                    @foreach ( $ubicaciones as $row)
                                                                        <option value="{{$row->codigo_ubicacion}}" >{{ $row->descripcion }}--{{$row->codigo_ubicacion}} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault2" value="3">
                                                            <label class="form-check-label" for="flexRadioDefault2">
                                                                Reporte por Año de graduacion
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6">
                                                        <div id="Parametros3" class="parametros row" style="display: none;">
                                                            <div class="col-8">
                                                                <h6 class="col-sm-5 col-form-label">Situación:</h6>
                                                                <select class="select2 form-control" name="parametros[categoria1]" id="categoria1">
                                                                    <option value="">SELECCIONE...</option>
                                                                    @foreach ($categorias_militares as $row)
                                                                        <option value="{{$row->codigo_categoria}}" >{{ $row->descripcion }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-8">
                                                                <h6 class="col-sm-5 col-form-label">Ubicacion:</h6>
                                                              <input type="date" name="parametros1[fecha_graduacion]" id="fecha_graduacion" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="pt-3 text-center">
                                            <button class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="card-body">
                                <div class="card card-body border card-plain border-radius-lg bg-gray-100">
                                    <form action="{{ route('sireh.personal-militar.reportes.ubi')}}" method="POST">
                                        @csrf
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="reporte" id="flexRadioDefault1" checked="checked" value="1">
                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                Reporte lista por unidad
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-sm-5">
                                                            <div class="col-8">
                                                                <h6 class="col-sm-5 col-form-label">Ubicacion:</h6>
                                                                <select class="select2 form-control" name="ubicacion" id="ubicacion">
                                                                    <option value="">SELECCIONE...</option>
                                                                    @foreach ($ubicaciones as $row)
                                                                        <option value="{{$row->codigo_ubicacion}}" >{{ $row->descripcion }} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="pt-3 text-center">
                                            <button class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection

@section('scripts')
<script>
    $(function (){
        $('.select2').select2();
        $("input[name$='reporte']").click(function() {
            var test = $(this).val();

            $("div.parametros").hide();
            $("div.parametros *").attr("disabled", true);
            $("div.parametros").prop('disabled', 'disabled');
            $("#Parametros" + test).show();
            $("#Parametros" + test+' *').prop("disabled", false);
        });
    });
</script>
@endsection
