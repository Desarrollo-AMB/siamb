@extends('layouts.user_type.auth')
@section('title', 'SIREH Auxiliares')
@section('content')
    @include('sireh._barra_auxiliar')
@endsection

@section('scripts')
@parent
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function () {
        
    });
</script>
@endsection