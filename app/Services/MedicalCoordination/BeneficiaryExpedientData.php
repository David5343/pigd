<?php

namespace App\Services\MedicalCoordination;

use App\Models\SocioeconomicBenefits\Beneficiary;
use Carbon\Carbon;

class BeneficiaryExpedientData
{
    public function forId(int|string $id): array
    {
        $relations = [
            'insured.subdependency.dependency',
            'insured.rank',
            'insured.affiliationStatus',
            'credentials' => fn ($query) => $query->orderByDesc('issued_at'),
        ];

        $familiar = Beneficiary::with($relations)->findOrFail($id);
        $titular = $familiar->insured;

        $nombreFamiliar = collect([$familiar->last_name_1, $familiar->last_name_2, $familiar->name])
            ->filter(fn ($parte) => filled($parte))
            ->implode(' ');

        $datosPersonales = [
            'Fecha de nacimiento' => $this->formatDate($familiar->birthday),
            'Edad' => filled($familiar->birthday)
                ? Carbon::parse($familiar->birthday)->age.' años'
                : null,
            'RFC' => $familiar->rfc,
            'CURP' => $familiar->curp,
            'Sexo' => $familiar->sex,
            'Capacidades diferentes' => $familiar->disabled_person,
        ];

        $datosDomicilio = [
            'Domicilio registrado' => $familiar->address,
        ];

        $datosAfiliacion = [
            'Fecha de alta' => $this->formatDate($familiar->start_date),
            'Parentesco' => $familiar->relationship,
            'Estatus de afiliación' => $familiar->affiliate_status,
            'Observaciones' => $familiar->observations,
            'Fecha de baja' => $this->formatDate($familiar->inactive_date),
            'Motivo de baja' => $familiar->inactive_motive,
            'Fecha de reingreso' => $this->formatDate($familiar->reentry_date),
        ];

        $datosTitular = $titular ? [
            'Nombre del titular' => collect([$titular->last_name_1, $titular->last_name_2, $titular->name])
                ->filter(fn ($parte) => filled($parte))
                ->implode(' '),
            'Folio de afiliación' => $titular->file_number,
            'Número de empleado' => $titular->employee_number,
            'Dependencia' => $titular->subdependency?->dependency?->name,
            'Área o unidad' => $titular->subdependency?->name,
            'Estatus de afiliación' => $titular->affiliationStatus?->name,
        ] : [];

        $credenciales = $familiar->credentials->map(fn ($credencial) => [
            'numero' => $credencial->id,
            'emitida' => $this->formatDate($credencial->issued_at, true),
            'vigente_hasta' => $this->formatDate($credencial->expires_at),
            'tipo_vigencia' => $credencial->expiration_types ?: 'No especificado',
            'estatus' => $credencial->credential_status,
        ])->all();

        return [
            'id' => $familiar->id,
            'nombreFamiliar' => $nombreFamiliar,
            'folioAfiliacion' => $familiar->file_number,
            'tipoDerechohabiente' => 'Familiar',
            'estatusAfiliacion' => $familiar->affiliate_status,
            'fotoUrl' => $familiar->photo
                ? (str_starts_with($familiar->photo, 'fotografias/familiares/'.$familiar->id.'/')
                    ? route('socioeconomic_benefits.beneficiary-photo', $familiar->id)
                    : url($familiar->photo))
                : asset('images/icono_no_imagen.png'),
            'datosPersonales' => $datosPersonales,
            'datosDomicilio' => $datosDomicilio,
            'datosAfiliacion' => $datosAfiliacion,
            'datosTitular' => $datosTitular,
            'idTitular' => $titular?->id,
            'credenciales' => $credenciales,
        ];
    }

    private function formatDate(?string $date, bool $includeTime = false): ?string
    {
        if (blank($date)) {
            return null;
        }

        return Carbon::parse($date)->format($includeTime ? 'd/m/Y H:i' : 'd/m/Y');
    }
}
