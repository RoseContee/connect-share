@extends('admin.layouts')

@php
$add = empty($shortcut);
$route = $add ? route('admin.shortcuts.store') : route('admin.shortcuts.update', $shortcut['id']);
$title = ($add ? 'Add' : 'Edit').' Shortcut';
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.shortcuts.index') }}">Shortcuts</a></li>
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
                    <div class="col-lg-8">
                        <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!$add)
                                @method('PUT')
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="icon">Icon @if ($add)<span class="required">*</span>@endif</label>
                                        <div id="preview" class="ml-2 mb-2" @if ($add) style="display: none" @endif>
                                            <img src="{{ asset($shortcut['icon'] ?? '') }}" alt="icon"
                                                 class="icon-32" />
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" id="icon" name="icon" accept="image/*"
                                                   @if ($add) required @endif
                                                   class="custom-file-input @error('icon') is-invalid @enderror">
                                            <label for="icon" class="custom-file-label">Choose file</label>
                                        </div>
                                        @error('icon')
                                            <label for="icon" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title <span class="required">*</span></label>
                                        <input type="text" id="title" name="title" required
                                               class="form-control @error('title') is-invalid @enderror"
                                               value="{{ old('title', $shortcut['title'] ?? '') }}"
                                               placeholder="Title">
                                        @error('title')
                                            <label for="title" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="link">Link <span class="required">*</span></label>
                                        <input type="url" id="link" name="link" required
                                               class="form-control @error('link') is-invalid @enderror"
                                               value="{{ old('link', $shortcut['link'] ?? '') }}"
                                               placeholder="Link">
                                        @error('link')
                                            <label for="link" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        @php $old = old('status', $shortcut['active'] ?? 1); @endphp
                                        <select id="status" name="status"
                                                class="form-control @error('status') is-invalid @enderror">
                                            <option value="1" @selected($old)>Enable</option>
                                            <option value="0" @selected(!$old)>Disable</option>
                                        </select>
                                        @error('status')
                                            <label for="status" class="text-danger small mb-0 font-weight-normal">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('admin.shortcuts.index') }}" class="btn btn-danger ml-2">Cancel</a>
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
            $('#icon').on('change', e => {
                const files = (e.target || window.event.srcElement).files;
                if (FileReader && files && files.length) {
                    const fr = new FileReader();
                    fr.onload = function () {
                        $('#preview').show().find('img').attr('src', fr.result);
                    }
                    fr.readAsDataURL(files[0]);
                }
            });
        });
    </script>
@endpush
