<?php

namespace App\Services\MedicalCoordination;

use App\Models\SocioeconomicBenefits\Insured;
use Carbon\Carbon;

class InsuredExpedientData
{
    public function forId(int|string $id): array
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

        return [
            ...$this->identity($titular),
            'datosAdscripcion' => $datosAdscripcion,
            'datosDomicilio' => $datosDomicilio,
            'datosPersonales' => $datosPersonales,
            'familiares' => $this->mapFamiliares($titular->beneficiaries),
            'credenciales' => $this->mapCredenciales($titular->credencialInsured),
        ];
    }

    public function familiaresForId(int|string $id): array
    {
        $titular = Insured::with(['affiliationStatus', 'beneficiaries'])->findOrFail($id);

        return [
            ...$this->identity($titular),
            'familiares' => $this->mapFamiliares($titular->beneficiaries),
        ];
    }

    public function credencialesForId(int|string $id): array
    {
        $titular = Insured::with([
            'affiliationStatus',
            'credencialInsured' => fn ($query) => $query->orderByDesc('issued_at'),
        ])->findOrFail($id);

        return [
            ...$this->identity($titular),
            'credenciales' => $this->mapCredenciales($titular->credencialInsured),
        ];
    }

    private function identity(Insured $titular): array
    {
        $nombreTitular = collect([$titular->last_name_1, $titular->last_name_2, $titular->name])
            ->filter(fn ($parte) => filled($parte))
            ->implode(' ');

        return [
            'id' => $titular->id,
            'nombreTitular' => $nombreTitular,
            'folioAfiliacion' => $titular->file_number,
            'tipoDerechohabiente' => 'Titular',
            'estatusAfiliacion' => $titular->affiliationStatus?->name,
            'fotoUrl' => $titular->photo
                ? asset('photo/insureds/' . $titular->file_number . '.jpg')
                : asset('images/icono_no_imagen.png'),
        ];
    }

    private function mapFamiliares($familiares): array
    {
        return $familiares->map(function ($familiar) {
            $nombre = collect([$familiar->last_name_1, $familiar->last_name_2, $familiar->name])
                ->filter(fn ($parte) => filled($parte))
                ->implode(' ');

            return [
                'nombre' => $nombre ?: null,
                'parentesco' => $familiar->relationship,
                'folio' => $familiar->file_number,
                'estatus' => $familiar->affiliate_status,
            ];
        })->all();
    }

    private function mapCredenciales($credenciales): array
    {
        return $credenciales->map(fn ($credencial) => [
            'numero' => $credencial->id,
            'emitida' => $this->formatDate($credencial->issued_at, true),
            'vigente_hasta' => $this->formatDate($credencial->expires_at),
            'motivo' => 'No especificado',
            'estatus' => $credencial->credential_status,
        ])->all();
    }

    private function formatDate(?string $date, bool $includeTime = false): ?string
    {
        if (blank($date)) {
            return null;
        }

        return Carbon::parse($date)->format($includeTime ? 'd/m/Y H:i' : 'd/m/Y');
    }
}
