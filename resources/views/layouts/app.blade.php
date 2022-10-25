<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
    
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}

    <link href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/fixedHeader.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/responsive.dataTables.min.css') }}" rel="stylesheet">
    {{-- --}}

    {{-- ##########  TEMPLATE ########### --}}
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('template/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('template/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('template/assets/css/soft-ui-dashboard.css?v=1.0.3')}}" rel="stylesheet" />

    {{-- WIZARD --}}
	<!-- Fonts and Icons -->
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	<link href="{{ asset('template/wizard/css/themify-icons.css') }}" rel="stylesheet">

    <link href="{{ asset('css/siamb.css') }}" rel="stylesheet">
    @yield('styles')
    @stack('plugins-css')
    <script src="{{ asset('vendor/jquery/jquery-3.6.1.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('vendor/jquery/jquery.validate.js') }}" type="text/javascript"></script>
</head>
<body class="g-sidenav-show  bg-gray-100 ">        
    @auth
        @yield('auth')
    @endauth
    @guest 
        @yield('guest')
    @endguest

    @if(session()->has('success'))
        <div x-data="{ show: true}"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
        <p class="m-0">{{ session('success')}}</p>
        </div>
    @endif
    
    
    <!--   Core JS Files   -->
    <script src="{{ asset('template/assets/js/core/popper.min.js') }}"></script>
    {{--<script src="{{ asset('template/assets/js/core/bootstrap.min.js') }}"></script>--}}
    <script src="{{ asset('template/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/chartjs.min.js') }}"></script>
    @stack('rtl')
    @stack('dashboard')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('template/assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>

    
    <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}" ></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}" ></script>
    

    
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}" ></script> 
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}" ></script> 
    <script src="{{ asset('vendor/datatables/dataTables.fixedHeader.min.js') }}" ></script>
    <script src="{{ asset('vendor/datatables/dataTables.responsive.min.js') }}" ></script>
    <script src="{{ asset('vendor/datatables/responsive.bootstrap.min.js') }}" ></script>
    {{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>--}}


    {{-- wizard  --}}
    <script src="{{ asset('template/wizard/js/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
	<!--  Plugin for the Wizard -->
	<script src="{{ asset('template/wizard/js/demo.js') }}" type="text/javascript"></script>
	<script src="{{ asset('template/wizard/js/paper-bootstrap-wizard.js') }}" type="text/javascript"></script>

    
    @stack('plugins-js')
    @yield('scripts')
</body>
</html>
