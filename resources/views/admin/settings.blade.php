@extends('admin.layouts')

@section('title', 'Admin Settings')

@php
$currentFavicon = getFavicon($settings['favicon'] ?? null);
$currentLogo = getLogo($settings['logo'] ?? null);
$currentHomeBanner = getDefaultBannerImage($settings['home_banner_image'] ?? null);
$currentProfileBanner = getDefaultBannerImage($settings['profile_banner_image'] ?? null);
@endphp

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
                                            <img id="favicon-preview" src="{{ $currentFavicon }}"
                                                 alt="favicon"
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
                                            <img id="logo-preview" src="{{ $currentLogo }}"
                                                 alt="logo"
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
                                    </div>--}}
                                    <div class="form-group">
                                        <label for="contact_email">Contact Email <span class="required">*</span></label>
                                        <input type="email" id="contact_email" name="contact_email" required
                                               class="form-control @error('contact_email') is-invalid @enderror"
                                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                               placeholder="Contact Email">
                                        @error('contact_email')
                                            <label for="contact_email" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    {{--<div class="form-group">
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
                                        <label for="home_banner_title">Default Home Banner Title <span class="required">*</span></label>
                                        <input type="text" id="home_banner_title" name="home_banner_title" required
                                               class="form-control @error('home_banner_title') is-invalid @enderror"
                                               value="{{ old('home_banner_title', $settings['home_banner_title'] ?? '') }}"
                                               placeholder="Home Banner Title">
                                        @error('home_banner_title')
                                            <label for="home_banner_title" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="home_banner_image">Default Home Banner Image</label>
                                        <div class="banner mb-2">
                                            <img src="{{ $currentHomeBanner }}"
                                                 alt="Banner Image" />
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" id="home_banner_image" name="home_banner_image" accept="image/*"
                                                   class="custom-file-input @error('home_banner_image') is-invalid @enderror">
                                            <label for="home_banner_image" class="custom-file-label">Choose file</label>
                                        </div>
                                        @error('home_banner_image')
                                            <label for="home_banner_image" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" id="hide_profile_banner" name="hide_profile_banner"
                                                class="form-check-input" value="1"
                                                @checked($settings['hide_profile_banner'])>
                                            <label for="hide_profile_banner" class="form-check-label font-weight-bold">
                                                Hide Profile Banner
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_banner_image">Default Profile Banner Image</label>
                                        <div class="banner mb-2">
                                            <img src="{{ $currentProfileBanner }}"
                                                 alt="Banner Image" />
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" id="profile_banner_image" name="profile_banner_image" accept="image/*"
                                                   class="custom-file-input @error('profile_banner_image') is-invalid @enderror">
                                            <label for="profile_banner_image" class="custom-file-label">Choose file</label>
                                        </div>
                                        @error('profile_banner_image')
                                            <label for="profile_banner_image" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" id="shortcut" name="shortcut"
                                                class="form-check-input" value="1"
                                                @checked($settings['shortcut'])>
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

@push('after-scripts')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script type="text/javascript">
        $(() => {
            bsCustomFileInput.init();
        });
    </script>

    <script type="text/javascript">
        $(() => {
            $('#favicon').on('change', e => {
                imagePreview(e.target.files, $('#favicon-preview'), '{{ $currentFavicon }}');
            });

            /*$('#logo').on('change', e => {
                imagePreview(e.target.files, $('#logo-preview'), '{{ $currentLogo }}');
            });*/

            $('#home_banner_image').on('change', e => {
                imagePreview(e.target.files, $('.banner').find('img'), '{{ $currentHomeBanner }}');
            });

            $('#profile_banner_image').on('change', e => {
                imagePreview(e.target.files, $('.banner').find('img'), '{{ $currentProfileBanner }}');
            });
        });
    </script>
@endpush
