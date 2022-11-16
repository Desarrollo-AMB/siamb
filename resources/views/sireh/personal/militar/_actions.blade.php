
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

    <a href="#" class="mx-3 suspender_militar" data-bs-toggle="tooltip"
        data-bs-original-title="Suspender" title="Suspender" data-id="{{ $id }}">
        <i class="fas fa-sync text-primary" aria-hidden="true"></i>
    </a>

    <a href="{{ route('sireh.personal-militar.baja', $id) }}" class="mx-3"  data-bs-toggle="tooltip"
        data-bs-original-title="Baja" title="Baja"
    >
        <i class="fas fa-backspace text-danger"></i>
    </a>

    <a href="{{ route('sireh.carga-familiar.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Carga Familiar" title="Carga Familiar"
    >
        <i class="fas fa-users text-warning" aria-hidden="true"></i>
    </a>
    
    <a href="{{ route('sireh.condecoraciones.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Condecoraciones" title="Condecoraciones"
    >
        <i class="fas fa-medal text-secondary" aria-hidden="true"></i>
    </a>

    <a href="#" class="mx-3 funcion_empleado" data-bs-toggle="tooltip"
        data-bs-original-title="Funcion del Empleado" title="Funcion del Empleado" data-id="{{ $codigo_empleado }}">
        <i class="fas fa-users-cog text-info" aria-hidden="true"></i>
    </a>
