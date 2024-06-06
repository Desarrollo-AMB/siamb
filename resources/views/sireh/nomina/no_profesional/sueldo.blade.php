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
            <a class="btn btn-secondary btn-sm mb-0" style="position: absolute; top: 10px; right: 10px; font-size: 12px; padding: 7px 30px;" href="{{ route('sireh.nomina.no_profesional') }}">Volver</a>
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar porcentaje de la Racion por jerarquia</h5>
                    </div>
                </div>
                <hr class="horizontal dark my-4"> 
                <div class="card-body px-2 pt-2 pb-2">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                           
                            <div class="form-group">
                                <strong>SOLDADO RASO:</strong>
                                {!! Form::text('122', null, array('placeholder' => $salarios->where('codigo_grado', '540')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CABO SEGUNDO:</strong>
                                {!! Form::text('113', null, array('placeholder' => $salarios->where('codigo_grado', '520')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                          
                            
                        </div>
                     {{-- SEGUNDA COLUMNA--}}
                        <div class="col-xs-12 col-sm-6 col-md-6">

                            <div class="form-group">
                                <strong>SOLDADO DISTINGUIDO:</strong>
                                {!! Form::text('111', null, array('placeholder' => $salarios->where('codigo_grado', '530')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CABO PRIMERO:</strong>
                                {!! Form::text('115', null, array('placeholder' => $salarios->where('codigo_grado', '510')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                        
                         </div>
                
                    </div>
            
        </div>
            </div>
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar porcentaje de sueldo por grado</h5>
                    </div>
                    
                </div>
                <hr class="horizontal dark my-4">
                <div class="card-body px-2 pt-2 pb-2">
                    {!! Form::open(array('route' => 'sireh.nomina.editSueldosMil','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>ALFEREZ MAYOR DE 6TO AÑO</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>ALFEREZ AUXILIAR DE 6TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>ALFEREZ DE 6TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CADETE DE 6TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>ALFEREZ MAYOR DE 4TO AÑO:</strong>
                                {!! Form::text('123', null, array('placeholder' => $salarios->where('codigo_grado', '200')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>ALFEREZ AUXILIAR DE 4TO AÑO:</strong>
                                {!! Form::text('136', null, array('placeholder' => $salarios->where('codigo_grado', '201')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>ALFEREZ DE 4TO AÑO :</strong>
                                {!! Form::text('137', null, array('placeholder' => $salarios->where('codigo_grado', '202')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CADETE DE 4TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>DISTINGUIDO DE 2DO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CADETE DE 2DO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>ASPIRANTES A OFICIAL:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>

                        
                            
                        </div>
                     {{-- SEGUNDA COLUMNA--}}
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>ALFEREZ MAYOR DE 5TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>     <div class="form-group">
                                <strong>ALFEREZ AUXILIAR DE 5TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>ALFEREZ 5TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CADETE DE 5TO AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>BRIGADIER MAYOR:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>PRIMER BRIGADIER:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div> <div class="form-group">
                                <strong>SEGUNDO BRIGADIER:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>BRIGADIER:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CADETE DE 3CER AÑO :</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>DISTINGUIDO DE 1MER AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>CADETE DE 1MER AÑO:</strong>
                                {!! Form::text('125', null, array('placeholder' => $salarios->where('codigo_grado', '215')->first()->porcentaje, 'class' => 'form-control')) !!}
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
