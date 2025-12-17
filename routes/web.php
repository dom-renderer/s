<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('vehicle-classes', \App\Http\Controllers\VehicleClassController::class);
    Route::post('vehicle-classes/check-duplicate', [\App\Http\Controllers\VehicleClassController::class, 'checkDuplicate'])->name('vehicle-classes.check-duplicate');

    Route::get('settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
});