@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@push('css')
<style>
    label.error {
        color: red;
    }
    .content-inbox input.form-control {
        margin-bottom: 20px;
    }
    .content-inbox .form-select {
        margin-bottom: 20px;
    }
    .content-inbox textarea.form-control {
        margin-bottom: 20px;
    }
    #map {
        height: 400px;
        width: 100%;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .map-search-box {
        margin-bottom: 15px;
    }
    .map-search-box input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Edit Location</h1>
        <p class="mt-2">Update location details and coordinates</p>
    </div>
</div>
<form id="locationForm" method="POST" action="{{ route('locations.update', encrypt($location->id)) }}">
    @csrf
    @method('PUT')
    <div class="content-box">
        <div class="head-content">
            <h3 class="h-16 fw-bold">
                <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
                Basic Information
            </h3>
        </div>
        <div class="content-inbox">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $location->code) }}" placeholder="Enter location code" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $location->title) }}" placeholder="Enter location title" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="mb-4">
                        <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('address_line_1') is-invalid @enderror" id="address_line_1" name="address_line_1" value="{{ old('address_line_1', $location->address_line_1) }}" placeholder="Enter address line 1" required>
                        @error('address_line_1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="mb-4">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" class="form-control @error('address_line_2') is-invalid @enderror" id="address_line_2" name="address_line_2" value="{{ old('address_line_2', $location->address_line_2) }}" placeholder="Enter address line 2">
                        @error('address_line_2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Parish</label>
                        <select class="form-select custom-select-arrow select2 @error('parish_id') is-invalid @enderror" id="parish_id" name="parish_id">
                            <option value="">Select Parish</option>
                            @foreach($parishes as $id => $name)
                                <option value="{{ $id }}" {{ old('parish_id', $location->parish_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('parish_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-box">
        <div class="head-content">
            <h3 class="h-16 fw-bold">
                <img src="{{ asset('ui/images/location-soute.svg') }}" alt="">
                Location on Map
            </h3>
        </div>
        <div class="content-inbox">
            <div class="map-search-box">
                <input type="text" id="map-search" placeholder="Search for a location on the map..." class="form-control">
            </div>
            <div id="map"></div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Latitude</label>
                        <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $location->latitude) }}" placeholder="Latitude" readonly>
                        @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Longitude</label>
                        <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $location->longitude) }}" placeholder="Longitude" readonly>
                        @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-box">   
        <div class="save-draft">
            <div class="draaft-left">
                <a href="{{ route('locations.index') }}">
                    <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                    <span class="sz-18">Back to Locations</span>
                </a>
            </div>
            <div class="draft-rgt">
                <a href="{{ route('locations.index') }}" class="btn btn-gen bg-btn1">Cancel</a>
                <button type="submit" class="btn btn-gen bg-btn3">Update Location</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('assets/js/jquery-validate.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', '') }}&libraries=places"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for Parish
    $('#parish_id').select2({
        placeholder: 'Select parish',
        width: '100%',
        allowClear: true
    });

    // Initialize Google Map
    let map;
    let marker;
    let geocoder;
    let autocomplete;

    function initMap() {
        // Use existing coordinates or default center (Barbados)
        const existingLat = parseFloat($('#latitude').val());
        const existingLng = parseFloat($('#longitude').val());
        const defaultCenter = existingLat && existingLng 
            ? { lat: existingLat, lng: existingLng }
            : { lat: 13.1939, lng: -59.5432 };
        
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultCenter,
            zoom: existingLat && existingLng ? 15 : 12,
            mapTypeControl: true,
            streetViewControl: true
        });

        geocoder = new google.maps.Geocoder();

        // Initialize autocomplete for search box
        autocomplete = new google.maps.places.Autocomplete(document.getElementById('map-search'));
        autocomplete.bindTo('bounds', map);

        // When a place is selected from autocomplete
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            setMarker(place.geometry.location);
        });

        // Add click listener to map
        map.addListener('click', function(event) {
            setMarker(event.latLng);
        });

        // Set marker if coordinates exist
        if (existingLat && existingLng) {
            const existingLocation = { lat: existingLat, lng: existingLng };
            setMarker(existingLocation);
        }
    }

    function setMarker(location) {
        if (marker) {
            marker.setPosition(location);
        } else {
            marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true
            });

            // Add drag listener
            marker.addListener('dragend', function(event) {
                updateCoordinates(event.latLng);
            });
        }

        map.setCenter(location);
        updateCoordinates(location);
    }

    function updateCoordinates(location) {
        $('#latitude').val(location.lat().toFixed(8));
        $('#longitude').val(location.lng().toFixed(8));
    }

    // Initialize map when Google Maps API is loaded
    if (typeof google !== 'undefined' && google.maps) {
        initMap();
    } else {
        // Retry after a short delay
        setTimeout(initMap, 500);
    }

    // Form validation
    $('#locationForm').validate({
        rules: {
            code: { 
                required: true,
                maxlength: 255
            },
            title: { 
                required: true,
                maxlength: 255
            },
            address_line_1: {
                required: true,
                maxlength: 255
            },
            address_line_2: {
                maxlength: 255
            },
            latitude: {
                number: true
            },
            longitude: {
                number: true
            }
        },
        messages: {
            code: {
                required: "The code field is required.",
                maxlength: "Code cannot exceed 255 characters."
            },
            title: {
                required: "The title field is required.",
                maxlength: "Title cannot exceed 255 characters."
            },
            address_line_1: {
                required: "The address line 1 field is required.",
                maxlength: "Address line 1 cannot exceed 255 characters."
            },
            address_line_2: {
                maxlength: "Address line 2 cannot exceed 255 characters."
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent());
        },
        submitHandler: function (form) {
            $('body').find('.LoaderSec').removeClass('d-none');
            form.submit();
        }
    });

    // Check for duplicate code on blur
    $('#code').on('blur', function() {
        let code = $(this).val();
        let currentId = {{ $location->id }};
        if (code) {
            $.ajax({
                url: "{{ route('locations.check-duplicate') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    code: code,
                    id: currentId
                },
                success: function(response) {
                    if (response.exists) {
                        $('#code').addClass('is-invalid');
                        if ($('#code').next('.invalid-feedback').length === 0) {
                            $('#code').after('<div class="invalid-feedback">This location code already exists.</div>');
                        }
                    } else {
                        $('#code').removeClass('is-invalid');
                        $('#code').next('.invalid-feedback').remove();
                    }
                }
            });
        }
    });
});
</script>
@endpush

