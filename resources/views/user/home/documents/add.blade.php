@extends('user.home.layouts')

@php
$user = auth()->user();
$add = empty($document);
$route = $add ? route('documents.store') : route('documents.update', $document['id']);
@endphp

@section('title', ($add ? 'Add' : 'Edit').' Document')

@section('home-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $add ? 'Add' : 'Edit' }} Document</h3>
                </div>
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @if (!$add)
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title <span class="required">*</span></label>
                            <input type="text" id="title" name="title" required
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $document['title'] ?? '') }}"
                                   placeholder="Enter Title">
                            @error('title')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="link">Link <span class="required">*</span></label>
                            <input type="url" id="link" name="link" required
                                   class="form-control @error('link') is-invalid @enderror"
                                   value="{{ old('link', $document['link'] ?? '') }}"
                                   placeholder="Enter Link">
                            @error('link')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description"
                                   class="form-control @error('description') is-invalid @enderror"
                                   value="{{ old('description', $document['description'] ?? '') }}"
                                   placeholder="Enter Description">
                            @error('description')
                                <div class="small text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                        <a href="{{ route('documents.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
