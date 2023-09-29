@extends('admin.auth.layouts')

@section('title', 'Reset Password')

@section('content')
    <p class="login-box-msg">Create new password</p>

    @include('partials.messages')

    <form action="{{ route('admin.password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />
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
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="New Password" required>
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
        <div class="mb-3">
            <div class="input-group">
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       placeholder="Confirm Password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            @error('password_confirmation')
                <label for="password_confirmation" class="font-weight-normal text-danger small mb-0">
                    {{ $message }}
                </label>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary btn-block">Reset password</button>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('admin.login') }}">Back to Login</a>
        </div>
    </form>
@endsection
