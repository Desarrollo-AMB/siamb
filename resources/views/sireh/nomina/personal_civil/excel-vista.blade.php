@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
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
                        <h5 class="mb-0">Excel del Personal Obrero</h5>
                    </div>
                    <!-- boton para crear una nueva prima -->
                    <a class="btn btn-bg-gradient-primary btn-sm mb-0" href="{{ route('sireh.nomina.asignacionprima') }}">+&nbsp;Consultar profesional</a>
                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table id="table" class="table align-items-center mb-0" data-order='[[0, "asc"]]'>
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NRO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CÉDULA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NOMBRES Y APELLIDOS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TIPO DE PUESTO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">GRADO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PUESTO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PROF. X DIRECTIVA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FECHA DE INGRESO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FECHA DE CALCULO DE ANTIGUEDAD</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ANTIGUEDAD AVIACIÓN</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ANTIGUEDAD ADMON, PUBLICA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TOTAL AÑOS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SUELDO BASICO (0003)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ANTIGUEDAD (0500)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA PROF (0545,0544,0539)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA PROF TSU (0106)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA HIJO (4000)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA HIJO ESTUDIANDO (4015)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA HIJO COND. ESPECIAL (4014)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">REMUNERACIÓN MENSUAL</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S.S.O(5001)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S.P.F(5002)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">L.P.H(5003)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FJU(5004)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AHORRO CAFUCAMIDE (5103)</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($nomina as $item)
                                    <tr>
                                        <td>{{ $item->nro }}</td>
                                        <td>{{ $item->cedula }}</td>
                                        <td>{{ $item->nombre1 . ' ' . $item->nombre2 . ' ' . $item->apellido1 . ' ' . $item->apellido2 }}</td>
                                        <td>{{ 'por consultar'}}</td>
                                        <td>{{ $item->grado }}</td>
                                        <td>{{ $item->nombre_cargo }}</td>
                                        <td>{{ 'por consultar' }}</td>
                                        <td>{{ $item->fecha_ingreso }}</td>
                                        <td>{{ $item->fechadeldia }}</td>
                                        <td>{{ $item->calculo_antiguedad }}</td>
                                        <td>{{ $item->antiguedad_admon_publica  }}</td>
                                        <td>{{ $item->total_antiguedad }}</td>
                                        <td> {{ $item->sueldo_obrero }}</td>
                                        <td> {{ $item->prima_antiguedad }}</td>
                                        <td> {{ $item->monto_prima_profesionalizacion }}</td>
                                        <td> {{ $item->monto_prima_tsu }}</td>
                                        <td> {{ $item->resultado_hijos }}</td>
                                        <td> {{ $item->resultado_hijos_Estudiando }}</td>
                                        <td> {{ $item->resultado_hijos_especiales }}</td>
                                        <td> {{ 'por consultar'  }}</td>
                                        <td> {{ $item->montoSSO }}</td>
                                        <td> {{ $item->montoSPF }}</td>
                                        <td> {{ $item->montoLPH }}</td>
                                        <td> {{ $item->montoFJU }}</td>
                                        <td> {{ $item->montoCafucamide }}</td>
                                        <td> {{ $item->datacargo }}</td>
                                        <td> {{ $item->datagrado }}</td>
                                        <td> {{ $item->pensiones }}</td>
                                        <td> {{ $item->alimentacion_hugochavez }}</td>
                                        <td> {{ $item->circulomilitar }}</td>
                                        <td> {{ $item->caja_ahorro }}</td>
                                        <td> {{ $item->pension_alimentacion }}</td>
                                        <td> {{ $item->l_p_h }}</td>
                                        <td> {{ $item->total_deducciones}}</td>
                                        <td> {{ $item->deposito_en_banco }}</td>

                                    </tr>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    {{--!! $data->render() !!--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function (){
        var table = $('#table').DataTable({
            responsive: true,
            pageLength: 25,
            "language": {
                "sProcessing":    "Procesando...",
                "sLengthMenu":    "Mostrar _MENU_ registros",
                "sZeroRecords":   "No se encontraron resultados",
                "sEmptyTable":    "Ningún dato disponible en esta tabla",
                "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sSearch":        "Buscar:",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        $('#table').on('click', '.confirmar-delete', function (event) {
            event.preventDefault();
            var idForm= $(this).attr('form-target');
            Swal.fire({
                title: 'Estas Seguro de Eliminar?',
                text: "No podrás revertir esto.!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#'+idForm).submit();
                    Swal.fire({
                        title: 'Eliminado!',
                        text: 'La prima ha sido eliminada con exito.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: true,
                    }); 
                }
            });
        });
    });
</script>
@endsection
