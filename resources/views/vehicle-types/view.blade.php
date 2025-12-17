@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Vehicle Type Details</h1>
        <p class="mt-2">View vehicle type information</p>
    </div>
</div>
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
            Vehicle Type Information
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Title</label>
                    <h4 class="h-16 fw-bold">{{ $vehicleType->title }}</h4>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <div>
                        {!! $vehicleType->status ? '<span class="badge badge-c2">Active</span>' : '<span class="badge badge-c4">Inactive</span>' !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <p class="h-14">{{ $vehicleType->description ?: 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-box">   
    <div class="save-draft">
        <div class="draaft-left">
            <a href="{{ route('vehicle-types.index') }}">
                <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                <span class="sz-18">Back to Vehicle Types</span>
            </a>
        </div>
    </div>
</div>
@endsection

