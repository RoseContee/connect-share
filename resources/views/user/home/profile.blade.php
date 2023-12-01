@extends('user.home.layouts')

@php
$user = request()->user();
@endphp

@section('title', 'Profile')

@section('home-content')
    <div class="row">
        <div class="col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ $user['avatar'] }}" alt="Avatar"
                             class="profile-user-img img-fluid img-circle">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 py-1">
                            <div class="row">
                                <div class="col-4"><b>Given Name:</b></div>
                                <div class="col-8">{{ $user['given_name'] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-1">
                            <div class="row">
                                <div class="col-4"><b>Surname:</b></div>
                                <div class="col-8">{{ $user['family_name'] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-1">
                            <div class="row">
                                <div class="col-4"><b>Title:</b></div>
                                <div class="col-8">{{ $user['org_title'] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-1">
                            <div class="row">
                                <div class="col-4"><b>Department:</b></div>
                                <div class="col-8">{{ $user['org_department'] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-1">
                            <div class="row">
                                <div class="col-4"><b>Email:</b></div>
                                <div class="col-8">{{ $user['email'] }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-1">
                            <div class="row">
                                <div class="col-4"><b>Phone:</b></div>
                                <div class="col-8">{{ $user['phone'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
