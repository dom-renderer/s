@extends('layouts.app', ['title' => $title, 'subTitle' => $subTitle])

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Role Details</h1>
        <p class="mt-2">View role information and permissions</p>
    </div>
</div>
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
            Role Information
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" id="name" placeholder="Title" name="name" value="{{ old('name', $role->title) }}" disabled>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="mb-4">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{ old('slug', $role->name) }}" disabled>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-box">
    <div class="head-content">
        <h3 class="h-16 fw-bold">
            <img src="{{ asset('ui/images/basic-icon2.svg') }}" alt="">
            Permissions
        </h3>
    </div>
    <div class="content-inbox">
        <div class="row">
            @forelse($permissions as $key => $permission)
                <div class="col-6 col-lg-12 col-xl-6 mrgin-mng">
                    <div class="card">
                        <div class="card-body check-main">
                            <h3>
                                <label for="{{ Str::slug($key) }}"> {{  ucwords(str_replace('-', ' ', $key))  }} </label>
                            </h3>
                            @forelse($permission as $row)
                            <div>
                                <input type="checkbox" name="permissions[]" data-parent="{{ Str::slug($key) }}" id="{{ $row->name }}" value="{{ $row->id }}" @if(in_array($row->id, $existingPermissions)) checked @endif disabled>
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
    </div>
</div>
@endsection 
