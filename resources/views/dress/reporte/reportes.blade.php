@extends('layouts.user_type.auth')
@section('title', 'Personal Militar No Profesional')
@section('style')
<style>

</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Reportes </h5>
                        </div>
                        <a class="btn btn-secondary btn-sm mb-0" href="{{ URL::previous() }}">Volver</a>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                @if ($message = Session::get('error'))
                    <div class="alert alert-secondary mx-4" role="alert">
                        <span class="text-white">{{ $message }}</span>
                    </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success mx-4" role="alert">
                    <span class="text-white">{{ $message }}</span>
                </div>
                @endif
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
                                    <form action="{{ route('dres.reporte')}}" method="POST" class="row">
                                        @csrf
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="" id="" checked="checked" value="">
                                                    <label class="form-check-label" for="">
                                                        Reporte Dres por Fecha
                                                    </label>
                                                </div>

                                                <div id="" class=" row">
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="row">
                                                                <h6 class="col-sm-4 col-form-label">Fecha de desde:</h6>
                                                                <div class="col-sm-8">
                                                               <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="row">
                                                                <h6 class="col-sm-4 col-form-label">Fecha de hasta:</h6>
                                                                <div class="col-sm-8">
                                                               <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--<div class="col-md-6 col-sm-12">
                                                            <div class="row">
                                                                <h6 class="col-sm-3 col-form-label">Jerarquia:</h6>
                                                                <div class="col-sm-9">
                                                                    <select class="select2 form-control" name="grado_militar" id="grado_militar">
                                                                        <option value="0">Todas las Jerarquias...</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-sm-12">
                                                            <div class="row">
                                                                <h6 class="col-sm-3 col-form-label">Ubicacion:</h6>
                                                                <div class="col-sm-9">
                                                                    <select class="select2 form-control" name="ubicacion" id="ubicacion">
                                                                        <option value="0">Todas las Ubicaciones</option>
                                                                        @foreach ($ubicaciones as $row)
                                                                            <option value="{{$row->codigo_ubicacion}}" >{{$row->codigo_ubicacion}} - {{ $row->descripcion }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>--}}
                                                        <div class="col-md-3 col-sm-12">
                                                            <button class="btn btn-primary btn-sm mb-0 ">Ejecutar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
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
