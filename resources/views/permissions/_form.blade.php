<div class="card-body">
    <form action="{{ route("permissions.$action", $permission->id) }}" method="POST">
        @csrf
        @method($method)
        <div class="form-group">
            <label for="name">Nombre*</label>
            <input type="text" name="name" class="form-control" id="name" required
                placeholder="Nombre del Permiso" 
                value="{{ old('name', $permission->name) }}">
            @error('name')
                <span class="error invalid-feedback" style="display:inline">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="route_name">Nombre de Ruta*</label>
            <select class="select2 form-control" name="route_name" id="route_name" required
                data-live-search="true">
                <option disabled {{ old('route_name', $permission->route_name)!=null ? 'selected':'' }}>{{ $permission->route_name }}</option>
                > Seleccione el Nombre de la Ruta </option>
                @forelse ($privateRoutesWithoutPermission as $route)
                    <option {{ old('route_name', $permission->route_name)===$route->getName() ? 'selected':'' }}
                    >{{ $route->getName() }}</option>
                @empty
                    @if (old('route_name', $permission->route_name))
                        <option>{{ old('route_name', $permission->route_name) }}</option>
                    @endif
                @endforelse
            </select>

            @error('route_name')
                <span class="error invalid-feedback" style="display:inline">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="group">Grupo*</label>
            <input type="text" name="group" class="form-control" id="group" required
                placeholder="Grupo del Permiso"
                value="{{ old('group', $permission->group) }}">
                
            @error('group')
                <span class="error invalid-feedback" style="display:inline">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group float-right">
            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
        </div>
        
    </form>
</div>
<div class="card-footer">
    * Campo obligatorio
</div>
@push('plugins-css')
<link href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet">
@endpush



@push('plugins-js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/i18n/es.js') }}"></script> 

@endpush
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
  </script>
@endsection