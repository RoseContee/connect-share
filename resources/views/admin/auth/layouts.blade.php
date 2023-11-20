@extends('layouts')

@section('body')
    <body class="login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('admin.login') }}">
                    {{--<b class="h2">{{ config('app.name') }}</b>--}}
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid w-75" />
                </a>
            </div>
            <div class="card-body">

                @yield('content')

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
@endsection
