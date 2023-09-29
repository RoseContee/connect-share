@extends('layouts')

@section('body')
<body class="auth-page">
    <div class="auth-bg" style="background-image: url({{ asset('assets/img/auth-bg.jpg') }})"></div>
    <div class="col-12 col-md-7 align-center">
        @yield('content')
    </div>
</body>
@endsection
