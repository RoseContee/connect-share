@extends('user.layouts')

@php
$user = request()->user();
$widgets = explode(',', $user['intranet']['widgets'] ?? '');
$dashboardPage = in_array(request()->route()->getName(), ['dashboard', 'profile']);
@endphp

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="wrapper">
        <div class="main-header">
            @if (empty($settings['hide_banner']) && empty($user['intranet']['hide_banner']) && $dashboardPage)
                <div class="banner"
                     style="background-image: url('{{ getBannerImage($user['intranet']['banner_image'] ?? null, $settings['banner_image'] ?? '') }}')">
                </div>
            @endif
            <!-- Navbar -->
            <nav class="navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                </ul>
                @if ($dashboardPage)
                    @include('user.home.partials.storage-usage')
                @endif
            </nav>
            <!-- /.navbar -->
        </div>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link text-center">
                {{--<span class="font-weight-bold text-uppercase">
                    {{ config('app.name') }}
                </span>--}}
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid" />
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link @if ($menu == 'Dashboard') active @endif">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link @if ($menu == 'Profile') active @endif">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item @if ($menu == 'People') menu-open @endif">
                            <a href="#" class="nav-link @if ($menu == 'People') active @endif">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    People
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('members') }}"
                                       class="nav-link pl-4 @if (($submenu ?? '') == 'Members') active @endif">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Members</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('organization') }}"
                                       class="nav-link pl-4 @if (($submenu ?? '') == 'Organization') active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>Organization Chart</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (in_array(Widgets::HOLIDAY_REQUEST, $widgets))
                            <li class="nav-item @if ($menu == 'Request') menu-open @endif">
                                <a href="#" class="nav-link @if ($menu == 'Request') active @endif">
                                    <i class="nav-icon fas fa-paper-plane"></i>
                                    <p>
                                        Request
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('holiday-requests') }}"
                                           class="nav-link pl-4 @if (($submenu ?? '') == 'HolidayRequest') active @endif">
                                            <i class="nav-icon fas fa-plane"></i>
                                            <p>Holiday Request</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('useful-links.index') }}" class="nav-link @if ($menu == 'Links') active @endif">
                                <i class="nav-icon fas fa-link"></i>
                                <p>Useful Links</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('documents.index') }}" class="nav-link @if ($menu == 'Documents') active @endif">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>Company Documents</p>
                            </a>
                        </li>
                        @if (in_array(Widgets::HOLIDAY_REQUEST, $widgets) && request()->user_members_number)
                            @php
                                $holiday_requests_number = request()->holiday_requests_number;
                                $total = $holiday_requests_number;
                            @endphp
                            @if ($total)
                                <li class="nav-item @if ($menu == 'Approval') menu-open @endif">
                                    <a href="#" class="nav-link @if ($menu == 'Approval') active @endif">
                                        <i class="nav-icon fas fa-user-check"></i>
                                        <p>
                                            Approval
                                            <i class="fas fa-angle-left right"></i>
                                            <span class="badge badge-info right">{{ $total }}</span>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('holiday-approvals') }}"
                                               class="nav-link pl-4 @if (($submenu ?? '') == 'HolidayApproval') active @endif">
                                                <i class="nav-icon fas fa-plane"></i>
                                                <p>
                                                    Holiday Approval
                                                    <span class="badge badge-info right">{{ $holiday_requests_number }}</span>
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="content pt-3">
                @yield('home-content')
            </div>
        </div>

        @if (in_array(Widgets::WEATHER, $widgets) || in_array(Widgets::TRADINGVIEW, $widgets))
            <footer class="main-footer d-block d-md-flex align-items-center justify-content-around">
                @if (in_array(Widgets::WEATHER, $widgets))
                    @include('user.home.widgets.weather')
                @endif

                @if (in_array(Widgets::TRADINGVIEW, $widgets))
                    @include('user.home.widgets.tradingview')
                @endif
            </footer>
        @endif

        @if ($settings['shortcut'])
            @include('user.home.partials.short-cut-links')
        @endif
    </div>
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    @include('partials.toastr-messages')
@endpush
