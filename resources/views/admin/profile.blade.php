@extends('admin.layouts')

@section('title', 'Profile')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                @include('partials.messages')

                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('admin.update-email') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Update Account Email</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Current Email</label>
                                        <div class="form-control" readonly>{{ auth()->user()->email }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">New Email <span class="required">*</span></label>
                                        <input type="email" id="email" name="email"
                                               class="form-control @error('email', 'email') is-invalid @enderror"
                                               value="{{ old('email', $settings['email'] ?? '') }}"
                                               placeholder="New Email" required>
                                        @error('email', 'email')
                                            <label for="email" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="current_password">Password <span class="required">*</span></label>
                                        <input type="password" id="current_password" name="password"
                                               class="form-control @error('password', 'email') is-invalid @enderror"
                                               placeholder="Password" required>
                                        @error('password', 'email')
                                            <label for="current_password" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <form action="{{ route('admin.update-password') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Update Password</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="old_password">Old Password <span class="required">*</span></label>
                                        <input type="password" id="old_password" name="old_password"
                                               class="form-control @error('old_password', 'password') is-invalid @enderror"
                                               placeholder="Current Password" required>
                                        @error('old_password', 'password')
                                            <label for="old_password" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password <span class="required">*</span></label>
                                        <input type="password" id="password" name="password"
                                               class="form-control @error('password', 'password') is-invalid @enderror"
                                               placeholder="Password" required>
                                        @error('password', 'password')
                                            <label for="password" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="form-control"
                                               placeholder="Confirm Password" required>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
