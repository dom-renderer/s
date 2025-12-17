@php
    $user = auth()->user();

    $userManagementPermissions = [
        'users.index', 'roles.index'
    ];

    $canViewUserManagement = collect($userManagementPermissions)->contains(fn($perm) => $user->can($perm));

    $segment = request()->segment(1);

    $userManagementSegments = ['users', 'roles', 'engineers', 'co-ordinators', 'technicians', 'customers', 'departments', 'expertises'];

    $activeUserManagement = in_array($segment, $userManagementSegments);

    $thisRouteName = \Request::route()->getName();
@endphp

<header class="main-header d-none d-md-block">
    <div class="container main-container">
        <div class="header-inner d-flex align-items-center justify-content-between">

            <!-- Left Logo -->
            <div class="header-left d-flex align-items-center">
                <img src="{{ asset('ui/images/dashboard-logo.svg') }}" class="header-logo" alt="Logo">
            </div>

            <!-- Center Navigation -->
            <nav class="header-nav">
                <ul class="nav">
                    <li><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="#" class="nav-link">OTAs</a></li>
                    <li><a href="#" class="nav-link">Vehicles</a></li>
                    <li><a href="{{ route('vehicle-classes.index') }}" class="nav-link {{ request()->routeIs('vehicle-classes.*') ? 'active' : '' }}">Vehicle Classes</a></li>
                    <li><a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a></li>
                    <li><a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">Roles</a></li>
                    <li><a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">Settings</a></li>
                </ul>
            </nav>

            <!-- Right Section -->
            <div class="header-right d-flex align-items-center">

                <!-- Notification -->
                <div class="notification position-relative me-3">
                    <img src="{{ asset('ui/images/notification-soute.svg') }}" width="20">
                    <span class="noti-badge">10</span>
                </div>

                <!-- User -->
                <div class="user-area d-flex align-items-center">
                    <div class="text-end">
                        <div class="name-user">{{ auth()->user()->name }}</div>
                        <div class="small text-muted"> {{ implode(', ', auth()->user()->roles()->pluck('name')->toArray()) }} </div>
                    </div>
                    <div class="user-select-wrapper">
                        <select class="form-select user-select">
                            <option selected></option>
                            <option value="3">Logout</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>