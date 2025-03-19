<?php

use App\Http\Controllers\Catalogs\DependencyController;
use App\Http\Controllers\Permissions\PermissionController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\SocioeconomicBenefits\BeneficiaryController;
use App\Http\Controllers\SocioeconomicBenefits\MembershipController;
use App\Http\Controllers\Users\UserController;
use App\Http\Middleware\CheckIfActive;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    CheckIfActive::class,
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['middleware' => ['role:PrestacionesSocioEconomicas|SuperAdmin']], function () {
    //Rutas para titulares
    Route::get('/socioeconomic_benefits/membership', [MembershipController::class, 'index'])->name('membership.index');
    Route::get('/socioeconomic_benefits/membership/create', [MembershipController::class, 'create'])->name('membership.create');
    Route::get('/socioeconomic_benefits/membership/{id}', [MembershipController::class, 'show'])->name('membership.show');
    Route::get('/socioeconomic_benefits/membership/{id}/edit', [MembershipController::class, 'edit'])->name('membership.edit');
    Route::put('/socioeconomic_benefits/membership/{id}', [MembershipController::class, 'update'])->name('membership.update');
    //Rutas para familiares
    Route::get('/socioeconomic_benefits/beneficiaries', [BeneficiaryController::class, 'index'])->name('beneficiaries.index');
    Route::get('/socioeconomic_benefits/beneficiaries/create', [BeneficiaryController::class, 'create'])->name('beneficiaries.create');
    Route::get('/socioeconomic_benefits/beneficiaries/{id}', [BeneficiaryController::class, 'show'])->name('beneficiaries.show');
    Route::get('/socioeconomic_benefits/beneficiaries/{id}/edit', [BeneficiaryController::class, 'edit'])->name('beneficiaries.edit');
    Route::put('/socioeconomic_benefits/beneficiaries/{id}', [BeneficiaryController::class, 'update'])->name('beneficiaries.update');
    //Rutas para Dependencias
    Route::get('/socioeconomic_benefits/dependencies', [DependencyController::class, 'index'])->name('dependencies.index');
    Route::get('/socioeconomic_benefits/dependencies/create', [DependencyController::class, 'create'])->name('dependencies.create');
    Route::get('/socioeconomic_benefits/dependencies/{id}/edit', [DependencyController::class, 'edit'])->name('dependencies.edit');
    Route::put('/socioeconomic_benefits/dependencies/{id}', [DependencyController::class, 'update'])->name('dependencies.update');
});

        Route::group(['middleware' => ['role:Tecnologías|SuperAdmin']], function () {
        //Rutas de Usuarios
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        // Rutas de Permisos
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');

        // Rutas de Roles
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::get('/roles/manage', [RoleController::class, 'manage'])->name('roles.manage');
        });
});
