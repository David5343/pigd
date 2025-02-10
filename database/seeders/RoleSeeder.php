<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de nombres de roles
        $roles = [
            'CoordinacionGeneral',
            'AdministracionGeneral',
            'AreaJuridica',
            'CoordinacionMedica',
            'RecursosHumanos',
            'RecursosFinancieros',
            'RecursosoMateriales',
            'PrestacionesSocioEcnomicas',
            'Tecnologias',
            'Archivo',
            'Transparencia',
            'JefaturaCoordinacion',
            'JefaturaAdministracion',
            'JefaturaJuridica',
            'JefaturaMedica',
            'JefaturaHumanos',
            'JefaturaFinancieros',
            'JefaturaMateriales',
            'JefaturaPrestaciones',
            'JefaturaTecnologias',
            'CoordinadorArchivo',
            'ResponsableTransparencia',
            'Admin',
            'Default',
        ];

        // Crear cada rol en la base de datos
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

    }
}
