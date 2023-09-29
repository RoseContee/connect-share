@extends('admin.auth.layouts')

@section('title', 'Forgot Your Password? Reset It Here')

@section('content')
    <p class="login-box-msg">Reset Your Password</p>

    @include('partials.messages')

    <form action="{{ route('admin.password.forgot') }}" method="POST">
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
        <div>
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
        </div>
        <div class="text-center mt-2">
            <a href="{{ route('admin.login') }}">Back to Login</a>
        </div>
    </form>
@endsection
