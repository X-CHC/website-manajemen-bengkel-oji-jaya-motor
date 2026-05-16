<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- CSS Alert -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/toastr/toastr.min.css') }}">
    <!-- Tambahkan CSS DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    @include('layout.navbar')

    {{-- Sidebar --}}
    @include('layout.sidebar')

    {{-- Content --}}
    <div class="content-wrapper">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('layout.footer')

</div>

<script src="{{ asset('assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>


<script src="{{ asset('assets/adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Tambahkan JS DataTables -->
<script src="{{ asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- JS Alert -->
<script src="{{ asset('assets/adminlte/plugins/toastr/toastr.min.js') }}"></script>
<script>
    window.flashMessage = {
        success: @json(session('success')),
        error: @json(session('error')),
        warning: @json(session('warning')),
        info: @json(session('info')),
    };
</script>
<script src="{{ asset('assets/js/flash-message.js') }}"></script>


@stack('scripts')

</body>
</html>
