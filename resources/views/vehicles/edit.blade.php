@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle, 'select2' => true])

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
    .image-upload-area {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        background-color: #f9f9f9;
        cursor: pointer;
        transition: all 0.3s;
    }
    .image-upload-area:hover {
        border-color: #007bff;
        background-color: #f0f8ff;
    }
    .image-upload-area.dragover {
        border-color: #007bff;
        background-color: #e7f3ff;
    }
    .upload-icon {
        font-size: 48px;
        color: #999;
        margin-bottom: 15px;
    }
    .image-preview-container {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .image-preview-item {
        width: 150px;
        height: 150px;
        border: 1px solid #ddd;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
        background-color: #f5f5f5;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-preview-item .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 0, 0, 0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
        font-size: 14px;
    }
    .image-preview-item.empty {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
    }
</style>
@endpush

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Edit Vehicle</h1>
        <p class="mt-2">Update vehicle details, pricing, and availability settings</p>
    </div>
</div>
<form id="vehicleForm" method="POST" action="{{ route('vehicles.update', encrypt($vehicle->id)) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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
                        <label class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('vehicle_name') is-invalid @enderror" id="vehicle_name" name="vehicle_name" value="{{ old('vehicle_name', $vehicle->vehicle_name) }}" placeholder="e.g Toyota Yaris" required>
                        @error('vehicle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Make <span class="text-danger">*</span></label>
                        <select class="form-select custom-select-arrow @error('make') is-invalid @enderror" id="make" name="make" required>
                            <option value="">Select Make</option>
                            @foreach($makes as $makeOption)
                                <option value="{{ $makeOption }}" {{ old('make', $vehicle->make) == $makeOption ? 'selected' : '' }}>{{ $makeOption }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control mt-2" id="make_new" name="make_new" value="{{ old('make_new') }}" placeholder="Or type new make" style="display: {{ old('make', $vehicle->make) ? 'none' : 'block' }};">
                        @error('make')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Model <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model', $vehicle->model) }}" placeholder="e.g Yaris" required>
                        @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Year <span class="text-danger">*</span></label>
                        <select class="form-select custom-select-arrow @error('year') is-invalid @enderror" id="year" name="year" required>
                            <option value="">Search Year</option>
                            @foreach($years as $yearOption)
                                <option value="{{ $yearOption }}" {{ old('year', $vehicle->year) == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                            @endforeach
                        </select>
                        @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Vehicle Class</label>
                        <select class="form-select custom-select-arrow @error('vehicle_class_id') is-invalid @enderror" id="vehicle_class_id" name="vehicle_class_id">
                            <option value="">Search Class</option>
                            @foreach($vehicleClasses as $class)
                                <option value="{{ $class->id }}" {{ old('vehicle_class_id', $vehicle->vehicle_class_id) == $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                            @endforeach
                        </select>
                        @error('vehicle_class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Transmission</label>
                        <select class="form-select custom-select-arrow @error('transmission_id') is-invalid @enderror" id="transmission_id" name="transmission_id">
                            <option value="">Search Transmission</option>
                            @foreach($transmissions as $transmission)
                                <option value="{{ $transmission->id }}" {{ old('transmission_id', $vehicle->transmission_id) == $transmission->id ? 'selected' : '' }}>{{ $transmission->title }}</option>
                            @endforeach
                        </select>
                        @error('transmission_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Fuel Type</label>
                        <select class="form-select custom-select-arrow @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type">
                            <option value="">Search Fuel Type</option>
                            @foreach($fuelTypes as $fuelType)
                                <option value="{{ $fuelType }}" {{ old('fuel_type', $vehicle->fuel_type) == $fuelType ? 'selected' : '' }}>{{ $fuelType }}</option>
                            @endforeach
                        </select>
                        <input type="text" class="form-control mt-2" id="fuel_type_new" name="fuel_type_new" value="{{ old('fuel_type_new') }}" placeholder="Or type new fuel type" style="display: {{ old('fuel_type', $vehicle->fuel_type) ? 'none' : 'block' }};">
                        @error('fuel_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Seats</label>
                        <select class="form-select custom-select-arrow @error('seats') is-invalid @enderror" id="seats" name="seats">
                            <option value="">Search Seats</option>
                            @foreach($seats as $seatOption)
                                <option value="{{ $seatOption }}" {{ old('seats', $vehicle->seats) == $seatOption ? 'selected' : '' }}>{{ $seatOption }}</option>
                            @endforeach
                        </select>
                        @error('seats')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Doors</label>
                        <select class="form-select custom-select-arrow @error('doors') is-invalid @enderror" id="doors" name="doors">
                            <option value="">Search Doors</option>
                            @foreach($doors as $doorOption)
                                <option value="{{ $doorOption }}" {{ old('doors', $vehicle->doors) == $doorOption ? 'selected' : '' }}>{{ $doorOption }}</option>
                            @endforeach
                        </select>
                        @error('doors')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Passengers</label>
                        <input type="number" class="form-control @error('passengers') is-invalid @enderror" id="passengers" name="passengers" value="{{ old('passengers', $vehicle->passengers) }}" placeholder="Passengers" min="1">
                        @error('passengers')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Luggage Capacity</label>
                        <input type="text" class="form-control @error('luggage_capacity') is-invalid @enderror" id="luggage_capacity" name="luggage_capacity" value="{{ old('luggage_capacity', $vehicle->luggage_capacity) }}" placeholder="Capacity">
                        @error('luggage_capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Other</label>
                        <input type="text" class="form-control @error('other') is-invalid @enderror" id="other" name="other" value="{{ old('other', $vehicle->other) }}" placeholder="Type here">
                        @error('other')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        <label class="form-label">Base Cost (per day) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control @error('base_cost_per_day') is-invalid @enderror" id="base_cost_per_day" name="base_cost_per_day" value="{{ old('base_cost_per_day', $vehicle->base_cost_per_day) }}" placeholder="0.00" min="0" required>
                            <span class="input-group-text">USD</span>
                        </div>
                        @error('base_cost_per_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">VAT Percentage <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control @error('vat_percentage') is-invalid @enderror" id="vat_percentage" name="vat_percentage" value="{{ old('vat_percentage', $vehicle->vat_percentage) }}" placeholder="29" min="0" max="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                        @error('vat_percentage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Images Section -->
    <div class="content-box">
        <div class="head-content">
            <h3 class="h-16 fw-bold">
                <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="" style="filter: hue-rotate(30deg);">
                Vehicle Images
            </h3>
        </div>
        <div class="content-inbox">
            <div class="image-upload-area" id="imageUploadArea">
                <div class="upload-icon">
                    <i class="bi bi-cloud-upload" style="font-size: 48px; color: #999;"></i>
                </div>
                <h4>Upload Vehicle Images</h4>
                <p>Drag & drop images here, or click to browse</p>
                <button type="button" class="btn btn-primary mt-3" id="browseFilesBtn">Browse Files</button>
                <input type="file" id="images" name="images[]" multiple accept="image/*" style="display: none;">
            </div>
            <div class="image-preview-container" id="imagePreviewContainer">
                @if($vehicle->images && count($vehicle->images) > 0)
                    @foreach($vehicle->images as $index => $image)
                        <div class="image-preview-item">
                            <img src="{{ Storage::url($image) }}" alt="Vehicle Image">
                            <button type="button" class="remove-image" data-image-path="{{ $image }}">&times;</button>
                            <input type="hidden" name="existing_images[]" value="{{ $image }}">
                        </div>
                    @endforeach
                    @for($i = count($vehicle->images); $i < 3; $i++)
                        <div class="image-preview-item empty"></div>
                    @endfor
                @else
                    <div class="image-preview-item empty"></div>
                    <div class="image-preview-item empty"></div>
                    <div class="image-preview-item empty"></div>
                @endif
            </div>
        </div>
    </div>

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
                        <select class="form-select custom-select-arrow @error('primary_pickup_location_id') is-invalid @enderror" id="primary_pickup_location_id" name="primary_pickup_location_id">
                            <option value="">Select Primary Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('primary_pickup_location_id', $vehicle->primary_pickup_location_id) == $location->id ? 'selected' : '' }}>{{ $location->title }}</option>
                            @endforeach
                        </select>
                        @error('primary_pickup_location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Alternate Pickup Location</label>
                        <input type="text" class="form-control @error('alternate_pickup_location') is-invalid @enderror" id="alternate_pickup_location" name="alternate_pickup_location" value="{{ old('alternate_pickup_location', $vehicle->alternate_pickup_location) }}" placeholder="Type Alternate location">
                        @error('alternate_pickup_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Actions -->
    <div class="content-box">   
        <div class="save-draft">
            <div class="draaft-left">
                <a href="{{ route('vehicles.index') }}">
                    <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                    <span class="sz-18">Back to Vehicles</span>
                </a>
            </div>
            <div class="draft-rgt">
                <a href="{{ route('vehicles.index') }}" class="btn btn-gen bg-btn1">Cancel</a>
                <button type="submit" name="action" value="sync" class="btn btn-gen bg-btn2">
                    <i class="bi bi-arrow-repeat"></i> Save & Sync
                </button>
                <button type="submit" name="action" value="save" class="btn btn-gen bg-btn3">Update Vehicle</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script src="{{ asset('assets/js/jquery-validate.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for dropdowns
    $('#make, #year, #vehicle_class_id, #transmission_id, #fuel_type, #seats, #doors, #primary_pickup_location_id').select2({
        placeholder: function() {
            return $(this).data('placeholder') || 'Select an option';
        },
        allowClear: true,
        width: '100%'
    });

    // Allow typing new values for make and fuel_type
    $('#make').on('select2:open', function() {
        setTimeout(() => {
            if ($('#make').val() === '') {
                $('#make_new').show();
            }
        }, 100);
    });

    $('#make_new').on('input', function() {
        if ($(this).val()) {
            $('#make').val(null).trigger('change');
        }
    });

    $('#make').on('change', function() {
        if ($(this).val()) {
            $('#make_new').hide().val('');
        } else {
            $('#make_new').show();
        }
    });

    $('#fuel_type').on('select2:open', function() {
        setTimeout(() => {
            if ($('#fuel_type').val() === '') {
                $('#fuel_type_new').show();
            }
        }, 100);
    });

    $('#fuel_type_new').on('input', function() {
        if ($(this).val()) {
            $('#fuel_type').val(null).trigger('change');
        }
    });

    $('#fuel_type').on('change', function() {
        if ($(this).val()) {
            $('#fuel_type_new').hide().val('');
        } else {
            $('#fuel_type_new').show();
        }
    });

    // Image upload handling
    let imageFiles = [];
    const maxImages = 3;
    let existingImages = [];

    // Store existing images
    $('input[name="existing_images[]"]').each(function() {
        existingImages.push($(this).val());
    });

    // Handle browse button click
    $('#browseFilesBtn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const fileInput = document.getElementById('images');
        if (fileInput) {
            fileInput.click();
        }
    });

    // Handle upload area click (but not if clicking the button or file input)
    $('#imageUploadArea').on('click', function(e) {
        // Don't trigger if clicking the button or file input
        if ($(e.target).closest('#browseFilesBtn').length || $(e.target).is('#images')) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        const fileInput = document.getElementById('images');
        if (fileInput) {
            fileInput.click();
        }
    });

    // Prevent file input from triggering the upload area click
    $('#images').on('click', function(e) {
        e.stopPropagation();
    });

    $('#images').on('change', function(e) {
        handleFiles(e.target.files);
    });

    $('#imageUploadArea').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $('#imageUploadArea').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });

    $('#imageUploadArea').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        handleFiles(e.originalEvent.dataTransfer.files);
    });

    function handleFiles(files) {
        if (!files || files.length === 0) return;
        
        Array.from(files).forEach(file => {
            if (file.type && file.type.startsWith('image/') && (imageFiles.length + existingImages.length) < maxImages) {
                imageFiles.push(file);
                displayImagePreview(file, imageFiles.length - 1);
            }
        });
        
        // Reset the file input to allow selecting the same file again if needed
        $('#images').val('');
    }

    function displayImagePreview(file, index) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = $('#imagePreviewContainer');
            const emptyItems = container.find('.image-preview-item.empty');
            
            if (emptyItems.length > 0) {
                const item = emptyItems.first();
                item.removeClass('empty').html(`
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-image" data-index="${index}">&times;</button>
                `);
            } else {
                container.append(`
                    <div class="image-preview-item">
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-image" data-index="${index}">&times;</button>
                    </div>
                `);
            }
        };
        reader.readAsDataURL(file);
    }

    $(document).on('click', '.remove-image', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const imagePath = $(this).data('image-path');
        const index = $(this).data('index');
        
        if (imagePath) {
            // Remove existing image
            existingImages = existingImages.filter(img => img !== imagePath);
            $(this).closest('.image-preview-item').find('input[name="existing_images[]"]').remove();
            $(this).closest('.image-preview-item').removeClass('empty').html('').addClass('empty');
            
            // Add hidden input to mark for deletion
            $('<input>').attr({
                type: 'hidden',
                name: 'delete_images[]',
                value: imagePath
            }).appendTo('#vehicleForm');
        } else if (index !== undefined && imageFiles[index]) {
            // Remove new image
            imageFiles.splice(index, 1);
            $(this).closest('.image-preview-item').removeClass('empty').html('').addClass('empty');
            updateFileInput();
            updatePreviewIndexes();
        }
    });

    function updateFileInput() {
        // Note: We can't directly manipulate file input files in all browsers
        // The files will be submitted with the form when imageFiles are selected
        // This function is kept for potential future use but may not work in all browsers
        try {
            if (imageFiles.length > 0 && typeof DataTransfer !== 'undefined') {
                const dt = new DataTransfer();
                imageFiles.forEach(file => {
                    try {
                        dt.items.add(file);
                    } catch(e) {
                        console.warn('Could not add file to DataTransfer:', e);
                    }
                });
                const fileInput = document.getElementById('images');
                if (fileInput && dt.files) {
                    fileInput.files = dt.files;
                }
            }
        } catch(e) {
            console.warn('File input update not supported:', e);
        }
    }

    function updatePreviewIndexes() {
        $('.remove-image').each(function(index) {
            if ($(this).data('index') !== undefined) {
                $(this).data('index', index);
            }
        });
    }

    // Form validation
    $('#vehicleForm').validate({
        rules: {
            vehicle_name: { 
                required: true,
                maxlength: 255
            },
            make: {
                required: function() {
                    return $('#make_new').val() === '';
                }
            },
            make_new: {
                required: function() {
                    return $('#make').val() === '';
                }
            },
            model: { 
                required: true,
                maxlength: 255
            },
            year: { 
                required: true
            },
            base_cost_per_day: { 
                required: true,
                number: true,
                min: 0
            },
            vat_percentage: { 
                required: true,
                number: true,
                min: 0,
                max: 100
            },
            passengers: {
                number: true,
                min: 1
            },
            seats: {
                number: true,
                min: 1
            },
            doors: {
                number: true,
                min: 1
            }
        },
        messages: {
            vehicle_name: {
                required: "The vehicle name field is required.",
                maxlength: "Vehicle name cannot exceed 255 characters."
            },
            make: {
                required: "The make field is required."
            },
            make_new: {
                required: "Please select or enter a make."
            },
            model: {
                required: "The model field is required.",
                maxlength: "Model cannot exceed 255 characters."
            },
            year: {
                required: "The year field is required."
            },
            base_cost_per_day: {
                required: "The base cost per day field is required.",
                number: "Base cost must be a valid number.",
                min: "Base cost cannot be negative."
            },
            vat_percentage: {
                required: "The VAT percentage field is required.",
                number: "VAT percentage must be a valid number.",
                min: "VAT percentage cannot be negative.",
                max: "VAT percentage cannot exceed 100."
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent());
        },
        submitHandler: function (form) {
            // Combine make and make_new before submit
            if ($('#make_new').val() && !$('#make').val()) {
                $('#make').append(`<option value="${$('#make_new').val()}" selected>${$('#make_new').val()}</option>`);
                $('#make').val($('#make_new').val()).trigger('change');
            }
            
            // Combine fuel_type and fuel_type_new before submit
            if ($('#fuel_type_new').val() && !$('#fuel_type').val()) {
                $('#fuel_type').append(`<option value="${$('#fuel_type_new').val()}" selected>${$('#fuel_type_new').val()}</option>`);
                $('#fuel_type').val($('#fuel_type_new').val()).trigger('change');
            }

            $('body').find('.LoaderSec').removeClass('d-none');
            form.submit();
        }
    });

    // Check for duplicate vehicle on blur
    $('#vehicle_name, #make, #make_new, #model, #year').on('blur', function() {
        checkDuplicate();
    });

    function checkDuplicate() {
        let vehicleName = $('#vehicle_name').val();
        let make = $('#make').val() || $('#make_new').val();
        let model = $('#model').val();
        let year = $('#year').val();
        let currentId = {{ $vehicle->id }};

        if (vehicleName && make && model && year) {
            $.ajax({
                url: "{{ route('vehicles.check-duplicate') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    vehicle_name: vehicleName,
                    make: make,
                    model: model,
                    year: year,
                    id: currentId
                },
                success: function(response) {
                    if (response.exists) {
                        $('#vehicle_name').addClass('is-invalid');
                        if ($('#vehicle_name').next('.invalid-feedback').length === 0) {
                            $('#vehicle_name').after('<div class="invalid-feedback">A vehicle with the same name, make, model, and year already exists.</div>');
                        }
                    } else {
                        $('#vehicle_name').removeClass('is-invalid');
                        $('#vehicle_name').next('.invalid-feedback').remove();
                    }
                }
            });
        }
    }
});
</script>
@endpush
