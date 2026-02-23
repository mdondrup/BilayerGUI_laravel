<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class  NewAdvancedSearchCompareExport implements FromArray, WithHeadings
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
            'trajectory_id',
            'Bilayer_thickness',
            'Bilayer_thickness_std',
            
            'COG_of_membrane',
            'COG_of_membrane_std',

            'COG_headgroups_upper_leaflet',
            'COG_headgroups_upper_leaflet_std',
            'COG_headgroups_lower_leaflet',
            'COG_headgroups_lower_leaflet_std',

            'Area_per_lipid',
            'Area_per_lipid_std',
            'Area_per_lipid_upper_leaflet',
           'Area_per_lipid_upper_leaflet_std',
           'Area_per_lipid_lower_leaflet',
           'Area_per_lipid_lower_leaflet_std',

           
        ];
    }

    public function array(): array
    {
        return $this->datos;
    }
}
