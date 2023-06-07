
    <a href="{{ route('personal.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Ver" title="Ver"
    >
        <i class="fas fa-eye text-info" aria-hidden="true"></i>
    </a>

<a href="{{ route('personl.edit', $id) }}" class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Editar" title="Editar"
>
<i class="fas fa-edit text-primary" aria-hidden="true"></i>
</a>
    <a href="#" class="mx-3 suspender_militar" data-bs-toggle="tooltip"
        data-bs-original-title="Suspender" title="Suspender" data-id="{{ $id }}">
        <i class="fas fa-backspace text-danger" aria-hidden="true"></i>
    </a>
    @can('modificar')
    <a href="#" class="mx-3 funcion_empleado" data-bs-toggle="tooltip"
        data-bs-original-title="Funcion del Empleado" title="Funcion del Empleado" data-id="{{ $codigo_empleado }}">
        <i class="fas fa-users-cog text-info" aria-hidden="true"></i>
    </a>
    @endcan
