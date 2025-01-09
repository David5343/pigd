<?php

use App\Http\Controllers\GeneralAdministration\GeneralAdministrationController;
use App\Http\Controllers\GeneralCoordination\GeneralCoordinationController;
use App\Http\Controllers\LegalDepartment\LegalDepartmentController;
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
    Route::get('/general_administration', [GeneralAdministrationController::class, 'index'])->name('gadministration');
    Route::get('/legal_department', [LegalDepartmentController::class, 'index'])->name('ldepartment');
});
