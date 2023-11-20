@extends('user.layouts')

@php
$user = request()->user();
$widgets = explode(',', $user['intranet']['widgets'] ?? '');
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
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
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
                        <div class="w-100 h-100 img-rounded d-md-flex align-items-end d-none"
                             style="background: url('{{ asset('assets/img/banner-bg.jpg') }}') no-repeat fixed center;">
                            <h3 class="text-white ml-3 mb-3">Add Title Here</h3>
                        </div>
                    </div>
                    <div class="col-md-4 text-center py-4">
                        <h4 class="text-center mb-3">
                            {{ $user['given_name'].' '.$user['family_name'] }}
                        </h4>
                        <p class="text-center">
                            <img src="{{ $user['avatar'] ?? asset('assets/img/profile.png') }}" alt="Profile"
                                 class="profile-user-img img-circle"
                            />
                        </p>
                        <p class="mb-0">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                My Page
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-8">
                        <h5>Alerts <i class="fa fa-chevron-right"></i></h5>
                        <div id="alerts" class="carousel" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#alerts" data-slide-to="0" class="active"></li>
                                <li data-target="#alerts" data-slide-to="1"></li>
                                <li data-target="#alerts" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner row flex-nowrap">
                                <div class="carousel-item col-md-6 active">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center bg-gray-light p-2">
                                            <div class="img-rounded bg-primary text-center px-3 py-1">
                                                <h6 class="mb-0">6</h6>
                                                <p class="small m-0">Dec</p>
                                            </div>
                                            <p class="ml-3 mb-0">There is upcoming event.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item col-md-6">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center bg-gray-light p-2">
                                            <div class="img-rounded bg-primary text-center px-3 py-1">
                                                <h6 class="mb-0">8</h6>
                                                <p class="small m-0">Dec</p>
                                            </div>
                                            <p class="ml-3 mb-0">There is upcoming event1.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item col-md-6">
                                    <div class="card">
                                        <div class="card-body d-flex align-items-center bg-gray-light p-2">
                                            <div class="img-rounded bg-primary text-center px-3 py-1">
                                                <h6 class="mb-0">10</h6>
                                                <p class="small m-0">Dec</p>
                                            </div>
                                            <p class="ml-3 mb-0">There is upcoming event2.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<a class="carousel-control-prev" href="#alerts" role="button" data-slide="prev">
                                <span class="carousel-control-custom-icon" aria-hidden="true">
                                  <i class="fas fa-chevron-left"></i>
                                </span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#alerts" role="button" data-slide="next">
                                <span class="carousel-control-custom-icon" aria-hidden="true">
                                  <i class="fas fa-chevron-right"></i>
                                </span>
                                <span class="sr-only">Next</span>
                            </a>--}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Upcoming meetings</h5>
                        <div class="callout callout-success d-flex p-2 mb-2">
                            <span class="mr-2">14:00</span>
                            <h5>I am an info callout!</h5>
                        </div>
                        <a href="https://calendar.google.com/calendar/" target="_blank">View full list</a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-8">
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
                    <div class="col-md-4">
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

            @if (in_array(Widgets::WEATHER, $widgets))
                <footer class="d-block d-md-flex align-items-center justify-content-around mt-4">
                    @include('user.home.widgets.weather')
                </footer>
            @endif
        </div>
    </div>
@endsection
