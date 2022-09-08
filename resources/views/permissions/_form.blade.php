<form action="{{ route("permissions.$action", $permission->id) }}" method="POST">
    @csrf
    @method($method)
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
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
                            <option disabled {{ old('route_name', $permission->route_name)==null ? 'selected':'' }}
                            > Seleccione el Nombre de la Ruta </option>
                            @forelse ($privateRoutesWithoutPermission as $route)
                                <option {{ old('route_name', $permission->route_name)==$route->getName() ? 'selected':'' }}
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
                        <a href="{{route('permissions.index')}}" class="btn btn-sm btn-secondary">Regresar</a>
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </div>
                <div class="card-footer">
                    * Campo obligatorio
                </div>
            </div>
        </div>
    </div>
</form>

@push('plugins-css')
   
@endpush

@section('plugins.Select2', true)

@push('js')
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/i18n/es.js') }}"></script> 

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
  </script>
@endpush
