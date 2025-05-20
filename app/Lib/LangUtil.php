<?php


namespace App\Lib;


class LangUtil
{
    static $mapeoPropiedadColumna = [
        'longitud' => 'length',
        'campo_electrico' => 'electric_field',
        'temperatura' => 'temperature',
        'presion' => 'pressure',
        'particulas' => 'number_of_particles',
        'software' => 'software_name',
        'equipo' => 'supercomputer',
        'rendimiento' => 'performance',
        'campo_de_fuerza' => 'force_field',
        'timestep' => 'timestep',
    ];

    /**
     * @param $propiedad
     * @return string
     */
    static public function mapeoPropiedadColumna($propiedad) {
        return self::$mapeoPropiedadColumna[$propiedad];
    }
}
