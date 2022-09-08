<a href="{{ route('permissions.edit', $id) }}" 
    class="btn btn-sm btn-primary" title="Editar">
    <i class="fa fa-edit"></i>
</a>
<a href="#" class="btn btn-sm btn-danger confirm-delete" form-target="delete-form-{{ $id }}"
    title="Eliminar" onclick="event.preventDefault();">
    <i class="fa fa-times"></i>
</a>
<form id="delete-form-{{ $id }}" action="{{ route('permissions.destroy', $id) }}"
    method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>