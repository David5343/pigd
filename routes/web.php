<?php

use App\Http\Controllers\FinancialResources\FinancialResourcesController;
use App\Http\Controllers\GeneralAdministration\GeneralAdministrationController;
use App\Http\Controllers\GeneralCoordination\GeneralCoordinationController;
use App\Http\Controllers\HumanResources\HumanResourcesController;
use App\Http\Controllers\LegalDepartment\LegalDepartmentController;
use App\Http\Controllers\MaterialResources\MaterialResourcesController;
use App\Http\Controllers\MedicalCoordination\MedicalCoordinationController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\SocioeconomicBenefits\MembershipController;
use App\Http\Controllers\SocioeconomicBenefits\SocioeconomicBenefitsController;
use App\Http\Controllers\Users\UserController;
use App\Http\Middleware\CheckIfActive;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',],[CheckIfActive::class])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::get('/socioeconomic_benefits/membership', [MembershipController::class, 'index'])->name('membership.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

});
