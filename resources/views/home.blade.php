@extends('layouts.app', ['title' => 'Dashboard', 'subTitle' => 'Dashboard', 'datepicker' => true])

@section('content')
<div class="welcome-box">
    <div class="welcome-left">
        <h1 class="h-30 clr-blue fw-bold">Welcome back, David</h1>
        <p class="mt-2">Here’s what’s happening with your rental operations today.</p>
    </div>
    <div class="welcome-right">
        <button class="btn blue-btn">
            <img src="{{ asset('ui/images/sync-icn.svg') }}" alt=""> &nbsp;
            Sync All OTAs
        </button>
        <button class="btn white-bdr-bn">
            <img src="{{ asset('ui/images/+.svg') }}" alt=""> &nbsp;
            Quick Actions
        </button>
    </div>
</div>
<div class="dash-md1">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="status-box flx-manage mb-4">
                <div class="st-left">
                    <h3 class="h-14 mb-2">Total Vehicles</h3>
                    <span class="h-20 fw-bold">247</span>
                    <p class="p-10 text-green">+12% from last month</p>
                </div>
                <div class="st-img bg-1">
                    <img src="{{ asset('ui/images/car-icn-1.svg') }}" alt="">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="status-box flx-manage mb-4">
                <div class="st-left">
                    <h3 class="h-14 mb-2">Active OTAs</h3>
                    <span class="h-20 fw-bold">6</span>
                    <p class="p-10 text-green">
                        <span class="dots1"></span>All synchronized
                    </p>
                </div>
                <div class="st-img bg-2">
                    <img src="{{ asset('ui/images/wif-soyte.svg') }}" alt="">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="status-box flx-manage mb-4">
                <div class="st-left">
                    <h3 class="h-14 mb-2">Last Sync</h3>
                    <span class="h-20 fw-bold">2m ago</span>
                    <p class="p-10 text-bl1">
                        <span class="dots2"></span>Auto-sync enabled
                    </p>
                </div>
                <div class="st-img bg-3">
                    <img src="{{ asset('ui/images/sunc-sout.svg') }}" alt="">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="status-box flx-manage mb-4">
                <div class="st-left">
                    <h3 class="h-14 mb-2">Pending Updates</h3>
                    <span class="h-20 fw-bold">23</span>
                    <p class="p-10 text-yl1">
                        <span class="dots3"></span>Requires attention
                    </p>
                </div>
                <div class="st-img bg-4">
                    <img src="{{ asset('ui/images/download-soute.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="action-activity">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="action-box">
                <h2 class="h-20 fw-bold">
                    <img src="{{ asset('ui/images/quick-soute.svg') }}" alt="" class="me-2">Quick Actions
                </h2>
                <div class="action-in">
                    <div class="inx-act status-box flx-manage m-4">
                        <div class="otl-act">
                            <div class="vehi-box bg-1">
                                <img src="{{ asset('ui/images/+(1).svg') }}" alt="">
                            </div>
                            <div>
                                <h3 class="h-14 fw-600">Total Vehicles</h3>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </div>
                        <div class="act-arroew">
                            <img src="{{ asset('ui/images/arrow-rgt-soute.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="inx-act status-box flx-manage m-4">
                        <div class="otl-act">
                            <div class="vehi-box bg-3">
                                <img src="{{ asset('ui/images/$.svg') }}" alt="">
                            </div>
                            <div>
                                <h3 class="h-14 fw-600">Total Vehicles</h3>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </div>
                        <div class="act-arroew">
                            <img src="{{ asset('ui/images/arrow-rgt-soute.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="inx-act status-box flx-manage m-4">
                        <div class="otl-act">
                            <div class="vehi-box bg-2">
                                <img src="{{ asset('ui/images/setting-soute.svg') }}" alt="">
                            </div>
                            <div>
                                <h3 class="h-14 fw-600">Total Vehicles</h3>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </div>
                        <div class="act-arroew">
                            <img src="{{ asset('ui/images/arrow-rgt-soute.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="inx-act status-box flx-manage m-4">
                        <div class="otl-act">
                            <div class="vehi-box bg-4">
                                <img src="{{ asset('ui/images/repost-soute.svg') }}" alt="">
                            </div>
                            <div>
                                <h3 class="h-14 fw-600">Total Vehicles</h3>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </div>
                        <div class="act-arroew">
                            <img src="{{ asset('ui/images/arrow-rgt-soute.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="action-box">
                <h2 class="h-20 fw-bold">
                    <img src="{{ asset('ui/images/time-sote.svg') }}" alt="" class="me-2">Recent Activity
                </h2>
                <div class="action-in activity-in">
                    <ul>
                        <li>
                            <div class="rct-icon bg-3">
                                <img src="{{ asset('ui/images/act-1.svg') }}" alt="">
                            </div>
                            <div class="rct-content">
                                <p>Successfully synced 15 vehicles to Car Trawler</p>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </li>
                        <li>
                            <div class="rct-icon bg-1">
                                <img src="{{ asset('ui/images/act-2.svg') }}" alt="">
                            </div>
                            <div class="rct-content">
                                <p>Successfully synced 15 vehicles to Car Trawler</p>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </li>
                        <li>
                            <div class="rct-icon bg-4">
                                <img src="{{ asset('ui/images/act-3.svg') }}" alt="">
                            </div>
                            <div class="rct-content">
                                <p>Successfully synced 15 vehicles to Car Trawler</p>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </li>
                        <li>
                            <div class="rct-icon bg-5">
                                <img src="{{ asset('ui/images/act-4.svg') }}" alt="">
                            </div>
                            <div class="rct-content">
                                <p>Successfully synced 15 vehicles to Car Trawler</p>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </li>
                        <li>
                            <div class="rct-icon bg-6">
                                <img src="{{ asset('ui/images/act-5.svg') }}" alt="">
                            </div>
                            <div class="rct-content">
                                <p>Successfully synced 15 vehicles to Car Trawler</p>
                                <p class="p-10 text-gry">Register a new vehicle to your fleet</p>
                            </div>
                        </li>
                        <li>
                            <a class="clr-blue" href="">View all activity <img src="{{ asset('ui/images/act-7.svg') }}" alt=""></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script>
    $(document).ready(function () {

    });
</script>
@endpush
