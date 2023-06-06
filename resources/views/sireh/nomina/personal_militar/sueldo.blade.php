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
            <a class="btn btn-secondary btn-sm mb-0" style="position: absolute; top: 10px; right: 10px; font-size: 12px; padding: 7px 30px;" href="{{ route('sireh.nomina.militar') }}">Volver</a>
           
              
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
                                    <strong>General en Jefe (1 año):</strong>
                                    {!! Form::text('42', null, array('placeholder' => $salarios->where('codigo_grado', '10')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General en Jefe (3 años):</strong>
                                    {!! Form::text('44', null, array('placeholder' => $salarios->where('codigo_grado', '10')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Mayor General (2 años):</strong>
                                    {!! Form::text('40', null, array('placeholder' => $salarios->where('codigo_grado', '15')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de División (1 año):</strong>
                                    {!! Form::text('34', null, array('placeholder' => $salarios->where('codigo_grado', '20')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de División  (3 años):</strong>
                                    {!! Form::text('36', null, array('placeholder' => $salarios->where('codigo_grado', '20')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de División (5 años):</strong>
                                    {!! Form::text('38', null, array('placeholder' => $salarios->where('codigo_grado', '20')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de Brigada (2 años):</strong>
                                    {!! Form::text('30', null, array('placeholder' => $salarios->where('codigo_grado', '30')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de Brigada (4 años):</strong>
                                    {!! Form::text('32', null, array('placeholder' => $salarios->where('codigo_grado', '30')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Coronel (1 año):</strong>
                                    {!! Form::text('24', null, array('placeholder' => $salarios->where('codigo_grado', '40')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Coronel (3 años):</strong>
                                    {!! Form::text('26', null, array('placeholder' => $salarios->where('codigo_grado', '40')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Coronel (5 años):</strong>
                                    {!! Form::text('28', null, array('placeholder' => $salarios->where('codigo_grado', '40')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Teniente Coronel (2 años):</strong>
                                    {!! Form::text('20', null, array('placeholder' => $salarios->where('codigo_grado', '50')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Teniente Coronel (4 años):</strong>
                                    {!! Form::text('22', null, array('placeholder' => $salarios->where('codigo_grado', '50')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Mayor (1 año):</strong>
                                    {!! Form::text('14', null, array('placeholder' => $salarios->where('codigo_grado', '60')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Mayor (3 años):</strong>
                                    {!! Form::text('16', null, array('placeholder' => $salarios->where('codigo_grado', '60')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Mayor (5 años):</strong>
                                    {!! Form::text('18', null, array('placeholder' => $salarios->where('codigo_grado', '60')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Capitan (2 años):</strong>
                                    {!! Form::text('10', null, array('placeholder' => $salarios->where('codigo_grado', '70')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Capitan (4 años):</strong>
                                    {!! Form::text('12', null, array('placeholder' => $salarios->where('codigo_grado', '70')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Primer Teniente (1 año):</strong>
                                    {!! Form::text('4', null, array('placeholder' => $salarios->where('codigo_grado', '80')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Primer Teniente (3 años):</strong>
                                    {!! Form::text('6', null, array('placeholder' => $salarios->where('codigo_grado', '80')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Primer Teniente (5 años):</strong>
                                    {!! Form::text('8', null, array('placeholder' => $salarios->where('codigo_grado', '80')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Teniente (2 años):</strong>
                                    {!! Form::text('2', null, array('placeholder' => $salarios->where('codigo_grado', '90')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Ayudante (1 año):</strong>
                                    {!! Form::text('68', null, array('placeholder' => $salarios->where('codigo_grado', '420')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Ayudante (3 años):</strong>
                                    {!! Form::text('70', null, array('placeholder' => $salarios->where('codigo_grado', '420')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Ayudante (5 años):</strong>
                                    {!! Form::text('72', null, array('placeholder' => $salarios->where('codigo_grado', '420')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Supervisor (2 años):</strong>
                                    {!! Form::text('74', null, array('placeholder' => $salarios->where('codigo_grado', '410')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Supervisor (4 años):</strong>
                                    {!! Form::text('76', null, array('placeholder' => $salarios->where('codigo_grado', '410')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Primera (1 año):</strong>
                                    {!! Form::text('63', null, array('placeholder' => $salarios->where('codigo_grado', '430')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Primera (3 años):</strong>
                                    {!! Form::text('65', null, array('placeholder' => $salarios->where('codigo_grado', '430')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Primera (5 años):</strong>
                                    {!! Form::text('67', null, array('placeholder' => $salarios->where('codigo_grado', '430')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Segunda (2 años):</strong>
                                    {!! Form::text('59', null, array('placeholder' => $salarios->where('codigo_grado', '440')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Segunda (4 años):</strong>
                                    {!! Form::text('61', null, array('placeholder' => $salarios->where('codigo_grado', '440')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Tercera (1 año):</strong>
                                    {!! Form::text('53', null, array('placeholder' => $salarios->where('codigo_grado', '450')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Tercera (3 años):</strong>
                                    {!! Form::text('55', null, array('placeholder' => $salarios->where('codigo_grado', '450')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Mayor de Tercera (5 años):</strong>
                                    {!! Form::text('57', null, array('placeholder' => $salarios->where('codigo_grado', '450')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Primero (2 años):</strong>
                                    {!! Form::text('49', null, array('placeholder' => $salarios->where('codigo_grado', '460')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Primero (4 años):</strong>
                                    {!! Form::text('51', null, array('placeholder' => $salarios->where('codigo_grado', '460')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Segundo (1 año):</strong>
                                    {!! Form::text('45', null, array('placeholder' => $salarios->where('codigo_grado', '470')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Sargento Segundo (3 años):</strong>
                                    {!! Form::text('47', null, array('placeholder' => $salarios->where('codigo_grado', '470')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                
                            </div>
                         {{-- SEGUNDA COLUMNA--}}
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>General en Jefe (2 años):</strong>
                                    {!! Form::text('43', null, array('placeholder' => $salarios->where('codigo_grado', '10')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Mayor General (1 año):</strong>
                                    {!! Form::text('39', null, array('placeholder' => $salarios->where('codigo_grado', '15')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                               </div>
                               <div class="form-group">
                                <strong>Mayor General (3 años):</strong>
                                {!! Form::text('41', null, array('placeholder' => $salarios->where('codigo_grado', '15')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de División  (2 años):</strong>
                                    {!! Form::text('35', null, array('placeholder' => $salarios->where('codigo_grado', '20')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de División  (4 años):</strong>
                                    {!! Form::text('37', null, array('placeholder' => $salarios->where('codigo_grado', '20')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>General de Brigada (1 año):</strong>
                                    {!! Form::text('29', null, array('placeholder' => $salarios->where('codigo_grado', '30')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>General de Brigada (3 años):</strong>
                                {!! Form::text('31', null, array('placeholder' => $salarios->where('codigo_grado', '30')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>General de Brigada (5 años):</strong>
                                {!! Form::text('33', null, array('placeholder' => $salarios->where('codigo_grado', '30')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Coronel (2 años):</strong>
                                {!! Form::text('25', null, array('placeholder' => $salarios->where('codigo_grado', '40')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Coronel (4 años):</strong>
                                {!! Form::text('27', null, array('placeholder' => $salarios->where('codigo_grado', '40')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Teniente Coronel (1 año):</strong>
                                {!! Form::text('19', null, array('placeholder' => $salarios->where('codigo_grado', '50')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Teniente Coronel (3 año):</strong>
                                {!! Form::text('21', null, array('placeholder' => $salarios->where('codigo_grado', '50')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Teniente Coronel (5 años):</strong>
                                {!! Form::text('23', null, array('placeholder' => $salarios->where('codigo_grado', '50')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Mayor (2 años):</strong>
                                {!! Form::text('15', null, array('placeholder' => $salarios->where('codigo_grado', '60')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Mayor (4 años):</strong>
                                {!! Form::text('17', null, array('placeholder' => $salarios->where('codigo_grado', '60')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Capitan (1 año):</strong>
                                {!! Form::text('9', null, array('placeholder' => $salarios->where('codigo_grado', '70')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Capitan (3 años):</strong>
                                {!! Form::text('11', null, array('placeholder' => $salarios->where('codigo_grado', '70')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Capitan (5 años):</strong>
                                {!! Form::text('13', null, array('placeholder' => $salarios->where('codigo_grado', '70')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Primer Teniente (2 años):</strong>
                                {!! Form::text('5', null, array('placeholder' => $salarios->where('codigo_grado', '80')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Primer Teniente (4 años):</strong>
                                {!! Form::text('7', null, array('placeholder' => $salarios->where('codigo_grado', '80')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Teniente (1 año):</strong>
                                {!! Form::text('1', null, array('placeholder' => $salarios->where('codigo_grado', '90')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Teniente (3 años):</strong>
                                {!! Form::text('3', null, array('placeholder' => $salarios->where('codigo_grado', '90')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Ayudante (2 años):</strong>
                                {!! Form::text('69', null, array('placeholder' => $salarios->where('codigo_grado', '420')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Ayudante (4 años):</strong>
                                {!! Form::text('71', null, array('placeholder' => $salarios->where('codigo_grado', '420')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Supervisor (1 año):</strong>
                                {!! Form::text('73', null, array('placeholder' => $salarios->where('codigo_grado', '410')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Supervisor (3 años):</strong>
                                {!! Form::text('75', null, array('placeholder' => $salarios->where('codigo_grado', '410')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Supervisor (5 años):</strong>
                                {!! Form::text('77', null, array('placeholder' => $salarios->where('codigo_grado', '410')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Mayor de Primera (2 años):</strong>
                                {!! Form::text('64', null, array('placeholder' => $salarios->where('codigo_grado', '430')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Mayor de Primera (4 años):</strong>
                                {!! Form::text('66', null, array('placeholder' => $salarios->where('codigo_grado', '430')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Mayor de Segunda (1 año):</strong>
                                {!! Form::text('58', null, array('placeholder' => $salarios->where('codigo_grado', '440')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Mayor de Segunda (3 años):</strong>
                                {!! Form::text('60', null, array('placeholder' => $salarios->where('codigo_grado', '440')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Mayor de Segunda (5 años):</strong>
                                {!! Form::text('62', null, array('placeholder' => $salarios->where('codigo_grado', '440')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Mayor de Tercera (2 años):</strong>
                                {!! Form::text('54', null, array('placeholder' => $salarios->where('codigo_grado', '450')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento Mayor de Tercera (4 años):</strong>
                                {!! Form::text('56', null, array('placeholder' => $salarios->where('codigo_grado', '450')->where('antiguedad', 4)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento  Primero (1 año):</strong>
                                {!! Form::text('48', null, array('placeholder' => $salarios->where('codigo_grado', '460')->where('antiguedad', 1)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong> Sargento Primero (3 años):</strong>
                                {!! Form::text('50', null, array('placeholder' => $salarios->where('codigo_grado', '460')->where('antiguedad', 3)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Sargento  Primero (5 años):</strong>
                                {!! Form::text('52', null, array('placeholder' => $salarios->where('codigo_grado', '460')->where('antiguedad', 5)->first()->porcentaje, 'class' => 'form-control')) !!}
                            </div>
                            
                            <div class="form-group">
                                <strong>Sargento  Segundo (2 años):</strong>
                                {!! Form::text('46', null, array('placeholder' => $salarios->where('codigo_grado', '470')->where('antiguedad', 2)->first()->porcentaje, 'class' => 'form-control')) !!}
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
