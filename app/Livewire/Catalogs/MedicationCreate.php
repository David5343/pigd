<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\CatalogYear;
use App\Models\Catalogs\Medication;
use App\Models\Catalogs\MedicationPrice;
use App\Models\Catalogs\MedicationUnit;
use App\Models\Catalogs\Supplier;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class MedicationCreate extends Component
{

    public $suppliers = [];
    public $medication_units = [];
    protected $listeners = ['refreshComponent' => '$refresh']; // Escucha el evento refreshComponent
    #[Validate('required|string|min:1|max:10 |unique:medications,batch_number')]
    public $batch_number = '';
    #[Validate('required|string|min:5|max:244|unique:medications,name')]
    public $name = '';
    #[Validate('required|string|min:5|max:50|unique:medications,commercial_name')]
    public $commercial_name = '';
    #[Validate('required')]
    public $medication_units_id = '';
    #[Validate('required')]
    public $supplier_id = '';
    #[Validate('nullable|date')]
    public $expiration_date = '';

    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->medication_units = MedicationUnit::all();
    }
    public function guardar()
    {

        $this->validate();

        try {
            DB::beginTransaction();

            // $medicamentoExistente = Medication::where('name', $this->name)
            //     ->where('commercial_name', $this->commercial_name)
            //     ->where('medication_units_id', $this->medication_units_id)
            //     ->where('supplier_id', $this->supplier_id)
            //     ->whereHas('prices', function ($query) {
            //         $query->where('catalog_year_id', $this->catalog_year_id);
            //     })->first();

            // if ($medicamentoExistente) {
            //     $this->dispatch('showMessage', 'Ya existe un medicamento con ese nombre, nombre comercial y precio para ese año.','error');
            //     return;
            // }            
            $medication = new Medication();
            $medication->batch_number = Str::of($this->batch_number)->trim();
            $medication->name = Str::of($this->name)->trim();
            $medication->commercial_name = Str::of($this->commercial_name)->trim();
            $medication->medication_units_id = Str::of($this->medication_units_id)->trim();
            $medication->supplier_id = $this->supplier_id;
            $medication->expiration_date = $this->expiration_date ?: null;
            $medication->modified_by = Auth::user()->email;
            $medication->save();
            // guardando en tabla medication_prices
            // $price = $this->price_integer . '.' . str_pad($this->price_decimal, 2, '0', STR_PAD_RIGHT);
            // $medication_pice = new MedicationPrice();
            // $medication_pice->medication_id = $medication->id;
            // $medication_pice->catalog_year_id = $this->catalog_year_id;
            // $medication_pice->unit_price = $price;
            // $medication_pice->modified_by = Auth::user()->email;
            // $medication_pice->save();
            DB::commit();
            $this->limpiar();
            $this->dispatch('refreshComponent');
            $this->dispatch('showMessage', 'El medicamento  : '.$medication->name.' fué creado con éxito!','success');
         } catch (Exception $e) {
             DB::rollBack();
             $this->dispatch('showMessage', 'Error : '.$e->getMessage().' Contacte a su Administrador.','error');
        }

    }
    public function limpiar()
    {
        $this->reset();
        $this->resetValidation();
        $this->suppliers = Supplier::all();
    }
    public function render()
    {
        return view('livewire.catalogs.medication-create');
    }
}
