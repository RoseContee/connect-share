@extends('user.home.layouts')

@section('title', 'Profile')

@php
$currentBanner = getBannerImage($userSettings['home_banner_image'], $settings['home_banner_image'] ?? null);
@endphp

@section('home-content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('settings.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Current Title</label>
                            <div class="form-control" readonly>{{ $userSettings['home_banner_title'] ?? $settings['home_banner_title'] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="banner_title">Banner Title</label>
                            <input type="text" id="banner_title" name="banner_title"
                                   class="form-control @error('banner_title') is-invalid @enderror"
                                   value="{{ old('banner_title') }}"
                                   placeholder="Banner Title">
                            @error('banner_title')
                                <label for="banner_title" class="text-danger small mb-0 font-weight-normal">
                                    {{ $message }}
                                </label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="banner_image">Banner Image</label>
                            <div class="banner mb-2">
                                <img src="{{ $currentBanner }}"
                                     alt="Banner Image" />
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
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
            $('#banner_image').on('change', e => {
                imagePreview(e.target.files, $('.banner').find('img'), '{{ $currentBanner }}');
            });
        });
    </script>
@endpush
