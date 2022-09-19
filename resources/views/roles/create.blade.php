@extends('layouts.user_type.auth')

@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger mx-4" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
    <div class="col-10">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Nuevo Rol</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('roles.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre Rol:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Nombre','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permisos: </strong>
                            <div class="row"> 
                                {{--<div class="col-4">
                                @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                    <br>
                                    @if ($loop->iteration % 9 ==0)
                                        </div>
                                        <div class="col-4">
                                    @endif
                                @endforeach
                                </div>--}}
                                @foreach ($permissionsGrouped as $permissionGroup => $permissions)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-gradient-secondary text-center pt-2 pb-1 position-relative">
                                            <h5 class="card-title">{{ "$permissionGroup" }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                @foreach ($permissions as $permission)
                                                    <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" 
                                                        id="permission-{{ $permission->id }}"
                                                        name="permission[]"
                                                        value="{{ $permission->id }}"
                                                       >
                                                    <label for="permission-{{ $permission->id }}" class="custom-control-label">
                                                        {{ "$permission->name"  }}
                                                    </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection