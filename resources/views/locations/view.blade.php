@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@push('css')
<style>
    #map {
        height: 400px;
        width: 100%;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Location Details</h1>
        <p class="mt-2">View location information</p>
    </div>
</div>
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
            Location Information
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Code</label>
                    <h4 class="h-16 fw-bold">{{ $location->code }}</h4>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Title</label>
                    <h4 class="h-16 fw-bold">{{ $location->title }}</h4>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="mb-4">
                    <label class="form-label">Address Line 1</label>
                    <p class="h-14">{{ $location->address_line_1 }}</p>
                </div>
            </div>
            @if($location->address_line_2)
            <div class="col-lg-12 col-md-12">
                <div class="mb-4">
                    <label class="form-label">Address Line 2</label>
                    <p class="h-14">{{ $location->address_line_2 }}</p>
                </div>
            </div>
            @endif
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Parish</label>
                    <p class="h-14">{{ $location->parish ? $location->parish->name : 'N/A' }}</p>
                </div>
            </div>
            @if($location->latitude && $location->longitude)
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Coordinates</label>
                    <p class="h-14">Lat: {{ $location->latitude }}, Lng: {{ $location->longitude }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@if($location->latitude && $location->longitude)
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/location-soute.svg') }}" alt="">
            Location on Map
        </h3>
    </div>
    <div class="content-inbox">
        <div id="map"></div>
    </div>
</div>
@endif
<div class="content-box">   
    <div class="save-draft">
        <div class="draaft-left">
            <a href="{{ route('locations.index') }}">
                <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                <span class="sz-18">Back to Locations</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('js')
@if($location->latitude && $location->longitude)
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', '') }}"></script>
<script>
$(document).ready(function() {
    const location = { lat: {{ $location->latitude }}, lng: {{ $location->longitude }} };
    
    const map = new google.maps.Map(document.getElementById('map'), {
        center: location,
        zoom: 15,
        mapTypeControl: true,
        streetViewControl: true
    });

    new google.maps.Marker({
        position: location,
        map: map,
        title: '{{ $location->title }}'
    });
});
</script>
@endif
@endpush

