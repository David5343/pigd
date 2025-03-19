<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Subdependency;
use Livewire\Component;
use Livewire\WithPagination;

class Subdependencies extends Component
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
        $subdependencies = Subdependency::where(function($query) {
            $query->Where('name', 'like', '%'.$this->search.'%');
        })
        ->orderBy('name', 'asc')
        ->paginate($this->numberRows);
        return view('livewire.catalogs.subdependencies',['lista'=>$subdependencies]);
    }
}
