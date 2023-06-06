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
                        <h5 class="mb-0"> NOMINA DE LA TROPA ALISTADA</h5>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">COMPAÑIA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CODIGO_UBICACION</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NOMBRE_UBICACION</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">GRADO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CONTINGENTE</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NACIONALIDAD</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CEDULA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">APELLIDOS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NOMBRES</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SEXO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DIRECCIÓN</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TELEFONO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SUELDO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TIPO_TRABAJADOR</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FECHA_NACIMIENTO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FECHA_INGRESO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CODIGO_NOMINA</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($nomina as $item)
                                    <tr>
                                        <td>{{ $item->codigo_cia_modificado }}</td>
                                        <td>{{ $item->codigo_ubicacion }}</td>
                                        <td>{{ $item->ubicacion }}</td>
                                        <td>{{ $item->siglas }}</td>
                                        <td>{{ $item->ubicacion }}</td>
                                        <td>{{ $item->nacionalidad }}</td>
                                        <td>{{ $item->cedula }}</td>
                                        <td>{{ $item->apellido1 . ' ' . $item->apellido2 }}</td>
                                        <td>{{ $item->nombre1 . ' ' . $item->nombre2 }}</td>
                                        <td>{{ $item->sexo }}</td>
                                        <td>{{ $item->direccion }}</td>
                                        <td>{{ $item->telefono }}</td>
                                        <td>{{ $item->sueldo_grado }}</td>
                                        <td> {{ $item->tipo_emp }}</td>
                                        <td> {{ $item->fecha_nacimiento }}</td>
                                        <td> {{ $item->fecha_ingreso }}</td>
                                        <td> {{ $item->codigo_nomina }}</td>
                                        
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
