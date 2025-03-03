<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
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
        $permisos = Permission::where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%');
        })
        ->latest() // Equivalente a orderBy('created_at', 'desc')
        ->take(50) // Tomar solo los últimos 50 registros
        ->paginate($this->numberRows);
        return view('livewire.permissions.permissions',['lista'=>$permisos]);
    }
}
