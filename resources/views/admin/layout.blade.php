<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
    <script src="{{ asset('admin/js/scripts.js') }}" defer></script>
</head>
<body>
    @include('admin.partials.navbar')
    
    <div class="main-container" style="display:flex; min-height:100vh;">
        @include('admin.partials.sidebar')

        <div class="content" style="flex:1; padding:20px;">
            @yield('content')
        </div>
    </div>

    @include('admin.partials.footer')
</body>
</html>
