<?php

namespace App\Livewire\Catalogs;

use App\Models\Catalogs\CatalogYear;
use App\Models\Catalogs\Medication;
use App\Models\Catalogs\MedicationPrice;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MedicationSetPrice extends Component
{
    //public $medicationId;
    public $selectedMedicationId = null;
    public $visible = false;
    public $catalog_years = [];
    public $batchNumber = 0;
    public $commercialName = '';
    public string $message = '';
    public string $type = '';
    public $unit_price = 0.00;

    protected $listeners = ['openModalPrice', 'closeModal'];

    #[Validate('required')]
    public $selectedYearId  = '';
    #[Validate('required|digits_between:1,10|regex:/^\d+$/')]
    public $price_integer;
    #[Validate('required|digits_between:1,2|regex:/^\d{1,2}$/')]
    public $price_decimal;
    public function openModalPrice($medicationId)
    {
        $this->selectedMedicationId = $medicationId;
        $row = Medication::find($this->selectedMedicationId);
        if (!$row) {
            $this->message = 'Medicamento no encontrado.';
            $this->type = 'error';
            return;
        }
        $this->batchNumber = $row->batch_number;
        $this->commercialName = $row->commercial_name;
        $this->visible = true;
        $this->catalog_years = CatalogYear::all();
    }
    public function closeModal()
    {
        $this->visible = false;
        $this->reset([
            'selectedMedicationId',
            'selectedYearId',
            'price_integer',
            'price_decimal',
            'message',
            'type',
        ]);
    }
    public function guardarPrecio()
    {
        
        $this->validate([
            'selectedYearId' => 'required|exists:catalog_years,id',
            'price_integer' => 'required|numeric|min:0',
            'price_decimal' => 'required|numeric|min:0|max:99',
        ]);
        $this->unit_price = floatval("{$this->price_integer}." . str_pad($this->price_decimal ?? '00', 2, '0', STR_PAD_RIGHT));
    // Buscar por medication_id y catalog_year_id
    $existe = MedicationPrice::where('medication_id', $this->selectedMedicationId)
        ->where('catalog_year_id', $this->selectedYearId)
        ->first();

    if ($existe) {
        if ($existe->unit_price == $this->unit_price) {
            $this->message = 'Este medicamento ya tiene precio para ese año.';
            $this->type = 'error';
            return;
        } else {
            // Actualizar el precio
            $existe->unit_price = $this->unit_price;
            $existe->modified_by = Auth::user()->email;
            $existe->save();

            $this->message = 'Precio actualizado correctamente.';
            $this->type = 'success';
            $this->dispatch('updateMedicationList');
            return;
        }
    }
        
        $medicationPrice = new MedicationPrice();
        $medicationPrice->medication_id = $this->selectedMedicationId;
        $medicationPrice->catalog_year_id = $this->selectedYearId;
        $medicationPrice->unit_price = $this->unit_price;
        $medicationPrice->modified_by = Auth::user()->email;
        $medicationPrice->save();

        $this->message = 'Precio guardado correctamente.';
        $this->type = 'success';
        $this->dispatch('updateMedicationList');
    }
    public function render()
    {
        return view('livewire.catalogs.medication-set-price');
    }
}
