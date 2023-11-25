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
                        <a class="navbar-brand" href="/">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="navbar-img" />
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <img src="{{ $user['avatar'] ?? asset('assets/img/profile.png') }}" alt="Profile"
                                 class="navbar-img img-circle w-auto border" />
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
                            <img src="{{ getBannerImage($user['intranet']['home_banner_image'], $settings['home_banner_image'] ?? null) }}"
                                 alt="Image" />
                            <h3 class="banner-title">
                                {{ $user['intranet']['home_banner_title'] ?? $settings['home_banner_title'] }}
                            </h3>
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
                    @if ($user->hasWidget(Widgets::CORPORATE_NEWS))
                        @include('user.home.widgets.corporate-news.index', [
                            'class' => 'col-md-8 mt-5',
                            'newses' => $corporateNewses,
                        ])
                    @endif
                    <div class="@if ($user->hasWidget(Widgets::CORPORATE_NEWS)) col-md-4 @else col-md-12 @endif mt-5">
                        <h5>Upcoming meetings</h5>
                        <div class="row">
                            @forelse ($myEvents as $event)
                                <div class="@if ($user->hasWidget(Widgets::CORPORATE_NEWS)) col-md-12 @else col-md-4 @endif">
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
                                    <p class="font-italic py-3">No Events</p>
                                </div>
                            @endforelse
                        </div>
                        <a href="https://calendar.google.com/calendar/" target="_blank">View full list</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 mt-5">
                        <h5>News <i class="fa fa-chevron-right"></i></h5>
                        <div id="news" class="carousel" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($newses as $index => $news)
                                    <li data-target="#news" data-slide-to="{{ $index }}" @if (!$index) class="active" @endif></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner row flex-nowrap">
                                @forelse ($newses as $news)
                                    <div class="carousel-item col-md-6 col-lg-4 @if ($loop->first) active @endif">
                                        <a href="{{ $news['link'] }}" class="card news-item">
                                            <div class="card-header p-0">
                                                <img src="{{ asset('assets/img/news.jpg') }}" alt="Image" />
                                            </div>
                                            <div class="card-body p-2">
                                                <h6 class="font-weight-bold text-truncate mb-1">
                                                    {{ $news['title'] }}
                                                </h6>
                                                <span class="small">{{ $news['date'] }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="font-italic py-3">No News</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-5">
                        <h5>Link Useful</h5>
                        <div class="row">
                            @forelse ($links as $index => $link)
                                @break($index === 4)
                                <div class="col-sm-6">
                                    <a href="{{ $link['link'] }}" class="card text-dark">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('assets/img/icons/useful-link.png') }}" alt="Usefull Link"
                                                 class="icon-32" />
                                            <p class="m-0 text-truncate">{{ $link['description'] }}</p>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="font-italic py-3">No Links</p>
                                </div>
                            @endforelse
                            @if (count($links) > 4)
                                <div class="col-12">
                                    <a href="{{ route('useful-links.index') }}">View more links</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>

            @include('user.home.partials.footer', ['class' => 'py-3 mt-5'])
        </div>
    </div>
@endsection
