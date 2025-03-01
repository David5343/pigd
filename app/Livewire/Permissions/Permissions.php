<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
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
        $lista = Permission::with('roles')
        ->where('name', 'like', '%'.$this->search.'%')
        ->latest() // Equivalente a orderBy('created_at', 'desc')
        ->paginate($this->numberRows);
        return view('livewire.permissions.permissions',['lista'=>$lista]);
    }
}
