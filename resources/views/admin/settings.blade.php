@extends('admin.layouts')

@section('title', 'Admin Settings')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Settings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
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
                    <div class="col-lg-12">
                        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="favicon">Favicon</label>
                                        <div class="ml-2 mb-2">
                                            <img src="{{ getFavicon($settings['favicon'] ?? null) }}" alt="favicon"
                                                 style="width: 40px; height: 40px;" />
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" id="favicon" name="favicon" accept="image/*"
                                                   class="custom-file-input @error('favicon') is-invalid @enderror">
                                            <label for="favicon" class="custom-file-label">Choose file</label>
                                        </div>
                                        @error('favicon')
                                            <label for="favicon" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    {{--<div class="form-group">
                                        <label for="logo">Logo</label>
                                        <div class="ml-2 mb-2">
                                            <img src="{{ getLogo($settings['logo'] ?? null) }}" alt="logo"
                                                 style="width: 200px; height: 40px;" />
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" id="logo" name="logo" accept="image/*"
                                                   class="custom-file-input @error('logo') is-invalid @enderror">
                                            <label for="logo" class="custom-file-label">Choose file</label>
                                        </div>
                                        @error('logo')
                                            <label for="logo" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_email">Contact Email <span class="required">*</span></label>
                                        <input type="text" id="contact_email" name="contact_email" required
                                               class="form-control @error('contact_email') is-invalid @enderror"
                                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                               placeholder="Contact Email">
                                        @error('contact_email')
                                            <label for="contact_email" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_phone">Contact Phone <span class="required">*</span></label>
                                        <input type="text" id="contact_phone" name="contact_phone" required
                                               class="form-control @error('contact_phone') is-invalid @enderror"
                                               value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                                               placeholder="Contact Phone">
                                        @error('contact_phone')
                                            <label for="contact_phone" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>--}}
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" id="hide_banner" name="hide_banner"
                                                   class="form-check-input" value="1"
                                                   @if ($settings['hide_banner']) checked @endif>
                                            <label for="hide_banner" class="form-check-label">Hide Banner</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="banner_image">Banner Image</label>
                                        <div class="banner mb-2"
                                             style="background-image: url('{{ getBannerImage($settings['banner_image'] ?? null) }}')">
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" id="banner_image" name="banner_image" accept="image/*"
                                                   class="custom-file-input @error('banner_image') is-invalid @enderror">
                                            <label for="banner_image" class="custom-file-label">Choose file</label>
                                        </div>
                                        @error('banner_image')
                                            <label for="banner_image" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" id="shortcut" name="shortcut"
                                                   class="form-check-input" value="1"
                                                   @if ($settings['shortcut']) checked @endif>
                                            <label for="shortcut" class="form-check-label">Show Shortcuts</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
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

@push('scripts')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script type="text/javascript">
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endpush
