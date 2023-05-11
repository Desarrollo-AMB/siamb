
    <a href="{{ route('auxiliares.cargos.edit', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar"
    >
        <i class="fas fa-edit text-primary" aria-hidden="true"></i>
    </a>

    <a href="#" class="mx-3 confirm-delete"  title="Eliminar"
        data-target="{{ route('auxiliares.cargos.destroy', $id) }}"
    >
        <i class="fas fa-trash text-danger"></i>
    </a>