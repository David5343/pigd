<?php

use App\Http\Controllers\Catalogs\AreaController;
use App\Http\Controllers\Catalogs\BankController;
use App\Http\Controllers\Catalogs\CategoryController;
use App\Http\Controllers\Catalogs\ContractTypeController;
use App\Http\Controllers\Catalogs\PositionController;
use App\Http\Controllers\Catalogs\ProcedureTypeController;
use App\Http\Controllers\HumanResources\EmployeeController;
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
    //Rutas para puestos
    Route::get('/human_resources/catalogs/positions', [PositionController::class, 'index'])->name('positions.index');
    Route::get('/human_resources/catalogs/positions/create', [PositionController::class, 'create'])->name('positions.create');
    Route::get('/human_resources/catalogs/positions/{id}/edit', [PositionController::class, 'edit'])->name('positions.edit');
    Route::put('/human_resources/catalogs/positions/{id}', [PositionController::class, 'update'])->name('positions.update');
    //Rutas para Tipo de movimiento nominal
    Route::get('/human_resources/catalogs/procedure-type', [ProcedureTypeController::class, 'index'])->name('procedure-type.index');
    Route::get('/human_resources/catalogs/procedure-type/create', [ProcedureTypeController::class, 'create'])->name('procedure-type.create');
    Route::get('/human_resources/catalogs/procedure-type/{id}/edit', [ProcedureTypeController::class, 'edit'])->name('procedure-type.edit');
    Route::put('/human_resources/catalogs/procedure-type/{id}', [ProcedureTypeController::class, 'update'])->name('procedure-type.update');
    //Rutas para Tipo de contrato laboral
    Route::get('/human_resources/catalogs/contract-type', [ContractTypeController::class, 'index'])->name('contract-type.index');
    Route::get('/human_resources/catalogs/contract-type/create', [ContractTypeController::class, 'create'])->name('contract-type.create');
    Route::get('/human_resources/catalogs/contract-type/{id}/edit', [ContractTypeController::class, 'edit'])->name('contract-type.edit');
    Route::put('/human_resources/catalogs/contract-type/{id}', [ContractTypeController::class, 'update'])->name('contract-type.update');
    //Rutas para empleados
    Route::get('/human_resources/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/human_resources/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::get('/human_resources/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/human_resources/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
});