@extends('user.home.layouts')

@section('title', 'Members')

@push('after-styles')
    <style>
        .pagination {
            margin-bottom: 0;
        }
    </style>
@endpush

@section('home-content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('members') }}" method="GET">
                <div class="input-group">
                    <input type="search" name="q" value="{{ $keyword }}"
                           class="form-control" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-default" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                @foreach ($members as $member)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 pl-0 text-center">
                                        <img src="{{ $member['avatar'] }}" alt="Avatar"
                                             class="profile-user-img img-fluid img-circle">
                                    </div>
                                    <div class="col-7">
                                        <h3 class="lead font-weight-bold">
                                            {{ $member['given_name'].' '.$member['family_name'] }}
                                        </h3>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            @if ($member['email'])
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-envelope"></i></span>
                                                    <a href="mailto:{{ $member['email'] }}">{{ $member['email'] }}</a>
                                                </li>
                                            @endif
                                            @if ($member['phone'])
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-phone"></i></span>
                                                    <a href="tel:{{ $member['phone'] }}">{{ $member['phone'] }}</a>
                                                </li>
                                            @endif
                                            @if ($member['org_department'])
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-building"></i></span>
                                                    {{ $member['org_department'] }}
                                                </li>
                                            @endif
                                            @if ($member['org_title'])
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-briefcase"></i></span>
                                                    {{ $member['org_title'] }}
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            {{ $members->links() }}
        </div>
    </div>
@endsection
