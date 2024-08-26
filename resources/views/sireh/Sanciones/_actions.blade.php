
    <a href="#" class="mx-3 editar" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar" data-id="{{ $id }}">
        <i class="fas fa-edit text-success" aria-hidden="true"></i>
    </a>

    <a href="#" class="mx-3 confirm-delete"  title="Eliminar"
        data-target="{{ route('sireh.condecoraciones.destroy', $id) }}"
    >
        <i class="fas fa-trash text-danger"></i>
    </a>