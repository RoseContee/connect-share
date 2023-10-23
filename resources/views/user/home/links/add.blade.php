@extends('user.home.layouts')

@php
$user = request()->user();
$add = empty($link);
$route = $add ? route('useful-links.store') : route('useful-links.update', $link['id']);
@endphp

@section('title', ($add ? 'Add' : 'Edit').' Useful Links')

@section('home-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $add ? 'Add' : 'Edit' }} Link</h3>
                </div>
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @if (!$add)
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        <div class="form-group">
                            <label for="link">Link <span class="required">*</span></label>
                            <input type="url" id="link" name="link" required
                                   class="form-control @error('link') is-invalid @enderror"
                                   value="{{ old('link', $link['link'] ?? '') }}"
                                   placeholder="Enter Link">
                            @error('link')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description"
                                   class="form-control @error('description') is-invalid @enderror"
                                   value="{{ old('description', $link['description'] ?? '') }}"
                                   placeholder="Enter Description">
                            @error('description')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                        <a href="{{ route('useful-links.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
