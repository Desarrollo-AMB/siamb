
    <a href="{{ route('sireh.personal-militar-noprof.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Ver" title="Ver"
    >
        <i class="fas fa-eye text-info" aria-hidden="true"></i>
    </a>
    <a href="{{ route('sireh.personal-militar-noprof.edit', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar"
    >
        <i class="fas fa-edit text-primary" aria-hidden="true"></i>
    </a>

    <a href="#" class="mx-3 egresar" data-bs-toggle="tooltip"
        data-bs-original-title="Egresar" title="egresar" data-id="{{ $id }}">
        <i class="fas fa-backspace text-danger" aria-hidden="true"></i>
    </a>

    <a href="{{ route('sireh.carga-familiar.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Carga Familiar" title="CargaFamiliar"
    >
        <i class="fas fa-users text-success" aria-hidden="true"></i>
    </a>
