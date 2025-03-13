<?php

namespace App\Livewire\Users;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UsersCreate extends Component
{
    public $roles = [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|max:255')]
    public $name = '';
    #[Validate('required|string|email|max:255|unique:users')]
    public $email = '';
    #[Validate('required|string|min:8|max:9')]
    public $password = '';
    #[Validate('required')]
    public $role = '';
    public function mount()
    {
        $this->roles = Role::all();
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = Str::of($this->name)->trim();
            $user->email = Str::of($this->email)->trim();
            $pass = Str::of($this->password)->trim();
            $user->password = Hash::make($pass);
            $user->save();
            $user->assignRole($this->role);
            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'El usuario : '.$user->email.' creado con éxito!');
            $this->js("alert('El usuario :".$user->email." creado con éxito!')");
            $this->dispatch('refreshComponent');
            
            // Enviar el mensaje a la vista sin necesidad de recargar
         } catch (Exception $e) {
             DB::rollBack();
             session()->flash('msg_warning', 'Error : '.$e->getMessage().' Contacte a su Administrador.');
             $this->js("alert('Error :".$e->getMessage()." Contacte a su Administrador.')");
        }

    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {

        return view('livewire.users.users-create');
    }
}
