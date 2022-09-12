@extends('layouts.user_type.auth')

@section('title', 'Permisos')

@section('content_header', 'Permisos')

@push('plugins-css')

@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Permiso</h5>
                    </div>
                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-secondary float-right">Regresar</a>
                </div>
            </div>
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row container">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ $permission->name }}</h4>
                                
                            </div>
                            <div class="card-body">
                                <strong><i class="fa fa-globe mr-1"></i> Nombre de Ruta</strong>
                                <p class="text-muted">
                                    {{ $permission->route_name }}
                                </p>
                                <hr>
                                <strong><i class="fa fa-users mr-1"></i> Grupo</strong>
                                <p class="text-muted">
                                    {{ $permission->group }}
                                </p>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4 class="card-title"><small>Roles del Permiso</small></h4>
                            </div>
                            <div class="card-body">
                                <table id="table" class="table table-sm table-bordered table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true">Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permission->roles as $role)
                                            <tr>
                                                <td><a href="{{route('roles.show', $role->id)}}">{{ $role->name }}</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('plugins-js')
   
@endsection