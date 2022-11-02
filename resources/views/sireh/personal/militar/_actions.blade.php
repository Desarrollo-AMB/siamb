
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
    
    <a href="{{ route('sireh.personal-militar.cargos', $id) }}" class="mx-3"  data-bs-toggle="tooltip"
        data-bs-original-title="Cargos" title="Cargos"
    >
        <i class="fas fa-briefcase text-success"></i>
    </a>
    <a href="{{ route('sireh.personal-militar.ubicaciones', $id) }}" class="mx-3"  data-bs-toggle="tooltip"
        data-bs-original-title="Ubicaciones" title="Ubicaciones"
    >
        <i class="fas fa-globe text-warning"></i>
    </a>
