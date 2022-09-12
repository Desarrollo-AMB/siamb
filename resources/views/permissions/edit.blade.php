@extends('layouts.user_type.auth')

@section('title', 'Permisos')

@section('content_header', 'Editar Permiso')

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Editar Permiso</h5>
                    </div>
                    <a href="{{route('permissions.index')}}" class="btn btn-sm btn-secondary">Regresar</a>
                </div>
            </div>
            @include('permissions._form', ['permission' => $permission, 'method' => 'PUT', 'action' => 'update'])
        </div>
    </div>
</div>
@endsection
