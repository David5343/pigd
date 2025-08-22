<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class InsuredsImport implements ToCollection
{

    public $ids = [];

    public function collection(Collection $rows)
    {
        foreach ($rows->skip(1) as $row) { // saltamos encabezado
            $this->ids[] = $row[0]; // asumimos que ID está en la columna A
        }
    }
}
