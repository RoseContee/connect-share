@extends('admin.auth.layouts')

@section('title', 'Admin Login')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@section('content')
    <p class="login-box-msg">Sign in</p>

    @include('partials.messages')

    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <div class="input-group">
                <input type="email" id="email" name="email" required
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            @error('email')
                <label for="email" class="font-weight-normal text-danger small mb-0">
                    {{ $message }}
                </label>
            @enderror
        </div>
        <div class="mb-3">
            <div class="input-group">
                <input type="password" id="password" name="password" required
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            @error('password')
                <label for="password" class="font-weight-normal text-danger small mb-0">
                    {{ $message }}
                </label>
            @enderror
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember"
                           value="1" @checked(old('remember'))>
                    <label for="remember">
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <p class="text-right mb-2">
                    <a href="{{ route('admin.password.forgot') }}">forgot password?</a>
                </p>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
    </form>
@endsection
