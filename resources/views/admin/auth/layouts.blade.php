@extends('layouts')

@section('body')
    <body class="login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('admin.login') }}" class="h2">
                    <b>{{ config('app.name') }}</b>
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
