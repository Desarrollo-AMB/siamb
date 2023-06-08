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
    <div class="col-11">
        <div class="card mb-4 mx-4 ">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-5">Personal Militar No Profesional</h5>
                    </div>
                </div>
                <hr class="horizontal dark my-0 mb-4">
            </div> 
            
            <div class="row justify-content-center">
                <div class="col-xl-4 col-sm-6 mb-xl-6 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('sireh.nomina.noProf.excelprocess')}}"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Expulsar Excel Tropa Alistada
                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#67a1ec,#2463eb)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fas fa-cloud-download-alt" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-6 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('sireh.nomina.noProf.excelprocessMEF')}}"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Expulsar Excel Militar en Formación
                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#67a1ec,#2463eb)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fas fa-cloud-download-alt" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('sireh.nomina.noProf.sueldosNoProf')}}"> 
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                        Sueldo Por Jerarquía
                                    </p> 
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#7ae4ff,#00d9ff)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fas fa-portrait" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                    <div class="card-body p-3">
                        <a href="{{ route('sireh.nomina.noProf')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                    <p class="font-weight-bolder mb-0">
                                    Primas
                                    </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div style="background-image:linear-gradient(310deg,#3a9c9b,#087904)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <a href="{{ route('sireh.nomina.noprof.deducciones')}}">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold"></p>
                                            <p class="font-weight-bolder mb-0">
                                            Deducciones
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div style="background-image:linear-gradient(310deg,#ff7070,#fa0808)" class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                            <i class="fas fa-minus" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            {{-- saltos de linea para dar mas espacio --}}
                <div>
                    <br><br><br>
                </div>
            </div>
            
        </div>
    </div>
</div>

</script>
@endsection