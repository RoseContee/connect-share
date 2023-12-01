@extends('user.layouts')

@php
$user = request()->user();
$profilePage = request()->route()->getName() === 'profile';
@endphp

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="wrapper">
        <div class="main-header">
            @if ($profilePage && empty($settings['hide_banner']) && empty($user['intranet']['hide_profile_banner']))
                @php
                    $banner = getBannerImage($user['intranet']['profile_banner_image'] ?? null, $settings['profile_banner_image'] ?? null);
                @endphp
                <div class="banner" style="background-image: url('{{ $banner }}')"></div>
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
                @if ($profilePage)
                    @include('user.home.partials.storage-usage')
                @endif
            </nav>
            <!-- /.navbar -->
        </div>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="{{ route('home') }}" class="brand-link text-center">
                <img src="{{ getLogo($settings['logo'] ?? null) }}" alt="Logo" class="img-fluid" />
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link @if ($menu == 'Profile') active @endif">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item @if (in_array($menu, ['PeopleMembers', 'PeopleOrganization'])) menu-open @endif">
                            <a href="#" class="nav-link @if (in_array($menu, ['PeopleMembers', 'PeopleOrganization'])) active @endif">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    People
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('members') }}"
                                       class="nav-link pl-4 @if ($menu == 'PeopleMembers') active @endif">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Members</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('organization') }}"
                                       class="nav-link pl-4 @if ($menu == 'PeopleOrganization') active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>Organization Chart</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if ($user['is_admin'] && $user->hasWidget(Widgets::GMAIL_USE))
                            <li class="nav-item">
                                <a href="{{ route('widget.gmail-use') }}" class="nav-link @if ($menu == 'WidgetGmailUse') active @endif">
                                    <i class="nav-icon fab fa-google"></i>
                                    <p>Gmail Use</p>
                                </a>
                            </li>
                        @endif
                        @if ($user->hasWidget(Widgets::HOLIDAY_REQUEST))
                            <li class="nav-item @if ($menu == 'WidgetHolidayRequest') menu-open @endif">
                                <a href="#" class="nav-link @if ($menu == 'WidgetHolidayRequest') active @endif">
                                    <i class="nav-icon fas fa-paper-plane"></i>
                                    <p>
                                        Request
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('widget.holiday-requests') }}"
                                           class="nav-link pl-4 @if ($menu == 'WidgetHolidayRequest') active @endif">
                                            <i class="nav-icon fas fa-plane"></i>
                                            <p>Holiday Request</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if ($user->hasWidget(Widgets::HOLIDAY_REQUEST)
                            && request()->user_members_number
                            && ($requests_number = request()->holiday_requests_number)
                        )
                            <li class="nav-item @if ($menu == 'WidgetHolidayApproval') menu-open @endif">
                                <a href="#" class="nav-link @if ($menu == 'WidgetHolidayApproval') active @endif">
                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>
                                        Approval
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-info right">{{ $requests_number }}</span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('widget.holiday-approvals') }}"
                                           class="nav-link pl-4 @if ($menu == 'WidgetHolidayApproval') active @endif">
                                            <i class="nav-icon fas fa-plane"></i>
                                            <p>
                                                Holiday Approval
                                                <span class="badge badge-info right">{{ $requests_number }}</span>
                                            </p>
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
                        @if ($user['is_admin'] && $user->hasWidget(Widgets::CORPORATE_NEWS))
                            <li class="nav-item">
                                <a href="{{ route('widget.corporate-news') }}" class="nav-link @if ($menu == 'WidgetCorporateNews') active @endif">
                                    <i class="nav-icon fas fa-calendar-week"></i>
                                    <p>Corporate News Setting</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('settings.index') }}" class="nav-link @if ($menu == 'Settings') active @endif">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Settings</p>
                            </a>
                        </li>
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

        @include('user.home.partials.footer', ['class' => 'main-footer'])

        @if (!empty($settings['shortcut']))
            @include('user.home.partials.short-cut-links')
        @endif
    </div>
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    @include('partials.toastr-messages')
@endpush
