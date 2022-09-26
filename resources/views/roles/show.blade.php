@extends('layouts.user_type.auth')
@section('title', 'Roles')
@section('content')
<div class="row">
    <div class="col-10">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Rol</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('roles.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $role->name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group row">
                            <div class="col-3"><strong>Permisos: </strong></div>
                            <div class="col-9">
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <span class="badge bg-gradient-success">{{ $v->name }}</span>&nbsp;
                                @endforeach
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection