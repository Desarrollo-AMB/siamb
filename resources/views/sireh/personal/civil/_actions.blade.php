<a href="{{ route('sireh.personal-civil.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
    data-bs-original-title="Ver" title="Ver">
    <i class="fas fa-eye text-info" aria-hidden="true"></i>
</a>


<a href="{{ route('sireh.personal-civil.edit', $id) }}"  class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Editar" title="Editar">
<i class="fas fa-edit text-primary" aria-hidden="true"></i>
</a>

<a href="#" class="mx-3 suspender" data-bs-toggle="tooltip" data-bs-original-title="Suspender" title="Suspender" data-id="{{ $codigo_empleado }}">
<i class="fas fa-sync text-info" aria-hidden="true"></i>
</a>

<a href="#" class="mx-3 egresar" data-bs-toggle="tooltip" data-bs-original-title="Suspender" title="Egresar" data-id="{{ $codigo_empleado }}">
<i class="fas fa-backspace text-danger" aria-hidden="true"></i>
</a>

<a href="{{ route('sireh.carga-familiar.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Carga Familiar" title="CargaFamiliar">
<i class="fas fa-users text-primary" aria-hidden="true"></i>
</a>

<a href="#" class="mx-3 cursos" data-bs-toggle="tooltip" data-bs-original-title="Cursos" title="Cursos Realizados" data-id="{{ $codigo_empleado }}">
<i class="fas fa-graduation-cap text-success" aria-hidden="true"></i>
</a>

<a href="{{ route('sireh.personal-civil.evaluar', $id) }}" class="mx-3" data-bs-toggle="tooltip"
data-bs-original-title="Evaluar" title="Evaluar">
<i class="fa fa-file-signature text-secondary" aria-hidden="true"></i>
</a>

<a href="#" class="mx-3 jubilar" data-bs-toggle="tooltip" data-bs-original-title="Jubilar" title="Jubilar Empleado" data-id="{{ $codigo_empleado }}">
    <i class="fas fa-home text-warning" aria-hidden="true"></i>
</a>

    <a href="{{ route('sireh.personal-civil.view', $id) }}" class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Ver" title="Ver"
    >
        <i class="fas fa-eye text-info" aria-hidden="true"></i>
    </a>
    <a href="{{ route('sireh.personal-civil.edit', $id) }}"  class="mx-3" data-bs-toggle="tooltip"
        data-bs-original-title="Editar" title="Editar"
    >
        <i class="fas fa-edit text-primary" aria-hidden="true"></i>
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

