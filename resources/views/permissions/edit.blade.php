{{-- @extends('layouts.admin.app') --}}
@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header', 'Editar Permiso')

@section('content')
    @include('permissions._form', ['permission' => $permission, 'method' => 'PUT', 'action' => 'update'])
@endsection
