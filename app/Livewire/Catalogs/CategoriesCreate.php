<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\Category;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class CategoriesCreate extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required | min:5 | max:50 | unique:categories,name')]
    public $name = '';
    #[Validate('required|decimal:2')]
    public $salary = '';
    #[Validate('required|decimal:2')]
    public $compensation = '';
    #[Validate('required|decimal:2')]
    public $complementary = '';
    #[Validate('required|decimal:2')]
    public $isr = '';
    #[Validate('required|numeric|min_digits:1 | max_digits: 3')]
    public $authorized_position;
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();
            $category= new Category();
        //Haciendo calculos de sueldo bruto y sueldo neto
        if ($this->salary !== 0 || $this->compensation !== 0 || $this->complementary !== 0) {
            $sueldo_bruto = $this->salary + $this->compensation + $this->complementary;
            $category->gross_salary = $sueldo_bruto;
            if ($this->isr !== 0) {
                $sueldo_neto = $sueldo_bruto - $this->isr;
                $category->net_salary = $sueldo_neto;
            }
        }

            $category->name = Str::of($this->name)->trim();
            $this->salary = number_format((float) $this->salary, 2, '.', '');
            $category->salary = Str::of($this->salary)->trim();
            $this->compensation = number_format((float) $this->compensation, 2, '.', '');
            $category->compensation = Str::of($this->compensation)->trim();
            $this->complementary = number_format((float) $this->complementary, 2, '.', '');
            $category->complementary = Str::of($this->complementary)->trim();
            // Forzar siempre dos decimales antes de guardar
            $this->isr = number_format((float) $this->isr, 2, '.', '');
            $category->isr = Str::of($this->isr)->trim();
            $category->authorized_position = Str::of($this->authorized_position)->trim();
            $category->covered_position = 0;
            $category->status = 'active';
            $category->modified_by = Auth::user()->email;
            $category->save();

            DB::commit();
            $this->limpiar();
            session()->flash('msg', 'Categoría : '.$category->name.' creado con éxito!');
            $this->js("alert('Categoría :".$category->name." creado con éxito!')");
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
        return view('livewire.catalogs.categories-create');
    }
}
