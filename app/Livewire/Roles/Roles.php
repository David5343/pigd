<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    public $search = '';
    public $numberRows = 10;

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
        $roles = Role::where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%');
        })
        ->latest() // Equivalente a orderBy('created_at', 'desc')
        //->take(50) // Tomar solo los últimos 50 registros
        ->paginate($this->numberRows);
        return view('livewire.roles.roles',['lista'=>$roles]);
    }
}
