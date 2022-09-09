@extends('layouts.user_type.auth')

@section('title', 'Permisos')

@section('content_header', 'Crear Permiso')

@section('content')
    @include('permissions._form', ['permission' => $permission, 'method' => 'POST', 'action' => 'store'])
@endsection
