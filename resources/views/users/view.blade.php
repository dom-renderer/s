@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">User Details</h1>
        <p class="mt-2">View user information and permissions</p>
    </div>
</div>
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
            User Information
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <a href="{{ $user->userprofile }}" target="_blank">
                        <img src="{{ $user->userprofile }}" alt="Profile" class="img-thumbnail" width="120">
                    </a>
                </div>
            </div>
            <div class="col-lg-9 col-md-6">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <label class="form-label">Name</label>
                        <h4 class="h-16 fw-bold">{{ $user->name }}</h4>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <label class="form-label">Email</label>
                        <p class="h-14">{{ $user->email }}</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <label class="form-label">Phone</label>
                        <p class="h-14">{{ $user->dial_code }} {{ $user->phone_number }}</p>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <label class="form-label">Status</label>
                        <div>
                            {!! $user->status ? '<span class="badge badge-c2">Active</span>' : '<span class="badge badge-c4">Inactive</span>' !!}
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 mb-4">
                        <label class="form-label">Roles</label>
                        <div>
                            @foreach($user->roles as $role)
                                <span class="badge badge-c1 me-2">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-box">   
    <div class="save-draft">
        <div class="draaft-left">
            <a href="{{ route('users.index') }}">
                <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                <span class="sz-18">Back to Users</span>
            </a>
        </div>
    </div>
</div>
@endsection
