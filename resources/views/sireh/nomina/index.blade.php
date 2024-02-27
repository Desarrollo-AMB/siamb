@extends('layouts.user_type.auth')
@section('title', 'Personal')
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
                            <h5 class="mb-0">NOMINA</h5>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                @include('sireh.nomina._barra_auxiliar')
                <hr class="horizontal dark my-0">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0 mb-2">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <hr class="horizontal dark my-0">
                                    <div class="card" style="width: 30rem;">
                                        <img src="{{ asset('imagenes/gastos.JPEG') }}" alt="mi foto">
                                        <div class="card-body">
                                            <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="center" colspan="2"> <center>  <h5>Salario Minimo Nacional</h5> </center> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    
                                                   
                                                    
                                                    <tr>
                                                        <th> <h6>Salario Minimo Nacional </h6></th>
                                                        <td><h6>{{ $conceptos[1]}} Bs.</h6></td>
                                                    </tr>
                                                    <tr>
                                                        <th><h6>Cesta Ticket</h6></th>
                                                        <td><h6>{{$conceptos[2]}} Bs.</h6> </td>
                                                    </tr>              
                                                </tbody>
                                            </table>
                                    
                                        </div>
                                    </div>
                                    
                                    <hr class="horizontal dark my-0">
                                </div>
                                <div class="card-body">

                                    <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                        @csrf
                                        <thead>
                                            <tr>
                                                <th scope="col" class="center" colspan="2">
                                                    <center>
                                                        <h5>Primas del personal militar</h5>
                                                    </center>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <h6>Prima Fronteriza tipo "A" </h6>
                                                </th>
                                                <td>
                                                    <h6>{{ $conceptos[53]}} %</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <h6>Prima Fronteriza tipo "B"</h6>
                                                </th>
                                                <td>
                                                    <h6>{{ $conceptos[55]}} %</h6>
                                                </td>
                                            </tr>
                                             <tr>
                                                <th>
                                                    <h6>Prima Fronteriza tipo "C"</h6>
                                                </th>
                                                <td>
                                                    <h6>{{ $conceptos[54]}} %</h6>
                                                </td>
                                            </tr> 
                                         </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

    
@endsection
