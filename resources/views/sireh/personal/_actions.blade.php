
    <a href="#" class="mx-3 activar-ingreso" data-bs-toggle="tooltip" data-bs-original-title="Activar" title="Activar"
        data-target="{{ route('sireh.ingreso-personal.activar', $id) }}"
    >
        <i class="fas fa-arrow-up text-success" aria-hidden="true"></i>
    </a>

    <a href="{{ route('sireh.ingreso-personal.edit', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar"
    >
        <i class="fas fa-edit text-primary" aria-hidden="true"></i>
    </a>

    <a href="#" class="mx-3 confirm-delete"  title="Eliminar"
        data-target="{{ route('sireh.ingreso-personal.destroy', $id) }}"
    >
        <i class="fas fa-trash"></i>
    </a>
