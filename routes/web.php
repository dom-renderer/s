<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('vehicle-classes', \App\Http\Controllers\VehicleClassController::class);
    Route::post('vehicle-classes/check-duplicate', [\App\Http\Controllers\VehicleClassController::class, 'checkDuplicate'])->name('vehicle-classes.check-duplicate');
    Route::resource('vehicle-transmissions', \App\Http\Controllers\VehicleTransmissionController::class);
    Route::post('vehicle-transmissions/check-duplicate', [\App\Http\Controllers\VehicleTransmissionController::class, 'checkDuplicate'])->name('vehicle-transmissions.check-duplicate');
    Route::resource('vehicle-types', \App\Http\Controllers\VehicleTypeController::class);
    Route::post('vehicle-types/check-duplicate', [\App\Http\Controllers\VehicleTypeController::class, 'checkDuplicate'])->name('vehicle-types.check-duplicate');
    Route::resource('locations', \App\Http\Controllers\LocationController::class);
    Route::post('locations/check-duplicate', [\App\Http\Controllers\LocationController::class, 'checkDuplicate'])->name('locations.check-duplicate');
    Route::post('locations/get-parishes', [\App\Http\Controllers\LocationController::class, 'getParishes'])->name('locations.get-parishes');
    Route::resource('vehicles', \App\Http\Controllers\VehicleController::class);
    Route::post('vehicles/check-duplicate', [\App\Http\Controllers\VehicleController::class, 'checkDuplicate'])->name('vehicles.check-duplicate');

    Route::get('settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
});