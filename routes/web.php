<?php

use App\Http\Controllers\FinancialResources\FinancialResourcesController;
use App\Http\Controllers\GeneralAdministration\GeneralAdministrationController;
use App\Http\Controllers\GeneralCoordination\GeneralCoordinationController;
use App\Http\Controllers\HumanResources\HumanResourcesController;
use App\Http\Controllers\LegalDepartment\LegalDepartmentController;
use App\Http\Controllers\MaterialResources\MaterialResourcesController;
use App\Http\Controllers\MedicalCoordination\MedicalCoordinationController;
use App\Http\Controllers\SocioeconomicBenefits\SocioeconomicBenefitsController;
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
    Route::get('/general_coordination', [GeneralCoordinationController::class, 'index'])->name('gcoordination');
    Route::get('/general_administration', [GeneralAdministrationController::class, 'index'])->name('gadministration.index');
    Route::get('/legal_department', [LegalDepartmentController::class, 'index'])->name('ldepartment');
    Route::get('/medical_coordination', [MedicalCoordinationController::class, 'index'])->name('mcoordination');
    Route::get('/human_resources', [HumanResourcesController::class, 'index'])->name('hresources');
    Route::get('/financial_resources', [FinancialResourcesController::class, 'index'])->name('fresources');
    Route::get('/material_resources', [MaterialResourcesController::class, 'index'])->name('mresources');
    Route::get('/socioeconomic_benefits', [SocioeconomicBenefitsController::class, 'index'])->name('scbenefits');
});
