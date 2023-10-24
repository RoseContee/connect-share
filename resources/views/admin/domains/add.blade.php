@extends('admin.layouts')

@php
$add = empty($domain);
$route = $add ? route('admin.domains.store') : route('admin.domains.update', $domain['id']);
$title = ($add ? 'Add' : 'Edit').' Domain';
$currentBanner = getBannerImage($domain['banner_image'] ?? null, $settings['banner_image'] ?? null);
@endphp

@section('title', $title)

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Domains</a></li>
                            <li class="breadcrumb-item active">{{ $add ? 'Add' : 'Edit' }}</li>
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
                        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!$add)
                                @method('PUT')
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    @if ($add)
                                        <div class="form-group">
                                            <label for="domain">Domain <span class="required">*</span></label>
                                            <input type="text" id="domain" name="domain" required
                                                   class="form-control @error('domain') is-invalid @enderror"
                                                   value="{{ old('domain') }}"
                                                   placeholder="Domain">
                                            @error('domain')
                                                <label for="domain" class="text-danger small mb-0 font-weight-normal">
                                                    {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="domain">Domain</label>
                                            <div class="form-control" readonly>{{ $domain['domain'] }}</div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" id="hide_banner" name="hide_banner"
                                                   class="form-check-input" value="1"
                                                @checked(!empty($domain['hide_banner']))>
                                            <label for="hide_banner" class="form-check-label font-weight-bold">
                                                Hide Banner
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="banner_image">Banner Image</label>
                                        <div class="banner mb-2">
                                            <img src="{{ $currentBanner }}"
                                                 alt="Banner"/>
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
                                        <label for="widgets">Widgets</label>
                                        @foreach ($widgets as $value => $widget)
                                            <div class="form-check @if (!$loop->last) mb-1 @endif">
                                                <input type="checkbox" id="widget-{{ $value }}" name="widgets[]"
                                                       class="form-check-input" value="{{ $value }}"
                                                    @checked(in_array($value, explode(',', $domain['widgets'] ?? '')))>
                                                <label for="widget-{{ $value }}" class="form-check-label">
                                                    {{ $widget }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('widgets')
                                            <label for="widgets" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                        @error('widgets.*')
                                            <label for="widgets" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    @if ($add || empty($domain['requested_email']))
                                        <div class="form-group">
                                            <label for="notify_to">Notify To</label>
                                            <input type="email" id="notify_to" name="notify_to"
                                                   class="form-control @error('notify_to') is-invalid @enderror"
                                                   value="{{ old('notify_to', $domain['notify_to'] ?? '') }}"
                                                   placeholder="Email">
                                            @error('notify_to')
                                                <label for="notify_to" class="text-danger small mb-0 font-weight-normal">
                                                    {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    @endif
                                    @if (!$add)
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            @php $old = old('status', in_array($domain['status'], ['active', 'pending'])); @endphp
                                            <select id="status" name="status"
                                                    class="form-control @error('status') is-invalid @enderror">
                                                <option value="1" @selected($old)>Active</option>
                                                <option value="0" @selected(!$old)>Block</option>
                                            </select>
                                            @error('status')
                                                <label for="status" class="text-danger small mb-0 font-weight-normal">
                                                    {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label for="reason">Reason <span class="required">*</span></label>
                                            <textarea id="reason" name="reason"
                                                      class="form-control @error('reason') is-invalid @enderror"
                                                      rows="5">{{ old('reason', $domain['reason']) }}</textarea>
                                            @error('reason')
                                                <label for="reason" class="text-danger small mb-0 font-weight-normal">
                                                    {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    @endif
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
            $('#banner_image').on('change', e => {
                imagePreview(e.target.files, $('#banner img'), '{{ $currentBanner }}');
            });

            @if (!$add)
            $('#status').on('change', onStatusChange);

            onStatusChange();
            @endif
        });

        @if (!$add)
        function onStatusChange () {
            const $reason = $('#reason');
            if ($('#status').val() == 1) {
                $reason.removeAttr('required').parent().hide();
            } else {
                $reason.attr('required', 'required').parent().show();
            }
        }
        @endif
    </script>
@endpush
