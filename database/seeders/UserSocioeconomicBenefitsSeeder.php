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
//             [
//                 'name' => 'Victor Manuel Santiago Muñoz',
//                 'email' => 'vsantiago@fidsecpol.gob.mx',
//                 'password' => bcrypt('YLrAMNMi*5sJ
// '),
//             ],
//             [
//                 'name' => 'Milton Damian Ochoa',
//                 'email' => 'mdamian@fidsecpol.gob.mx',
//                 'password' => bcrypt('oK2}Z=]]q)!s'),
//             ],
            [
                'name' => 'Andrés Cabrera González',
                'email' => 'acabrera@fidsecpol.gob.mx',
                'password' => bcrypt('oK2}Z=]]q)!s'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
