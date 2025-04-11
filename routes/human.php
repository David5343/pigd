<?php

use App\Http\Controllers\Catalogs\AreaController;
use App\Http\Controllers\Catalogs\BankController;
use App\Http\Controllers\Catalogs\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:JefaturaCoordinacion|RecursosHumanos|SuperAdmin']], function () {
    //Rutas para areas
    Route::get('/human_resources/catalogs/areas', [AreaController::class, 'index'])->name('areas.index');
    Route::get('/human_resources/catalogs/areas/create', [AreaController::class, 'create'])->name('areas.create');
    Route::get('/human_resources/catalogs/areas/{id}/edit', [AreaController::class, 'edit'])->name('areas.edit');
    Route::put('/human_resources/catalogs/areas/{id}', [AreaController::class, 'update'])->name('areas.update');
    //Rutas para bancos
    Route::get('/human_resources/catalogs/banks', [BankController::class, 'index'])->name('banks.index');
    Route::get('/human_resources/catalogs/banks/create', [BankController::class, 'create'])->name('banks.create');
    Route::get('/human_resources/catalogs/banks/{id}/edit', [BankController::class, 'edit'])->name('banks.edit');
    Route::put('/human_resources/catalogs/banks/{id}', [BankController::class, 'update'])->name('banks.update');
    //Rutas para categorias
    Route::get('/human_resources/catalogs/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/human_resources/catalogs/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/human_resources/catalogs/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/human_resources/catalogs/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
});