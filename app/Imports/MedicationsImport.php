<?php

namespace App\Imports;

use App\Models\Catalogs\Medication;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class MedicationsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $existing = Medication::where('name', $row['name'])
            ->where('batch_name', $row['batch_name'])
            ->first();

        if ($existing) {
            return null;
        }

            return new Medication([
                'batch_name' => $row['batch_name'],
                'name' => $row['name'],
                'commercial_name' => $row['commercial_name'],
                'medication_units_id' => $row['medication_units_id'],
                'supplier_id' => $row['supplier_id'],
                'expiration_date' => $row['expiration_date'],
                'modified_by' => Auth::user()->email,
            ]);
        }    
    }