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
            'Protein_depthness',
            'Protein_depthness_std',
            'Tilt',
            'Tilt_std',

            'COG_of_protein',
            'COG_of_protein_std',
            'COG_BB_first',
            'COG_BB_first_std',
            'COG_BB_last',
            'COG_BB_last_std',
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

           'Contacts_Protein-lipids',
           'Contacts_Protein-lipids_std',
           'Contacts_Protein-headgroups',
           'Contacts_Protein-headgroups_std',
           'Contacts_Protein-tailgroups',
           'Contacts_Protein-tailgroups_std',
           'Contacts_Protein-solvent',
           'Contacts_Protein-solvent_std',
           'PepDF_5_distance',
           'PepDF_5_distance_std',
           'PepDF_5_angle',
           'PepDF_5_angle_std',
           'PepDF_50_distance',
           'PepDF_50_distance_std',
           'PepDF_50_angle',
           'PepDF_50_angle_std',
           'PepDF_100_distance',
           'PepDF_100_distance_std',
           'PepDF_100_angle',
           'PepDF_100_angle_std',
           'PepDF_200_distance',
           'PepDF_200_distance_std',
           'PepDF_200_angle',
           'PepDF_200_angle_std'
        ];
    }

    public function array(): array
    {
        return $this->datos;
    }
}
