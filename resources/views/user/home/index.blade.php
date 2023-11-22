@extends('user.layouts')

@php
$user = request()->user();
@endphp

@section('content')
    <div class="wrapper">
        <div class="container">
            <nav class="navbar navbar-expand navbar-white navbar-light px-0">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="navbar-brand" href="#">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="navbar-img" />
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            {{--<i class="far fa-user-circle"></i>--}}
                            <img src="{{ $user['avatar'] ?? asset('assets/img/profile.png') }}" alt="Profile"
                                 class="navbar-img img-circle w-auto border"
                            />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('profile') }}" class="dropdown-item">
                                <i class="fas fa-user-circle mr-2"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <main>
                <div class="row">
                    <div class="col-md-8">
                        <div class="home-banner d-none d-md-flex align-items-end">
                            <img src="{{ asset('assets/img/banner-bg.jpg') }}" alt="Image" />
                            <h3 class="banner-title">Add Title Here</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center mb-0">
                            <div class="card-body">
                                <h4 class="mb-3">
                                    {{ $user['given_name'].' '.$user['family_name'] }}
                                </h4>
                                <div class="mb-3">
                                    <img src="{{ $user['avatar'] ?? asset('assets/img/profile.png') }}" alt="Profile"
                                         class="profile-user-img img-circle"/>
                                </div>
                                <p class="mb-0">
                                    <a href="{{ route('profile') }}" class="btn btn-primary">
                                        My Page
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($user->hasWidget(Widgets::ALERTS))
                        @include('user.home.widgets.alerts.index', [
                            'class' => 'col-md-8 mt-5',
                            'alerts' => $alerts,
                        ])
                    @endif
                    <div class="@if ($user->hasWidget(Widgets::ALERTS)) col-md-4 @else col-md-12 @endif mt-5">
                        <h5>Upcoming meetings</h5>
                        <div class="row">
                            @forelse ($myEvents as $event)
                                <div class="@if ($user->hasWidget(Widgets::ALERTS)) col-md-4 @else col-md-12 @endif">
                                    <div class="callout callout-success d-flex align-items-center bg-gray-light p-2 mb-2">
                                        <div class="text-center px-2 py-1 mr-2">
                                            <h6 class="text-nowrap m-0">{{ date('j M', strtotime($event['date'])) }}</h6>
                                            <p class="small m-0">{{ date('H:i', strtotime($event['date'])) }}</p>
                                        </div>
                                        <h5 class="text-truncate m-0">{{ $event['description'] }}</h5>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="font-italic py-3 mb-2">No Events</p>
                                </div>
                            @endforelse
                        </div>
                        <a href="https://calendar.google.com/calendar/" target="_blank">View full list</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-5">
                        <h5>News <i class="fa fa-chevron-right"></i></h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card news-item">
                                    <div class="card-header p-0">
                                        <img src="{{ asset('assets/img/banner-bg.jpg') }}" alt="Image" />
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="font-weight-bold mb-1">
                                            This is news1.
                                        </h6>
                                        <span class="small">
                                            12 Mar 2023
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card news-item">
                                    <div class="card-header p-0">
                                        <img src="{{ asset('assets/img/banner-bg.jpg') }}" alt="Image" />
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="font-weight-bold mb-1">
                                            This is news1.
                                        </h6>
                                        <span class="small">
                                            12 Mar 2023
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card news-item">
                                    <div class="card-header p-0">
                                        <img src="{{ asset('assets/img/banner-bg.jpg') }}" alt="Image" />
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="font-weight-bold mb-1">
                                            This is news1.
                                        </h6>
                                        <span class="small">
                                            12 Mar 2023
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-5">
                        <h5>Link Useful</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plane fa-2x"></i>
                                        <p class="m-0 text-truncate">Holiday Request</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plane fa-2x"></i>
                                        <p class="m-0 text-truncate">Holiday Request</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plane fa-2x"></i>
                                        <p class="m-0 text-truncate">Holiday Request</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plane fa-2x"></i>
                                        <p class="m-0 text-truncate">Holiday Request</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @include('user.home.partials.footer', ['class' => 'py-3'])
        </div>
    </div>
@endsection
