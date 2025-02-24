<?php

use App\Http\Controllers\SocioeconomicBenefits\BeneficiariesController;
use App\Http\Controllers\SocioeconomicBenefits\MembershipController;
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
    Route::get('/socioeconomic_benefits/membership/{id}', [MembershipController::class, 'show'])->name('membership.show');
    Route::get('/socioeconomic_benefits/beneficiaries', [BeneficiariesController::class, 'index'])->name('beneficiaries.index');
    Route::get('/socioeconomic_benefits/beneficiaries/{id}', [BeneficiariesController::class, 'show'])->name('beneficiaries.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

});
