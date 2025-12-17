@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Add New Role</h1>
        <p class="mt-2">Configure role details and permissions</p>
    </div>
</div>
<form method="POST" action="{{ route('roles.store') }}">
    @csrf
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
                        <label class="form-label">Role Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter role title" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="mb-4">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter slug" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-box">
        <div class="head-content">
            <h3 class="h-16 fw-bold">
                <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
                Select Permissions
            </h3>
        </div>
        <div class="content-inbox">
            <div class="row">
                @forelse($permissions as $key => $permission)
                    <div class="col-6 col-lg-12 col-xl-6 mrgin-mng">
                        <div class="card">
                            <div class="card-body check-main">
                                <h3>
                                    <input type="checkbox" class="parent-checkbox" id="{{ Str::slug($key) }}">
                                    <label for="{{ Str::slug($key) }}"> {{  ucwords(str_replace('-', ' ', $key))  }} </label>
                                </h3>
                                @forelse($permission as $row)
                                <div>
                                    <input type="checkbox" name="permissions[]" data-parent="{{ Str::slug($key) }}" id="{{ $row->name }}" value="{{ $row->id }}">
                                    <label for="{{ $row->name }}">{{ $row->title }}</label> 
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
    <div class="content-box">   
        <div class="save-draft">
            <div class="draaft-left">
                <a href="{{ route('roles.index') }}">
                    <img src="{{ asset('ui/images/leftarrow-vector.svg') }}" alt="">
                    <span class="sz-18">Back to Roles</span>
                </a>
            </div>
            <div class="draft-rgt">
                <a href="{{ route('roles.index') }}" class="btn btn-gen bg-btn1">Cancel</a>
                <button type="submit" class="btn btn-gen bg-btn3">Create Role</button>
            </div>
        </div>
    </div>
</form>
@endsection 

@push('js')
<script>
    $(document).ready(function () {
        $('.parent-checkbox').on('change', function () {
            if ($(this).is(':checked')) {
                $(`[data-parent="${$(this).attr('id')}"]`).prop('checked', true);
            } else {
                $(`[data-parent="${$(this).attr('id')}"]`).prop('checked', false);
            }
        })                
    });
</script>
@endpush
