@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
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
<div class="row">
    
    <div class="col-10">
        <div class="card mb-4 mx-4">
             
            <br>
            <a class="btn btn-secondary btn-sm mb-0" style="position: absolute; top: 10px; right: 10px; font-size: 12px; padding: 7px 30px;" href="{{ route('sireh.nomina.index') }}">Volver</a>
            <div class="d-flex flex-row">
                
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Editar Sueldo Base</h5>
                        </div>
                    </div>
                    <hr class="horizontal dark my-0">
                    <div class="card-body px-2 pt-2 pb-2">
                        {!! Form::open(array('route' => 'sireh.nomina.updateSueldo','method'=>'POST')) !!}
                        <div class="row">
                            {{--<div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Nombre:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Nombre','class' => 'form-control')) !!}
                                </div>
                            </div>--}}
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Codigo del Sueldo Base:</strong>
                                    {!! Form::text('codigo_concepto', $data[1]['codigo_concepto'], array('placeholder' => $data[1]['codigo_concepto'],'class' => 'form-control','disabled' => 'disabled')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Descripción del Sueldo Base:</strong>
                                    {!! Form::text('descripcion', $data[1]['descripcion'], array('placeholder' => $data[1]['descripcion'],'class' => 'form-control','nullable' => true)) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Monto del Sueldo Base:</strong>
                                    {!! Form::number('porcentaje',$data[1]['porcentaje'], array('placeholder' => $data[1]['porcentaje'],'class' => 'form-control','step'=>"any",'nullable' => true)) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::hidden('id', $data[1]['id']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header pb-0 mb-2">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Editar Bono de Alimentación     </h5>
                        </div>
                    </div>
                    <hr class="horizontal dark my-0">
                    <div class="card-body px-2 pt-2 pb-2">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Codigo del Bono de Alimentación:</strong>
                                    {!! Form::text('codigo_conceptoali', $data[0]['codigo_concepto'], array('placeholder' => $data[0]['codigo_concepto'],'class' => 'form-control','disabled' => 'disabled')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Descripción del Bono de Alimentación:</strong>
                                    {!! Form::text('descripcionali', $data[0]['descripcion'], array('placeholder' => $data[0]['descripcion'],'class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Monto del Bono de Alimentación:</strong>
                                    {!! Form::number('porcentajeali',$data[0]['porcentaje'], array('placeholder' => $data[0]['porcentaje'],'class' => 'form-control','step'=>"any")) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    {!! Form::hidden('idali', $data[0]['id']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary w-30">Actualizar</button>
                </div>
        </div>
        {!! Form::close() !!}
        
        
    </div>
    
</div>
@endsection

@section('scripts')
@parent
<script>
    $(function () {
        $('#roles').select2({
                allowClear: true,
                minimumResultsForSearch: -1,
                width: 300
             });
        });
</script>
@endsection
