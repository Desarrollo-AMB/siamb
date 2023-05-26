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
                                                            Auditoria de Parte por fecha
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="col-lg-8 col-sm-6">
                                                    <div id="Parametros1" class="parametros ">
                                                        <form id="formDevolucion5"
                                                            action="{{ route('sireh.personal.militar.parte.auditoria') }}"
                                                            method="POST" class="row" >
                                                            @csrf
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <h6 class="col-sm-3 col-form-label">Fecha:</h6>
                                                                    <div class="col-sm-9">
                                                                        <input id="fecha" type="date"
                                                                            class="form-control @error('fecha') is-invalid @enderror"
                                                                            name="fecha" value="">
                                                                        <br>
                                                                   </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <button
                                                                    class="btn btn-primary btn-sm mb-1">Ejecutar</button>
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
@endsection
