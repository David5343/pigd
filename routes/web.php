<?php

use App\Http\Controllers\GeneralCoordination\GeneralCoordinationController;
use App\Http\Controllers\MedicalCoordination\MedicalCoordinationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('cmedica', [MedicalCoordinationController::class, 'index'])->name('cmedica');
    Route::get('/general_coordination', [GeneralCoordinationController::class, 'index'])->name('gcoordination');
});
