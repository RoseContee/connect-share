@extends('user.auth.layouts')

@section('title', 'Login')

@section('content')
    <div class="text-center">
        <h1>Welcome back!</h1>
        <h5 class="text-muted mb-4">A happier workplace is only one sign-in away</h5>
        <div class="text-left">
            @include('partials.messages')
        </div>
        <div class="d-flex justify-content-center mb-5">
            <a href="{{ route('auth.google') }}">
                <img src="{{ asset('assets/img/google-signin.svg') }}" alt="Signin"/>
            </a>
        </div>
    </div>
@endsection
