
    <a href="{{ route('sireh.personal-militar-noprof.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Ver" title="Ver"
    >
        <i class="fas fa-eye text-info" aria-hidden="true"></i>
    </a>
    <a href="{{-- route('sireh.personal-militar-noprof.edit', $id) --}}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar"
    >
        <i class="fas fa-edit text-primary" aria-hidden="true"></i>
    </a>
    
    <a href="#" class="mx-3"  data-bs-toggle="tooltip"
        data-bs-original-title="Egresar" title="Egresar"
        data-target="{{-- route('', $id) --}}"
    >
        <i class="fas fa-share text-success"></i>
    </a>

    <a href="#" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Reingresar"  title="Reingresar"
        data-target="{{-- route('', $id) --}}"
    >
        <i class="fas fa-sync text-danger"></i>
    </a>
