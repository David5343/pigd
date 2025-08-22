<?php

namespace App\Services;

use App\Models\SocioeconomicBenefits\Insured;

class InsuredService
{
    /**
     * Limpia y crea un asegurado.
     */
    public function crearAsegurado(array $data): Insured
    {
        $dataLimpios = $this->limpiarDatos($data);

        return Insured::create($dataLimpios);
    }

    /**
     * Limpia datos nulos y pone valores por defecto.
     */
    protected function limpiarDatos(array $data): array
    {
        return [
            'nombre'   => $data['nombre'] ?? 'SIN NOMBRE',
            'email'    => $data['email'] ?? null,
            'telefono' => $data['telefono'] ?? 'SIN TELÉFONO',
            'edad'     => $data['edad'] ?? 0,
        ];
    }
}
