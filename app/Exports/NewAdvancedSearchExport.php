<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewAdvancedSearchExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $datos;

    public function __construct(array $datos) {
        $this->datos = $datos;
    }

    public function headings(): array
    {
        return [
            // Trayectoria
            'id',
            'force_field',
            
            'length',
            
            'temperature',
           
            'number_of_particles',
            'software_name',
            
            'lipids.short_name',
            'lipids.leaflet_1',
            'lipids.leaflet_2',
           
            'ions.short_name',
           
           
            //Aguas
            'water_models.short_name',
           
        ];
    }

    public function array(): array
    {
        return $this->datos;
    }
}
