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
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="card-body px-2 pt-2 pb-2">
        <div class="row">
            <div class="col-8">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0 mb-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Programaciones Realizadas</h5>
                            </div>
                            <a class="btn btn-secondary btn-sm mb-0" href="{{ route('dao.ver_programacion') }}">Volver</a>
                        </div>
                    </div>
                    <hr class="horizontal dark my-0">
                    <div class="card-body px-2 pt-2 pb-2">
                        <div class="row">
                            <div class="col-xs-9 col-sm-9 col-md-9">
                                <div class="form-group">
                                    <label for="desde">Elegir Fecha:</label>
                                    <input type="date" name="desde" class="form-control" value="" readonly>
                                </div>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <br>
                                <button type="submit" class="btn btn-success">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection