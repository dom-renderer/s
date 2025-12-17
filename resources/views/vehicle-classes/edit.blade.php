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
</style>
@endpush

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Edit Vehicle Class</h1>
        <p class="mt-2">Update vehicle class details and status</p>
    </div>
</div>
<form id="vehicleClassForm" method="POST" action="{{ route('vehicle-classes.update', encrypt($vehicleClass->id)) }}">
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
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $vehicleClass->title) }}" placeholder="Enter vehicle class title" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select custom-select-arrow @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="1" {{ old('status', $vehicleClass->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $vehicleClass->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter vehicle class description">{{ old('description', $vehicleClass->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-box">   
        <div class="save-draft">
            <div class="draaft-left">
                <a href="{{ route('vehicle-classes.index') }}">
                    <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                    <span class="sz-18">Back to Vehicle Classes</span>
                </a>
            </div>
            <div class="draft-rgt">
                <a href="{{ route('vehicle-classes.index') }}" class="btn btn-gen bg-btn1">Cancel</a>
                <button type="submit" class="btn btn-gen bg-btn3">Update Vehicle Class</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script src="{{ asset('assets/js/jquery-validate.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#vehicleClassForm').validate({
        rules: {
            title: { 
                required: true,
                maxlength: 255
            },
            description: {
                maxlength: 1000
            },
            status: { 
                required: true 
            }
        },
        messages: {
            title: {
                required: "The title field is required.",
                maxlength: "Title cannot exceed 255 characters."
            },
            description: {
                maxlength: "Description cannot exceed 1000 characters."
            },
            status: {
                required: "The status field is required."
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

    // Check for duplicate title on blur
    $('#title').on('blur', function() {
        let title = $(this).val();
        let currentId = {{ $vehicleClass->id }};
        if (title) {
            $.ajax({
                url: "{{ route('vehicle-classes.check-duplicate') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    title: title,
                    id: currentId
                },
                success: function(response) {
                    if (response.exists) {
                        $('#title').addClass('is-invalid');
                        if ($('#title').next('.invalid-feedback').length === 0) {
                            $('#title').after('<div class="invalid-feedback">This vehicle class title already exists.</div>');
                        }
                    } else {
                        $('#title').removeClass('is-invalid');
                        $('#title').next('.invalid-feedback').remove();
                    }
                }
            });
        }
    });
});
</script>
@endpush

