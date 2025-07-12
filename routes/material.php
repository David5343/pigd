<?php

use App\Http\Controllers\Catalogs\SupplierCategoryController;
use App\Http\Controllers\Catalogs\SupplierController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:RecursosMateriales|JefaturaMateriales|JefaturaAdministracion|JefaturaCoordinacion|SuperAdmin']], function () {
    //Rutas para categorias de proveedores
    Route::get('/material_resources/catalogs/supplier-category', [SupplierCategoryController::class, 'index'])->name('supplier-category.index');
    Route::get('/material_resources/catalogs/supplier-category/create', [SupplierCategoryController::class, 'create'])->name('supplier-category.create');
    Route::get('/material_resources/catalogs/supplier-category/{id}/edit', [SupplierCategoryController::class, 'edit'])->name('supplier-category.edit');
    Route::put('/material_resources/catalogs/supplier-category/{id}', [SupplierCategoryController::class, 'update'])->name('supplier-category.update');
        //Rutas para proveedores
    Route::get('/material_resources/catalogs/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/material_resources/catalogs/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::get('/material_resources/catalogs/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/material_resources/catalogs/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
});