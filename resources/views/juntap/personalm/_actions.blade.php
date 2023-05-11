
<a href="{{ route('juntap.personalm.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Ver" title="Ver"
>
<i class="fas fa-eye text-info" aria-hidden="true"></i>
</a>

<a href="{{ route('juntap.personalm.edit', $id) }}" class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Editar" title="Editar"
>
<i class="fas fa-edit text-primary" aria-hidden="true"></i>
</a>

<a href="{{ route('juntap.personalm.cargo', $id) }}" class="mx-3"  data-bs-toggle="tooltip"
data-bs-original-title="Cargos" title="Cargos"
>
<i class="fas fa-briefcase text-success"></i>
</a>

<a href="{{ route('juntap.personalm.ubicacion', $id) }}" class="mx-3"  data-bs-toggle="tooltip"
data-bs-original-title="Ubicaciones" title="Ubicaciones"
>
<i class="fas fa-globe text-warning"></i>
</a>



<a href="{{ route('sireh.carga-familiar.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Carga Familiar" title="Carga Familiar"
>
<i class="fas fa-users text-warning" aria-hidden="true"></i>
</a>

<a href="{{ route('sireh.condecoraciones.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Condecoraciones" title="Condecoraciones"
>
<i class="fas fa-medal text-secondary" aria-hidden="true"></i>
</a>







<a href="#" class="mx-3 ascenso_personal" data-bs-toggle="tooltip" data-bs-original-title="Ascenso del Empleado"
    title="Ascenso del Empleado" data-id="{{ $codigo_empleado }}">
    <i class="fad fa-sort-amount-up-alt fa-lg" style='color:#095d29' aria-hidden="true"></i>
</a>


<a href="#" class="mx-3 cambio_categoria" data-bs-toggle="tooltip" data-bs-original-title="Categoria del Empleado"
    title="Categoria del Empleado" data-id="{{ $codigo_empleado }}">
    
    <i class="fad fa-user-friends fa-lg" style="--fa-primary-color: #02043b; --fa-secondary-color: #54a1f2;"  aria-hidden="true"></i>
    
</a>
