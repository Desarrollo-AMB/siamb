@extends('layouts.user_type.auth')

@section('title', 'Permisos')

@section('content_header', 'Editar Permiso')

@section('content')
    @include('permissions._form', ['permission' => $permission, 'method' => 'PUT', 'action' => 'update'])
@endsection
