@php
$user = request()->user();
@endphp

@if ($user->hasWidget(Widgets::WEATHER) || $user->hasWidget(Widgets::TRADINGVIEW))
    <footer class="{{ $class ?? '' }} d-block d-md-flex align-items-center justify-content-around">
        @if ($user->hasWidget(Widgets::WEATHER))
            @include('user.home.widgets.weather')
        @endif

        @if ($user->hasWidget(Widgets::TRADINGVIEW))
            @include('user.home.widgets.tradingview')
        @endif
    </footer>
@endif
