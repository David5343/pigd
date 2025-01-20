<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'David Sánchez de la Cruz',
                'email' => 'david@pigd.gob.mx',
                'password' => bcrypt('david2023'),
            ],
            [
                'name' => 'Luis Adelfo Roblez Vazquez',
                'email' => 'adelfo@pigd.gob.mx',
                'password' => bcrypt('adelfo2023'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

    }
}
