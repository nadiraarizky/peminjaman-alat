<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SB Admin CSS -->
    <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />

    <!-- Fontawesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
            crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    {{-- NAVBAR --}}
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">
            Admin Panel
        </a>
    </nav>

    <div id="layoutSidenav">

        {{-- SIDEBAR --}}
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark">

                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            Dashboard
                        </a>

                        <a class="nav-link" href="{{ route('admin.alats.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            Data Alat
                        </a>

                    </div>
                </div>

            </nav>
        </div>

        {{-- CONTENT --}}
        <div id="layoutSidenav_content">

            <main>
                @yield('content')
            </main>

            {{-- FOOTER --}}
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4 text-muted">
                    &copy; {{ date('Y') }} Admin Dashboard
                </div>
            </footer>

        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('admin/js/scripts.js') }}"></script>

</body>
</html>
