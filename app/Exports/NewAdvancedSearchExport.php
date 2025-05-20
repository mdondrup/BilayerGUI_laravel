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
            //'resolution',
            //'membrane_model',
            'length',
            //'electric_field',
            'temperature',
            //'pressure',
            'number_of_particles',
            'software_name',
            //'supercomputer',
            //'performance',
            // Lipidos
            'lipids.short_name',
            'lipids.leaflet_1',
            'lipids.leaflet_2',
            // Peptidos
            //'peptides.name',
            //'peptides.sequence',
            //'peptides.activity',
            // 'peptides.membrane',
            //'peptides.bulk',
            // Iones
            'ions.short_name',
            //'ions.bulk',
            // Moleculas
            'heteromolecules.short_name',
            'heteromolecules.leaflet_1',
            'heteromolecules.leaflet_2',
            //'heteromolecules.bulk',
            //Aguas
            'water_models.short_name',
            // Membrane
            //'membranes.name'
        ];
    }

    public function array(): array
    {
        return $this->datos;
    }
}
