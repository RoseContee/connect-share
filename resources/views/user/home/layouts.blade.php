@extends('user.layouts')

@push('before-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
            @if (in_array(request()->route()->getName(), ['dashboard', 'profile']))
                @include('user.home.partials.storage-usage')
            @endif
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link text-center font-weight-bold text-uppercase">
                {{ config('app.name') }}
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
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    People
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('organization') }}"
                                       class="nav-link pl-4 @if (($submenu ?? '') == 'Organization') active @endif">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>Organization Chart</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
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
                                {{--<li class="nav-item">
                                    <a href="{{ route('travel-requests') }}" class="nav-link pl-4 @if (($submenu ?? '') == 'Travel') active @endif">
                                        <i class="nav-icon fas fa-car"></i>
                                        <p>Travel Request</p>
                                    </a>
                                </li>--}}
                            </ul>
                        </li>
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
                        @if (auth()->user()->members()->count())
                            @php
                                $holidayRequests = \App\Models\HolidayRequest::with(['latestReply'])
                                    ->where('manager_id', auth()->user()->google_id)
                                    ->where('status', '<>', 'approved')
                                    ->whereNull('parent')
                                    ->get();
                                $holiday_number = 0;
                                foreach ($holidayRequests as $request) {
                                    $r = $request['latestReply'] ?? $request;
                                    if ($r['status'] === 'pending') $holiday_number++;
                                }
                                $total = $holiday_number;
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
                                                    <span class="badge badge-info right">{{ $holiday_number }}</span>
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
            <div class="content">
                <div class="container-fluid">
                    @yield('home-content')
                </div>
            </div>
        </div>

        @if ($settings['shortcut'])
            @include('user.home.partials.short-cut-links')
        @endif
    </div>
@endsection

@push('before-scripts')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    @include('partials.toastr-messages')
@endpush
