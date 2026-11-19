<?php

namespace App\Http\Controllers\MedicalCoordination;

use App\Http\Controllers\Controller;
use App\Models\SocioeconomicBenefits\Insured;
use Carbon\Carbon;

class InsuredMedicalController extends Controller
{
    public function index()
    {
        return view('medical_coordination.membership.index');

    }
    public function show(string $id)
    {
        $relations = [
            'subdependency.dependency',
            'rank',
            'workplaceCounty',
            'birthplaceCounty',
            'county.state',
            'affiliationStatus',
            'beneficiaries',
            'credencialInsured' => fn ($query) => $query->orderByDesc('issued_at'),
        ];

        $titular = Insured::with($relations)->findOrFail($id);

        $nombreTitular = collect([$titular->last_name_1, $titular->last_name_2, $titular->name])
            ->filter(fn ($parte) => filled($parte))
            ->implode(' ');

        $datosDomicilio = [
            'Tipo de vialidad' => $titular->roadway_type,
            'Calle' => $titular->street,
            'Número exterior' => $titular->outdoor_number,
            'Número interior' => $titular->interior_number,
            'Colonia' => $titular->neighborhood,
            'Código postal' => $titular->cp,
            'Municipio' => $titular->county?->name,
            'Entidad federativa' => $titular->county?->state?->name,
        ];

        $familiares = $titular->beneficiaries->map(function ($familiar) {
            $nombre = collect([$familiar->last_name_1, $familiar->last_name_2, $familiar->name])
                ->filter(fn ($parte) => filled($parte))
                ->implode(' ');

            return [
                'nombre' => $nombre ?: null,
                'parentesco' => $familiar->relationship,
                'folio' => $familiar->file_number,
                'estatus' => $familiar->affiliate_status,
            ];
        });

        $credenciales = $titular->credencialInsured->map(fn ($credencial) => [
            'numero' => $credencial->id,
            'emitida' => $this->formatDate($credencial->issued_at, true),
            'vigente_hasta' => $this->formatDate($credencial->expires_at),
            'motivo' => 'No especificado',
            'estatus' => $credencial->credential_status,
        ]);

        $datosAdscripcion = [
            'Dependencia de adscripción' => $titular->subdependency?->dependency?->name,
            'Área o unidad' => $titular->subdependency?->name,
            'Categoría' => $titular->rank?->name,
            'Fecha de alta en el Fideicomiso' => $this->formatDate($titular->start_date),
            'Número de empleado' => $titular->employee_number,
            'Lugar de trabajo' => $titular->workplaceCounty?->name,
            'Motivo de registro' => $titular->register_motive,
            'Observaciones' => $titular->observations,
        ];

        $datosPersonales = [
            'Fecha de nacimiento' => $this->formatDate($titular->birthday),
            'Edad' => filled($titular->birthday)
                ? Carbon::parse($titular->birthday)->age . ' años'
                : null,
            'Lugar de nacimiento' => $titular->birthplaceCounty?->name,
            'Sexo' => $titular->sex,
            'Estado civil' => $titular->marital_status,
            'RFC' => $titular->rfc,
            'CURP' => $titular->curp,
            'Teléfono' => $titular->phone,
            'Correo electrónico' => $titular->email,
            'Tipo de sangre' => $titular->blood_type,
        ];

        return view('medical_coordination.membership.show', [
            'nombreTitular' => $nombreTitular,
            'folioAfiliacion' => $titular->file_number,
            'tipoDerechohabiente' => 'Titular',
            'estatusAfiliacion' => $titular->affiliationStatus?->name,
            'fotoUrl' => $titular->photo
                ? asset('photo/insureds/' . $titular->file_number . '.jpg')
                : asset('images/icono_no_imagen.png'),
            'datosAdscripcion' => $datosAdscripcion,
            'datosDomicilio' => $datosDomicilio,
            'datosPersonales' => $datosPersonales,
            'familiares' => $familiares,
            'credenciales' => $credenciales,
        ]);

    }

    private function formatDate(?string $date, bool $includeTime = false): ?string
    {
        if (blank($date)) {
            return null;
        }

        return Carbon::parse($date)->format($includeTime ? 'd/m/Y H:i' : 'd/m/Y');
    }
}
