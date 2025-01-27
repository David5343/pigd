<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiTokenUserSocioeconomicBenefitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$userEmails = ['vsantiago@fidsecpol.gob.mx', 'mdamian@fidsecpol.gob.mx'];
        $userEmails = ['acabrera@fidsecpol.gob.mx'];
        foreach ($userEmails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $this->refreshApiToken($user);
            }
        }
    }
    private function refreshApiToken(User $user)
    {
        if ($user->api_token === null) {
            // Crear un nuevo token
            $token = $user->createToken($user->email);
            $user->api_token = $token->plainTextToken;
        } else {
            // Eliminar el token existente y crear uno nuevo
            $user->tokens()->where('name', $user->email)->delete();
            $token = $user->createToken($user->email);
            $user->api_token = $token->plainTextToken;
        }

        $user->modified_by = 'david@pigd.gob.mx';
        $user->save();
    }
}
