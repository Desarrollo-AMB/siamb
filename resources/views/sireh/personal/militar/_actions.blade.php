
    <a href="{{ route('sireh.personal-militar.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Ver" title="Ver"
    >
        <i class="fas fa-eye text-info" aria-hidden="true"></i>
    </a>

    <a href="{{ route('sireh.personal-militar.edit', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar"
    >
        <i class="fas fa-edit text-primary" aria-hidden="true"></i>
    </a>
    
    <a href="{{ route('sireh.personal-militar.cargo', $id) }}" class="mx-3"  data-bs-toggle="tooltip"
        data-bs-original-title="Cargos" title="Cargos"
    >
        <i class="fas fa-briefcase text-success"></i>
    </a>

    <a href="{{ route('sireh.personal-militar.ubicacion', $id) }}" class="mx-3"  data-bs-toggle="tooltip"
        data-bs-original-title="Ubicaciones" title="Ubicaciones"
    >
        <i class="fas fa-globe text-warning"></i>
    </a>

    <a href="#" class="mx-3 suspender" data-bs-toggle="tooltip"
        data-bs-original-title="Suspender" title="Suspender" data-id="{{ $id }}">
        <i class="fas fa-sync text-primary" aria-hidden="true"></i>
    </a>

    <a href="#" class="mx-3 egresar" data-bs-toggle="tooltip"
        data-bs-original-title="Egresar" title="Egresar" data-id="{{ $id }}">
        <i class="fas fa-backspace text-danger" aria-hidden="true"></i>
    </a>

