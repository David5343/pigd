<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Category;
use App\Models\Catalogs\Position;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class PositionsCreate extends Component
{
    public $categories= [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent

    #[Validate('required | min:3 | max:3 | unique:positions,position_number')]
    public $position_number = '';
    #[Validate('required|string|min:5|max:45')]
    public $position_name = '';
    #[Validate('required')]
    public $category_id = '';


    public function mount()
    {
        $this->categories = Category::all();
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $position = new Position();
            $position->position_number = Str::of($this->position_number)->trim();
            $position->position_name = Str::of($this->position_name)->trim();
            $position->category_id = Str::of($this->category_id)->trim();
            $position->modified_by = Auth::user()->email;
            $position->save();
            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Puesto : '.$position->name.' creado con éxito!');
            $this->js("alert('Puesto :".$position->name." creado con éxito!')");
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
        return view('livewire.catalogs.positions-create');
    }
}
