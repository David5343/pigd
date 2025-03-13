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
    #[On('enabled_disabled')]
    public function enabledDisabled($id)
    {
        $user = User::withTrashed()->find($id); // Buscar también los eliminados
    
        if ($user) {
            if ($user->trashed()) {
                $user->restore(); // Si está eliminado, restaurarlo
            } else {
                $user->delete(); // Si está activo, deshabilitarlo
            }
    
            // Emitir un evento para actualizar la vista en Livewire
            $this->dispatch('userUpdated');
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
    #[On('userUpdated')]
    public function render()
    {
        $users = User::with('roles') // Cargar los roles de cada usuario
                        ->withTrashed()
        ->where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.users.users',['users'=>$users]);
    }
}
