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
                        <h5 class="mb-0">Excel de nomina personal militar</h5>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">GRADO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CATEGORIA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CÉDULA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NOMBRES Y APELLIDOS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">UBICACION</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SUELDO BÁSICO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FECHA ULTIMO ASCENSO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AÑOS EN EL GRADO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AÑOS DE SERVICIO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FECHA DE INGRESO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">%AÑOS DE SERVICIO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA DE ANTIGUEDAD (0500)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NRO DE HIJOS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA POR HIJOS (4012)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA RIESGOS TIPO A (4016)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA RIESGOS TIPO B (4017)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA RIESGOS TIPO C (GHP 8%)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FRONTERA TIPO A(0053)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FRONTERA TIPO B(0054)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FRONTERA TIPO C(0055)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PRIMA PROFECIONALIZACION</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">% PROFECIONALIZACION</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ASIGANACION ALIM.ACAD. HUGO CHAVEZ (0088)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TOTAL ASIGNACIONES</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TOTAL PRIMAS COMUNES</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">BONO FIN DE AÑO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SUELDO INTEGRAL</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">6.5% IPSFA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">5% PERSIONES(9404)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DEDUCCION ALIM. ACAD. HUGO CHAVEZ (5141)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CIRCULO MILITAR (9998)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CAJA DE AHORRO 10%(5565)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PENSION ALIMENTACION(5087)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">L.P.H(5003)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TOTAL DE DEDUCCIONES</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DEPOSITO EN BANCO</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($nomina as $item)
                                    <tr>
                                        <td>{{ $item->siglas }}</td>
                                        <td>{{ $item->nombre_categoria }}</td>
                                        <td>{{ $item->cedula }}</td>
                                        <td>{{ $item->nombre1 . ' ' . $item->nombre2 . ' ' . $item->apellido1 . ' ' . $item->apellido2 }}</td>
                                        <td>{{ $item->ubicacion }}</td>
                                        <td>{{ $item->sueldo_grado }}</td>
                                        <td>{{ $item->fecha_ultimo_ascenso }}</td>
                                        <td>{{ $item->antiguedadGrado }}</td>
                                        <td>{{ $item->antiguedad }}</td>
                                        <td>{{ $item->fecha_graduacion }}</td>
                                        <td>{{ $item->porcentaje_concepto }}</td>
                                        <td>{{ $item->monto_prima_antiguedad }}</td>
                                        <td>{{ $item->familiares_count }}</td>
                                        <td> {{ $item->prima_por_hijos }}</td>
                                        <td> {{ $item->prima_riesgo_tipo_a }}</td>
                                        <td> {{ $item->prima_riesgo_tipo_b }}</td>
                                        <td> {{ $item->prima_riesgo_tipo_c }}</td>
                                        <td> {{ $item->prima_frontera_tipo_a }}</td>
                                        <td> {{ $item->prima_frontera_tipo_b }}</td>
                                        <td> {{ $item->prima_frontera_tipo_c }}</td>
                                        <td> {{ $item->monto_prima_prof }}</td>
                                        <td> {{ $item->prima_prof }}</td>
                                        <td> {{ $item->prima_alimentacion_hugo_chavez }}</td>
                                        <td> {{ $item->monto_total }}</td>
                                        <td> {{ $item->monto_total_comunes }}</td>
                                        <td> {{ $item->bono_vacacional }}</td>
                                        <td> {{ $item->sueldo_base }}</td>
                                        <td> {{ $item->deduccion6IPSFA }}</td>
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
