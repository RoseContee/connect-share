@extends('user.layouts')

@section('body')
<body class="sidebar-mini {{ $dark_mode ? 'dark-mode' : '' }}">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand {{ $dark_mode ? 'navbar-dark' : 'navbar-white navbar-light'}}">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <div class="custom-control custom-switch custom-switch-on-dark">
                        <input type="checkbox" id="dark-mode"
                               @if ($dark_mode) checked @endif
                               class="custom-control-input">
                        <label class="custom-control-label" for="dark-mode">Dark Mode</label>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 {{ $dark_mode ? 'sidebar-dark-primary' : 'sidebar-light-primary' }}">
            <a href="{{ route('admin.home') }}" class="brand-link">
                <img src="{{ asset('assets/img/admin-logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight">Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link @if ($menu == 'Dashboard') active @endif">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.shortcuts.index') }}" class="nav-link @if($menu == 'Shortcuts') active @endif">
                                <i class="nav-icon fas fa-link"></i>
                                <p>Shortcuts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link @if($menu == 'Settings') active @endif">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.profile') }}" class="nav-link @if($menu == 'Profile') active @endif">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link">
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

        @yield('content')

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>
                Copyright &copy; {{ date('Y') }}
                <a href="{{ route('admin.home') }}">{{ config('app.name') }}</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>
</body>
@endsection

@push('before-scripts')
    <script type="text/javascript">
        $(() => {
            $('#dark-mode').on('change', function() {
                const darkMode = $(this).prop('checked');
                const body = $(document.body);
                const mainHeader = $('.main-header');
                const mainSidebar = $('.main-sidebar');
                if (darkMode) {
                    body.addClass('dark-mode');
                    mainHeader.addClass('navbar-dark').removeClass('navbar-white navbar-light');
                    mainSidebar.addClass('sidebar-dark-primary').removeClass('sidebar-light-primary');
                } else {
                    body.removeClass('dark-mode');
                    mainHeader.addClass('navbar-white navbar-light').removeClass('navbar-dark');
                    mainSidebar.addClass('sidebar-light-primary').removeClass('sidebar-dark-primary');
                }
                $.ajax({
                    url: '{{ route('admin.update-theme') }}',
                    method: 'POST',
                    data: {
                        darkMode: darkMode,
                    },
                });
            });
        });
    </script>
@endpush
