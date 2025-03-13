<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    public $search = '';
    public $numberRows = 10;

    #[On('create_token')]
    public function crearToken($id)
    {
        $user = User::find($id);
        if ($user->api_token == null) {
            //tokens por default no caducan
            //Creando nuevo token
            $token = $user->createToken($user->email);
            $api_token = $token->plainTextToken;
            $user->api_token = $api_token;
            $user->modified_by = Auth::user()->email;
            $user->save();

        } else {
            //Eliminando token existente
            $user->tokens()->where('name', $user->email)->delete();
            //Creando nuevo token
            $token = $user->createToken($user->email);
            $api_token = $token->plainTextToken;
            $user->api_token = $api_token;
            $user->modified_by = Auth::user()->email;
            $user->save();
        }

    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingnumberRows()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::with('roles') // Cargar los roles de cada usuario
        ->where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.users.users',['users'=>$users]);
    }
}
