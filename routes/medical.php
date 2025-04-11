<?php

use App\Http\Controllers\MedicalCoordination\BeneficiaryMedicalController;
use App\Http\Controllers\MedicalCoordination\InsuredMedicalController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:Enlace|JefaturaCoordinacion|CoordinacionMedica|JefaturaAdministracion|SuperAdmin']], function () {
    //Rutas para Titulares en Coordinacin Médica
    Route::get('/medical_coordination/membership', [InsuredMedicalController::class, 'index'])->name('membership_medical.index');
    Route::get('/medical_coordination/membership/{id}', [InsuredMedicalController::class, 'show'])->name('membership_medical.show');
    //Rutas para Titulares en Coordinacin Médica
    Route::get('/medical_coordination/beneficiaries', [BeneficiaryMedicalController::class, 'index'])->name('beneficiaries_medical.index');
    Route::get('/medical_coordination/beneficiaries/{id}', [BeneficiaryMedicalController::class, 'show'])->name('beneficiaries_medical.show');
});