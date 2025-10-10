<?php
use App\Http\Controllers\SocioeconomicBenefits\MembershipController;
use App\Http\Controllers\SocioeconomicBenefits\BeneficiaryController;
use App\Http\Controllers\Catalogs\DependencyController;
use App\Http\Controllers\Catalogs\SubdependencyController;
use App\Http\Controllers\Catalogs\PensionTypeController;
use App\Http\Controllers\Catalogs\RankController;
use App\Http\Controllers\Catalogs\WorkRiskController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:JefaturaCoordinacion|PrestacionesSocioEconomicas|JefaturaPrestaciones|SuperAdmin']], function () {
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
    Route::get('/socioeconomic_benefits/catalogs/dependencies', [DependencyController::class, 'index'])->name('dependencies.index');
    Route::get('/socioeconomic_benefits/catalogs/dependencies/create', [DependencyController::class, 'create'])->name('dependencies.create');
    Route::get('/socioeconomic_benefits/catalogs/dependencies/{id}/edit', [DependencyController::class, 'edit'])->name('dependencies.edit');
    Route::put('/socioeconomic_benefits/catalogs/dependencies/{id}', [DependencyController::class, 'update'])->name('dependencies.update');
        //Rutas para Subdependencias
    Route::get('/socioeconomic_benefits/catalogs/subdependencies', [SubdependencyController::class, 'index'])->name('subdependencies.index');
    Route::get('/socioeconomic_benefits/catalogs/subdependencies/create', [SubdependencyController::class, 'create'])->name('subdependencies.create');
    Route::get('/socioeconomic_benefits/catalogs/subdependencies/{id}/edit', [SubdependencyController::class, 'edit'])->name('subdependencies.edit');
    Route::put('/socioeconomic_benefits/catalogs/subdependencies/{id}', [SubdependencyController::class, 'update'])->name('subdependencies.update');
            //Rutas para Tipo de pensiones
    Route::get('/socioeconomic_benefits/catalogs/pension_types', [PensionTypeController::class, 'index'])->name('pension_types.index');
    Route::get('/socioeconomic_benefits/catalogs/pension_types/create', [PensionTypeController::class, 'create'])->name('pension_types.create');
    Route::get('/socioeconomic_benefits/catalogs/pension_types/{id}/edit', [PensionTypeController::class, 'edit'])->name('pension_types.edit');
    Route::put('/socioeconomic_benefits/catalogs/pension_types/{id}', [PensionTypeController::class, 'update'])->name('pension_types.update');
    //Rutas para Tipo de riesgos de trabajo
    Route::get('/socioeconomic_benefits/catalogs/work_risks', [WorkRiskController::class, 'index'])->name('work_risks.index');
    Route::get('/socioeconomic_benefits/catalogs/work_risks/create', [WorkRiskController::class, 'create'])->name('work_risks.create');
    Route::get('/socioeconomic_benefits/catalogs/work_risks/{id}/edit', [WorkRiskController::class, 'edit'])->name('work_risks.edit');
    Route::put('/socioeconomic_benefits/catalogs/work_risks/{id}', [WorkRiskController::class, 'update'])->name('work_risks.update');
        //Rutas para Categorias
    Route::get('/socioeconomic_benefits/catalogs/ranks', [RankController::class, 'index'])->name('ranks.index');
    Route::get('/socioeconomic_benefits/catalogs/ranks/create', [RankController::class, 'create'])->name('ranks.create');
    Route::get('/socioeconomic_benefits/catalogs/ranks/{id}/edit', [RankController::class, 'edit'])->name('ranks.edit');
    Route::put('/socioeconomic_benefits/catalogs/ranks/{id}', [RankController::class, 'update'])->name('ranks.update');
        });
