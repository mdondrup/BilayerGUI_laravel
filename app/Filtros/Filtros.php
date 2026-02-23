<?php

namespace App\Filtros;

class Filtros
{
    static public function principales() {
        $filtros = [
            new Lipidos(),
           
            new Iones(),
          
            new TrayectoriaFiltro(),
            
        ];
        $result = [];
        foreach ($filtros as $filtro) {
            $result[$filtro->codigo] = $filtro;
        }

        return $result;
    }

    static public function filtrosEntidades() {
        $filtros = [
            new Lipidos(),
            
          
            new Iones(),
        
        ];
        $result = [];
        foreach ($filtros as $filtro) {
            $result[$filtro->codigo] = $filtro;
        }

        return $result;
    }

    static public function all()
    {
        $filtros = [
            new Lipidos(),            
            new Iones(),
            new Membranas(),
            new TrayectoriaFiltro(),
        

        ];

        $result = [];
        foreach ($filtros as $filtro) {
            $result[$filtro->codigo] = $filtro;
        }

        $result = array_merge($result, self::filtrosTrayectoria());

        return $result;
    }

    static public function filtrosTrayectoria()
    {
        $filtros = [
        
            new TrayectoriasFiltros('force_field','',true,'LEFT JOIN forcefields ON forcefields.id = trajectories.forcefield_id','forcefields.name')

        ];

        $result = [];
        foreach ($filtros as $filtro) {
            $result[$filtro->codigo] = $filtro;
        }

        return $result;
    }

    /**
     * @param $clave
     * @return mixed|Filtro
     */
    static public function get($clave) {
        $filtros = self::all();

        return $filtros[$clave];
    }
}
