@extends('layouts.user_type.auth')
@section('title', 'Parte')
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
                            <h5 class="mb-0">Parte General</h5>
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark my-0">
                @include('sireh.personal.militar.parte._barra_auxiliar')
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card_responsive">
                    <div class="d-flex flex-row justify-content-between">
                        <div class="card" style="width: 30rem;">
                            <img src="{{ asset('imagenes/images.JPG') }}" alt="mi foto">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="center" colspan="2">Parte General</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <th>Personal</th>

                                            <td>{{ $nomina_count }}</td>
                                            </tr>
                                            @foreach ($parte_generales as $parte_general)
                                            <tr>
                                                <th>Presente</th>
                                                <td>{{ $parte_general->totalq }}</td>
                                            </tr>
                                            <tr>
                                                <th>faltan</th>
                                                <td>{{ $ausentes_count }}</td>
                                            </tr>
                                            <tr>
                                                <th>Servicio en la Unidad</th>
                                                <td>{{ $parte_general->total3 }}</td>
                                            </tr>
                                            <tr>
                                                <th>Servicio feura de la unidad</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Retardado</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Permiso</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Comisión País</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Comisíon Exterior</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Curso País</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Curso Exterior</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Ausente sin Causa Justificada</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Destacado fuera de la Unidad</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Consulta</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Reposo</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Hospiatalizado</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Desertor</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Privado de Libertad</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>
                                            <tr>
                                                <th>Otro</th>
                                                <td>{{ $parte_general->total2}}</td>
                                            </tr>

                                            @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div  class="card" >
                            <div  class="card-body">
                                <div class="table_responsive">
                                   <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="center" colspan="8">Parte por categoira</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($categorias as $categoria)
                                            <tr>
                                                <th>Oficial Efectivo Comando</th>
                                                    <td>{{ $categoria->comando }}</td>
                                            </tr>
                                            <tr>
                                                <th>Oficial Efectivo Tecnico</th>
                                                    <td>{{ $categoria->tecnico }}</td>
                                            </tr>
                                            <tr>
                                                <th>Efectivo Comado de tropa</th>
                                                <td>{{ $categoria->tropacmd }}</td>
                                            </tr>
                                            <tr>
                                                <th>Oficial Asimilado Tecnico</th>
                                                <td>{{ $categoria->asimiladotc }}</td>
                                            </tr>
                                            <tr>
                                                <th>Oficial Asimilado</th>
                                                <td>{{ $categoria->asimilado }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tropa Profesional</th>
                                                <td>{{ $categoria->trp }}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                    </thead>
                                </table>
                                <table class="table table-sm table-bordered table-hover w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="center" colspan="4">Parte por Grado</th>
                                        </tr>
                                        <tr>
                                            <th>Grado</th>
                                            <th>CDO.</th>
                                            <th>CDO.TRP</th>
                                            <th>TECN</th>
                                            <th>ASIM</th>
                                            <th>AS TEC</th>
                                            <th>TRP</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categorias as $categoria)
                                        <tr>
                                            <th>G/J</th>
                                                <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>M/J</th>

                                                <td>{{ $categoria->tecnico }}</td>
                                                <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>G/D</th>
                                            <td>{{ $categoria->tropacmd }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>G/B</th>
                                            <td>{{ $categoria->asimiladotc }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>CNEL </th>
                                            <td>{{ $categoria->asimilado }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>TCNEL</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>MAY</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>CAP</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>PTTE</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>TTE</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>S/S</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>S/A</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>SM/1ERA</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>SM/2DA</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>SM/3RA</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>S/1ERO</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>S/2DO</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        <tr>
                                            <th>TOTAL</th>
                                            <td>{{ $categoria->trp }}</td>
                                            <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                                 <td>{{ $categoria->comando }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
