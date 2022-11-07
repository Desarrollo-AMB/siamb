
    <a href="{{ route('sireh.personal-civil.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Ver" title="Ver"
    >
        <i class="fas fa-eye text-info" aria-hidden="true"></i>
    </a>
    <a href="{{-- route('sireh.personal-militar-noprof.edit', $id) --}}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar"
    >
        <i class="fas fa-edit text-primary" aria-hidden="true"></i>
    </a>
    
    <a href="{{ route('sireh.carga-familiar.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Carga Familiar" title="CargaFamiliar"
    >
        <i class="fas fa-users text-primary" aria-hidden="true"></i>
    </a