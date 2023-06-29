@extends('layouts.user_type.auth')

@section('content')
@if (session()->has('success'))
    <div id="success-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div id="error-message" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="row">
    <div class="col-8">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">PRIMAS ASIGNADAS A  {{$empleado_nombre}} {{$empleado_apellido}}</h5>
                    </div>
                    <!-- boton para crear una nueva prima -->
                    <a class="btn btn-bg-gradient-primary btn-sm mb-0" href="{{ route('sireh.nomina.asignacionprima') }}">+&nbsp;Agregar Nueva Prima</a>
                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2"> 
                <div class="table-responsive p-0">
                    <table id="table" class="table align-items-center mb-0" data-order='[[0, "asc"]]'>
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código de prima</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" data-sortable="false">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($count = 1)
                            @foreach ($asignaciones as $key => $user)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{$user->conceptoNomina->descripcion}}</td>
                                <td class="text-center">
                                    <a href="#" class="confirmar-delete" form-target="delete-form-{{  $user->id }}"
                                        title="Eliminar" onclick="event.preventDefault();" >
                                        <i class="cursor-pointer fas fa-trash text-danger" aria-hidden="true"></i>
                                    </a>
                                    <form id="delete-form-{{  $user->id }}" action="{{ route('sireh.nomina.primas.deleteprima',  $user->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
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
    setTimeout(function() {
        var successMessage = document.getElementById("success-message");
        if (successMessage) {
            successMessage.style.display = "none";
        }

        var errorMessage = document.getElementById("error-message");
        if (errorMessage) {
            errorMessage.style.display = "none";
        }
    }, 2000); // 5000 milisegundos = 5 segundos
</script>
<script>
    $(function (){
        $('.select2').select2();


    });
</script>

<script>
    jQuery(document).ready(function() {
        jQuery('.codigo_profesion').keypress(function(tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });
    });
</script>
@endsection
