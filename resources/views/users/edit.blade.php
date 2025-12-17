@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@push('css')
<style>
    div.iti--inline-dropdown {
		min-width: 100%!important;
	}
	.iti__selected-flag {
		height: 32px!important;
	}
	.iti--show-flags {
		width: 100%!important;
	}  
	label.error {
		color: red;
	}
	#phone_number{
		font-family: "Hind Vadodara",-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif;
		font-size: 15px;
	}
    .select2.select2-container {
        margin-bottom: 0;
    }
    .content-inbox .select2.select2-container {
        margin-bottom: 20px;
    }
    .content-inbox input.form-control {
        margin-bottom: 20px;
    }
    .content-inbox .form-select {
        margin-bottom: 20px;
    }
    .content-inbox .iti.iti--allow-dropdown.iti--show-flags.iti--inline-dropdown {
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Edit User</h1>
        <p class="mt-2">Update user details, roles, and permissions</p>
    </div>
</div>
<form id="userForm" method="POST" action="{{ route('users.update', encrypt($user->id)) }}" enctype="multipart/form-data">
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
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Phone Number</label>
                        <input type="hidden" name="dial_code" id="dial_code">
                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
                        @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select class="form-select custom-select-arrow @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="1" {{ old('status', $user->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $user->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Roles</label>
                        <select class="form-select custom-select-arrow select2 @error('roles') is-invalid @enderror" id="roles" name="roles" required>
                            <option value="">Select Roles</option>
                            @foreach($roles as $id => $name)
                                <option value="{{ $id }}" {{ (in_array($id, old('roles', $userRoleIds))) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" id="password" name="password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Leave blank to keep unchanged.</small>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Profile Image</label>
                        <input type="file" class="form-control @error('profile') is-invalid @enderror" id="profile" name="profile" accept="image/*">
                        @if($user->profile)
                            <img src="{{ $user->userprofile }}" alt="Profile" class="img-thumbnail mt-2" width="80">
                        @endif
                        @error('profile')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
            <div class="draft-rgt">
                <a href="{{ route('users.index') }}" class="btn btn-gen bg-btn1">Cancel</a>
                <button type="submit" class="btn btn-gen bg-btn3">Update User</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/intel-tel.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('assets/js/jquery-validate.min.js') }}"></script>
<script src="{{ asset('assets/js/intel-tel.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
$(document).ready(function() {

    $('#roles').select2({
        placeholder: 'Select roles',
        width: '100%'
    });

    const input = document.querySelector('#phone_number');
    const errorMap = ["Phone number is invalid.", "Invalid country code", "Too short", "Too long"];
    const iti = window.intlTelInput(input, {
        initialCountry: "{{ Helper::getIso2ByDialCode($user->dial_code) }}",
        separateDialCode:true,
        nationalMode:false,
        preferredCountries: @json(\App\Models\Country::select('iso2')->pluck('iso2')->toArray()),
        utilsScript: "{{ asset('assets/js/intel-tel-2.min.js') }}"
    });
    input.addEventListener("countrychange", function() {
        if (iti.isValidNumber()) {
            $('#dial_code').val(iti.s.dialCode);
        }
    });
    input.addEventListener('keyup', () => {
        if (iti.isValidNumber()) {
            $('#dial_code').val(iti.s.dialCode);
        }
    });

    $('#userForm').validate({
        rules: {
            name: { required: true },
            email: { required: true, email: true },
            phone_number: { required: true },
            status: { required: true },
            roles: { required: true }
        },
        errorPlacement: function(error, element) {
            if (element.attr('id') === 'phone_number') {
                error.insertAfter(element.parent());
            } else {
                error.appendTo(element.parent());
            }
        },
        submitHandler: function (form) {
            $('#dial_code').val(iti.s.dialCode);
            $('body').find('.LoaderSec').removeClass('d-none');
            form.submit();
        }
    });
});
</script>
@endpush
