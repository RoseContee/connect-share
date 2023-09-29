@extends('user.layouts')

@section('title', 'Install users')

@section('content')
    <div class="container">
        @include('partials.full-loading', ['text' => 'Installing...'])
        <div class="align-center text-center">
            <h1 class="mb-5">Almost Done!</h1>
            <h4 class="mb-3">Install domain users in the workspace.</h4>
            <form action="{{ route('intranet.setup.users') }}" method="POST"
                  onsubmit="showFullLoading()">
                @csrf
                <button type="submit" class="btn btn-primary">
                    Install <i class="fa fa-arrow-circle-right"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
