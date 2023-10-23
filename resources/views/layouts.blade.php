<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ getFavicon($settings['favicon'] ?? null) }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    @yield('metadata')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    @stack('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/theme/css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom/css/style.css') }}">
    @stack('after-styles')
</head>

@yield('body')

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@stack('before-scripts')
<script src="{{ asset('assets/theme/js/theme.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });
</script>
<script src="{{ asset('assets/custom/js/main.js') }}"></script>
@stack('after-scripts')
</html>
