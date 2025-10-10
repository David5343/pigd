<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Catalogs\AffiliationStatusApiController;
use App\Http\Controllers\Api\Catalogs\BankApiController;
use App\Http\Controllers\Api\Catalogs\CountyApiController;
use App\Http\Controllers\Api\Catalogs\StateApiController;
use App\Http\Controllers\Api\Catalogs\SubdependencyApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\BeneficiaryApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\CredentialBeneficiaryApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\CredentialInsuredApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\CredentialRetireeApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\InsuredApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\PensionTypeApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\RankApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\RetireeApiController;
use App\Http\Controllers\Api\SocioeconomicBenefits\TicketApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);
Route::get('/users', [ApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/users', [ApiController::class, 'index']);
    //Rutas de titulares
    Route::get('/socioeconomic_benefits/insureds/idgenerator', [InsuredApiController::class, 'idgenerator']);
    Route::get('/socioeconomic_benefits/insureds', [InsuredApiController::class, 'index']);
    Route::post('/socioeconomic_benefits/insureds/store', [InsuredApiController::class, 'store']);
    Route::post('/socioeconomic_benefits/insureds/reentry', [InsuredApiController::class, 'reentry']);
    Route::get('/socioeconomic_benefits/insureds/{id}', [InsuredApiController::class, 'show']);
    //Route::delete('/prestaciones/titulares/{id}', [InsuredApiController::class,'destroy']);
    Route::get('/socioeconomic_benefits/insureds/search/{data}', [InsuredApiController::class, 'search']);
    Route::get('/socioeconomic_benefits/insureds/searchbyfolio/{folio}', [InsuredApiController::class, 'searchbyfolio']);
    Route::get('/socioeconomic_benefits/insureds/searchbyrfc/{rfc}', [InsuredApiController::class, 'searchbyrfc']);
    Route::get('/socioeconomic_benefits/insureds/searchbycurp/{curp}', [InsuredApiController::class, 'searchbycurp']);
    Route::put('/socioeconomic_benefits/insureds/update/{id}', [InsuredApiController::class, 'update']);
    Route::patch('/socioeconomic_benefits/insureds/deactivate/{id}', [InsuredApiController::class, 'deactivate']);
    Route::patch('/socioeconomic_benefits/insureds/photo/{id}', [InsuredApiController::class, 'photo']);
    Route::patch('/socioeconomic_benefits/insureds/signature/{id}', [InsuredApiController::class, 'signature']);
     
    //Rutas de familiares
    Route::get('/prestaciones/familiares/idgenerator', [BeneficiaryApiController::class, 'idgenerator']);
    Route::get('/prestaciones/familiares', [BeneficiaryApiController::class, 'index']);
    Route::post('/prestaciones/familiares/guardar', [BeneficiaryApiController::class, 'store']);
    Route::get('/prestaciones/familiares/{id}', [BeneficiaryApiController::class, 'show']);
    Route::get('/prestaciones/familiares/busqueda/{dato}', [BeneficiaryApiController::class, 'busqueda']);
    Route::get('/prestaciones/familiares/porfolio/{dato}', [BeneficiaryApiController::class, 'porfolio']);
    Route::get('/prestaciones/familiares/porrfc/{dato}', [BeneficiaryApiController::class, 'porrfc']);
    Route::get('/prestaciones/familiares/porcurp/{dato}', [BeneficiaryApiController::class, 'porcurp']);
    Route::put('/prestaciones/familiares/guardarfoto/{id}', [BeneficiaryApiController::class, 'guardarfoto']);
    Route::put('/prestaciones/familiares/baja/{id}', [BeneficiaryApiController::class, 'baja']);
    Route::put('/prestaciones/familiares/update/{id}', [BeneficiaryApiController::class, 'update']);
    //Rutas de subdependencias
    Route::get('/prestaciones/subdependencias/listar', [SubdependencyApiController::class, 'listar']);
    //Rutas de categorias
    Route::get('/prestaciones/categorias/listar', [RankApiController::class, 'listar']);
    //Rutas de municipios
    Route::get('/humanos/municipios/listar', [CountyApiController::class, 'listar']);
    Route::get('/humanos/municipios/buscarporestados/{id}', [CountyApiController::class, 'buscarporestados']);
    //Rutas de estados
    Route::get('/humanos/estados/listar', [StateApiController::class, 'listar']);
    //Rutas de bancos
    Route::get('/humanos/bancos/listar', [BankApiController::class, 'listar']);
    //Rutas de estatus de afiliacion
    Route::get('/socioeconomic_benefits/affiliation_statuses/index', [AffiliationStatusApiController::class, 'index']);
    //Credencial Titulares
    Route::get('/prestaciones/credencialtitular', [CredentialInsuredApiController::class, 'index']);
    Route::post('/prestaciones/credencialtitular/guardar', [CredentialInsuredApiController::class, 'store']);
    Route::get('/prestaciones/credencialtitular/busqueda/{dato}', [CredentialInsuredApiController::class, 'busqueda']);
    Route::get('/prestaciones/credencialtitular/{id}', [CredentialInsuredApiController::class, 'show']);
    Route::put('/prestaciones/credencialtitular/finalizar/{id}',[CredentialInsuredApiController::class, 'finalizar']);
    //Credencial Familiares
    Route::get('/prestaciones/credencialfamiliar', [CredentialBeneficiaryApiController::class, 'index']);
    Route::post('/prestaciones/credencialfamiliar/guardar', [CredentialBeneficiaryApiController::class, 'store']);
    Route::get('/prestaciones/credencialfamiliar/busqueda/{dato}', [CredentialBeneficiaryApiController::class, 'busqueda']);
    Route::get('/prestaciones/credencialfamiliar/{id}', [CredentialBeneficiaryApiController::class, 'show']);
    Route::put('/prestaciones/credencialfamiliar/finalizar/{id}',[CredentialBeneficiaryApiController::class, 'finalizar']);
    //Tipos de Pensionados
    Route::get('/socioeconomic_benefits/pensiontypes', [PensionTypeApiController::class, 'index']);
    //Pensionados
    Route::get('/prestaciones/pensionados', [RetireeApiController::class, 'index']);
    Route::post('/prestaciones/pensionados/guardar', [RetireeApiController::class, 'store']);
    Route::get('/prestaciones/pensionados/busqueda/{dato}', [RetireeApiController::class, 'busqueda']);
    Route::get('/prestaciones/pensionados/search/{dato}', [RetireeApiController::class, 'search']);
    //Credencial Pensionados
    Route::get('/prestaciones/credencialpensionados', [CredentialRetireeApiController::class, 'index']);
    Route::post('/prestaciones/credencialpensionados/guardar', [CredentialRetireeApiController::class, 'store']);
    Route::get('/prestaciones/credencialpensionados/{id}', [CredentialRetireeApiController::class, 'show']);
    Route::get('/prestaciones/credencialpensionados/search/{dato}', [CredentialRetireeApiController::class, 'search']);
    //Turnos
    Route::get('/prestaciones/turnos', [TicketApiController::class, 'index']);
    Route::post('/prestaciones/turnos/guardar', [TicketApiController::class, 'store']);
    Route::get('/prestaciones/turnos/busqueda/{dato}', [TicketApiController::class, 'busqueda']);
    Route::get('/prestaciones/turnos/search/{dato}', [TicketApiController::class, 'search']);
    Route::get('/prestaciones/turnos/searchbydate', [TicketApiController::class, 'searchbydate']);
    Route::get('/prestaciones/turnos/{id}', [TicketApiController::class, 'show']);
    Route::put('/prestaciones/turnos/update/{id}', [TicketApiController::class, 'update']);
    Route::put('/prestaciones/turnos/cancel/{id}', [TicketApiController::class, 'cancel']);
});

