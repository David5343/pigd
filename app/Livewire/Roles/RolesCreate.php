<?php

namespace App\Livewire\Roles;

use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesCreate extends Component
{
    #[Validate('required | string |max:30')]
    public $name = '';

    public function guardar()
    {
        DB::beginTransaction();
        try {
            $this->validate();
            $rol= Role::create(['name' =>$this->name,'guard_name'=>'web']);
            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'El Rol:'.$rol->name.' creado con éxito!');
            $this->js("alert('El Rol:'.$rol->name.' creado con éxito!')");

        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('msg_warning', $e->getMessage());
        }
    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.roles.roles-create');
    }
}
