<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
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
