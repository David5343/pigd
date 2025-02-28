<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersCreate extends Component
{
    public $roles;
    public function mount()
    {
        // Obtener todos los roles registrados en la base de datos
        $this->roles = Role::all();
    }
    public function render()
    {
        return view('livewire.users.users-create',['roles'=> $this->roles]);
    }
}
