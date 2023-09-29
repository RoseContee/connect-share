@extends('user.layouts')

@section('title', 'Welcome')

@section('content')
    <div class="container">
        <div class="align-center text-center">
            <h1>Welcome!</h1>
            <p class="mb-5">You are all set to use. Your domain users can use our service.</p>
            <div class="mb-1">
                <a href="{{ route('dashboard') }}" class="btn btn-success">Go to Dashboard</a>
            </div>
            <p>This page will be redirected to your dashboard in <span id="seconds">3</span> seconds.</p>
        </div>
    </div>
@endsection

@push ('after-scripts')
    <script>
        let seconds = 3;

        $(function() {
            setTimeout(countdown, 1000);
        });

        function countdown() {
            if (--seconds) {
                $('#seconds').text(seconds);
                setTimeout(countdown, 1000);
            } else {
                location.href = '{{ route('dashboard') }}';
            }
        }
    </script>
@endpush
