@extends('layouts.user_type.auth')
@section('title', 'Usuarios')
@section('content')
<div class="row">
    <div class="col-10">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 mb-2">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Usuario</h5>
                    </div>
                    <a class="btn btn-secondary btn-sm mb-0" href="{{ route('users.index') }}">Volver</a>
                </div>
            </div>
            <hr class="horizontal dark my-0">
            <div class="card-body px-2 pt-2 pb-2">
                <div class="row">
                    {{--<div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $user->name }}
                        </div>
                    </div>--}}
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Usuario:</strong>
                            {{ $user->username }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Roles:</strong>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <label class="badge bg-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            @if ($user->empleado)
                            <strong>Empleado:</strong>
                            <span>
                                {{ $user->empleado->cedula }} - {{ $user->empleado->nombre1 }} {{ $user->empleado->nombre2 }}, {{ $user->empleado->apellido1 }} {{ $user->empleado->apellido2 }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection