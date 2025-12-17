@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Vehicle Details</h1>
        <p class="mt-2">View vehicle information</p>
    </div>
</div>

<!-- Basic Information Section -->
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
            Basic Information
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Vehicle Name</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->vehicle_name }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Make</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->make }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Model</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->model }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Year</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->year }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Vehicle Class</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->vehicleClass ? $vehicle->vehicleClass->title : 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Transmission</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->transmission ? $vehicle->transmission->title : 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Fuel Type</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->fuel_type ?: 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Seats</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->seats ?: 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Doors</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->doors ?: 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Passengers</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->passengers ?: 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Luggage Capacity</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->luggage_capacity ?: 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Other</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->other ?: 'N/A' }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Commercial Settings Section -->
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="" style="filter: hue-rotate(120deg);">
            Commercial Settings
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Base Cost (per day)</label>
                    <h4 class="h-16 fw-bold">${{ number_format($vehicle->base_cost_per_day, 2) }} USD</h4>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">VAT Percentage</label>
                    <h4 class="h-16 fw-bold">{{ number_format($vehicle->vat_percentage, 2) }}%</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Images Section -->
@if($vehicle->images && count($vehicle->images) > 0)
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="" style="filter: hue-rotate(30deg);">
            Vehicle Images
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            @foreach($vehicle->images as $image)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <img src="{{ Storage::url($image) }}" alt="Vehicle Image" class="img-fluid" style="border-radius: 8px; border: 1px solid #ddd;">
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Location Assignment Section -->
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="" style="filter: hue-rotate(0deg) brightness(1.2) saturate(1.5);">
            Location Assignment
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Primary Pickup Location</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->primaryPickupLocation ? $vehicle->primaryPickupLocation->title : 'N/A' }}</h4>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Alternate Pickup Location</label>
                    <h4 class="h-16 fw-bold">{{ $vehicle->alternate_pickup_location ?: 'N/A' }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status -->
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">Status</h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <div>
                        {!! $vehicle->status ? '<span class="badge badge-c2">Active</span>' : '<span class="badge badge-c4">Inactive</span>' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-box">   
    <div class="save-draft">
        <div class="draaft-left">
            <a href="{{ route('vehicles.index') }}">
                <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                <span class="sz-18">Back to Vehicles</span>
            </a>
        </div>
    </div>
</div>
@endsection
