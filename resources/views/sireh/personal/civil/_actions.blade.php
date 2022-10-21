
    <a href="{-- route('sireh.empleados.edit', $id) --}" class="btn btn-sm btn-primary"
        title="Editar">
        <i class="fa fa-edit"></i>
    </a>
    <a href="#" class="btn btn-sm btn-danger confirm-delete" title="Eliminar"
        onclick="event.preventDefault();" form-target="delete-form-{{ $id }}">
        <i class="fa fa-times"></i>
    </a>
    <form id="delete-form-{{ $id }}" action="{-- route('sireh.empleados.destroy', $id) --}"
        method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>