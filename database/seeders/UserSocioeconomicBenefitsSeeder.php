<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSocioeconomicBenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users = [
            // [
            //     'name' => 'Garcia Guzman Daniela Guadalupe',
            //     'email' => 'dgarcia@fidsecpol.gob.mx',
            //     'password' => bcrypt('wN(3ai3v[xKm'),
            // ],
            // [
            //     'name' => 'Castellanos Alvarez Amparo De Los Angeles',
            //     'email' => 'acastellanos@fidsecpol.gob.mx',
            //     'password' => bcrypt('oZ_Z]@xM{f(c'),
            // ],
            // [
            //     'name' => 'Cruz Gutierrez Teresa De Jesus',
            //     'email' => 'tcruz@fidsecpol.gob.mx',
            //     'password' => bcrypt('kvReBBC[?x[2'),
            // ],
            // [
            //     'name' => 'Marin Gomez Maria Fernanda',
            //     'email' => 'mmarin@fidsecpol.gob.mx',
            //     'password' => bcrypt('nwujP5.9(jH;'),
            // ],
            // [
            //     'name' => 'Suset Del Rosario Celaya Chanona',
            //     'email' => 'scelaya@fidsecpol.gob.mx',
            //     'password' => bcrypt('0My}$F&(r+A7'),
            // ],
            // [
            //     'name' => 'Juan Carlos Montesinos Vazque',
            //     'email' => 'jmontesinos@fidsecpol.gob.mx',
            //     'password' => bcrypt('uQ2~_(uV0OP?'),
            // ],
            // [
            //     'name' => 'Alberto Duvan Cruz Molina',
            //     'email' => 'acruz@fidsecpol.gob.mx',
            //     'password' => bcrypt('kKmQV_r)xzIk'),
            // ],
            // [
            //     'name' => 'Norelly Del Rosario Munoa Camas',
            //     'email' => 'nmunoa@fidsecpol.gob.mx',
            //     'password' => bcrypt('6&(^GaIK_Y16'),
            // ],
            // [
            //     'name' => 'Ricardo Altamirano Champo',
            //     'email' => 'raltamirano@fidsecpol.gob.mx',
            //     'password' => bcrypt('euh~[PDN2}iK'),
            // ],
            // [
            //     'name' => 'Jorge Garcia Ramos',
            //     'email' => 'jgarcia@fidsecpol.gob.mx',
            //     'password' => bcrypt('m+-EX0V%p-Mk'),
            // ],
            // [
            //     'name' => 'Floriberto Patricio Vazquez',
            //     'email' => 'fpatricio@fidsecpol.gob.mx',
            //     'password' => bcrypt('c7)4L[QHSmE1'),
            // ],
            // [
            //     'name' => 'Eva Consuelo Colmenares Flores',
            //     'email' => 'ecolmenares@fidsecpol.gob.mx',
            //     'password' => bcrypt('$Q#j[t.A~X!E'),
            // ],
            // [
            //     'name' => 'Maria Guadalupe Rodriguez Hernandez',
            //     'email' => 'mrodriguez@fidsecpol.gob.mx',
            //     'password' => bcrypt('Ly1E4ofjH5k!'),
            // ],
            // [
            //     'name' => 'Jose Diaz Jardines',
            //     'email' => 'jdiaz@fidsecpol.gob.mx',
            //     'password' => bcrypt('5bWBgIQaLe_S'),
            // ],
            // [
            //     'name' => 'Jesus Elene Guzman Ovilla',
            //     'email' => 'jguzman@fidsecpol.gob.mx',
            //     'password' => bcrypt('ii$S.2@+).ti'),
            // ],
            // [
            //     'name' => 'Deysi Fabiola Marroquin Martinez',
            //     'email' => 'dmarroquin@fidsecpol.gob.mx',
            //     'password' => bcrypt('}M0B$E33K.4T'),
            // ],
            // [
            //     'name' => 'Patzy Topacio Flores Aguilar',
            //     'email' => 'pflores@fidsecpol.gob.mx',
            //     'password' => bcrypt('Ry]dp$kSeHN!'),
            // ],
            // [
            //     'name' => 'Maria Jose Vazquez Gutierrez',
            //     'email' => 'mvazquez@fidsecpol.gob.mx',
            //     'password' => bcrypt('0&?VtSmtBLmm'),
            // ],
            // [
            //     'name' => 'Nadia Fabiola Garcia Clemente',
            //     'email' => 'ngarcia@fidsecpol.gob.mx',
            //     'password' => bcrypt('qAYbdH[&vD3E'),
            // ],
            // [
            //     'name' => 'Jorge Perez Ramos',
            //     'email' => 'jperez@fidsecpol.gob.mx',
            //     'password' => bcrypt('RN9vZj4x::_ZsZ5'),
            // ],
            // [
            //     'name' => 'Candelaria Del Carme Perez Indili',
            //     'email' => 'cperez@fidsecpol.gob.mx',
            //     'password' => bcrypt('dg4_Rkz3cw9dWZw'),
            // ],
            // [
            //     'name' => 'Itzel Mendez Gutierrez',
            //     'email' => 'imendez@fidsecpol.gob.mx',
            //     'password' => bcrypt('zVBc_8zwJqAd8q_'),
            // ],
            [
                'name' => 'Gutiérrez Ramos Juan Carlos',
                'email' => 'jgutierrez@fidsecpol.gob.mx',
                'password' => bcrypt('4J7TbUNhi9T-.!T'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
        // $user = User::where('email', 'vsantiago@fidsecpol.gob.mx')->first();
        // $user->update([
        //     'password'=>bcrypt('victor2025'),
        // ]);
    }
}
