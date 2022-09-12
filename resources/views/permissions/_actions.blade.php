{{--<a href="{{ route('permissions.edit', $id) }}" 
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
</form>--}}


<a href="{{ route('permissions.edit',$id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar">
    <i class="fas fa-edit text-secondary" aria-hidden="true"></i>
</a>
<a href="#" class="confirm-delete" form-target="delete-form-{{  $id }}"
    title="Eliminar" onclick="event.preventDefault();" >
    <i class="cursor-pointer fas fa-trash text-secondary" aria-hidden="true"></i>
</a>
<form id="delete-form-{{ $id }}" action="{{ route('permissions.destroy',  $id) }}"
    method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>