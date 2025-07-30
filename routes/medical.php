<?php

use App\Http\Controllers\Catalogs\CatalogYearController;
use App\Http\Controllers\Catalogs\MedicationController;
use App\Http\Controllers\Catalogs\MedicationUnitController;
use App\Http\Controllers\MedicalCoordination\BeneficiaryMedicalController;
use App\Http\Controllers\MedicalCoordination\InsuredMedicalController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:Enlace|JefaturaCoordinacion|CoordinacionMedica|JefaturaAdministracion|SuperAdmin']], function () {
    //Rutas para Titulares en Coordinacion Médica
    Route::get('/medical_coordination/membership', [InsuredMedicalController::class, 'index'])->name('membership_medical.index');
    Route::get('/medical_coordination/membership/{id}', [InsuredMedicalController::class, 'show'])->name('membership_medical.show');
    //Rutas para Titulares en Coordinacion Médica
    Route::get('/medical_coordination/beneficiaries', [BeneficiaryMedicalController::class, 'index'])->name('beneficiaries_medical.index');
    Route::get('/medical_coordination/beneficiaries/{id}', [BeneficiaryMedicalController::class, 'show'])->name('beneficiaries_medical.show');
    //Rutas para unidades de medida
    Route::get('/medical_coordination/catalogs/medication_unit', [MedicationUnitController::class, 'index'])->name('medication_unit.index');
    Route::get('/medical_coordination/catalogs/medication_unit/create', [MedicationUnitController::class, 'create'])->name('medication_unit.create');
    Route::get('/medical_coordination/catalogs/medication_unit/{id}/edit', [MedicationUnitController::class, 'edit'])->name('medication_unit.edit');
    Route::put('/medical_coordination/catalogs/medication_unit/{id}', [MedicationUnitController::class, 'update'])->name('medication_unit.update');
        //Rutas para catalogo de años
    Route::get('/medical_coordination/catalogs/catalog_year', [CatalogYearController::class, 'index'])->name('catalog_year.index');
    Route::get('/medical_coordination/catalogs/catalog_year/create', [CatalogYearController::class, 'create'])->name('catalog_year.create');
    Route::get('/medical_coordination/catalogs/catalog_year/{id}/edit', [CatalogYearController::class, 'edit'])->name('catalog_year.edit');
    Route::put('/medical_coordination/catalogs/catalog_year/{id}', [CatalogYearController::class, 'update'])->name('catalog_year.update');
        //Rutas para medicamentos
    Route::get('/medical_coordination/catalogs/medication', [MedicationController::class, 'index'])->name('medication.index');
    Route::get('/medical_coordination/catalogs/medication/create', [MedicationController::class, 'create'])->name('medication.create');
    Route::get('/medical_coordination/catalogs/medication/{id}/edit', [MedicationController::class, 'edit'])->name('medication.edit');
    Route::put('/medical_coordination/catalogs/medication/{id}', [MedicationController::class, 'update'])->name('medication.update');
});